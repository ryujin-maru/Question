<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\T_user;
use Illuminate\Http\Request;
use App\Http\Services\AnswerService;
use App\Models\Stock;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Setting;

//It's now up to you to check what lies ahead 
class AnswerController extends Controller
{
    // session情報
    private $idno;
    // ユーザー情報
    private $user;

    public function __construct(Request $request)
    {
        //セッション確認、無かったら404へ遷移
        $idno = $request->session()->get('idno');
        if(is_null($idno)) {
            abort(404);
        }
        
        $user = T_user::where('idno',$idno)->orderBy('id','desc')->first();
        
        if($user->pass_fail == 1) {
            // return abort(to_route('user.restart.index'));
        }

        $this->idno = $idno;
        $this->user = $user;
    }

    // 問題表示
    public function index(Request $request,AnswerService $answerService) 
    {
        //適切な問題を取得して表示
        $array = $answerService->return_Q($this->idno);
        list($data,$user_detail) = $array;

        $set = Setting::first();
        if($user_detail->counter >= $set->number + 1) {
            return to_route('user.grade');
        }


        return view('user.question',compact('data','user_detail','set'));
    }


    // 回答したときの処理
    public function deal(Request $request) 
    {
        // 不正解の問題をストックテーブルに保存

        $set = Setting::first();
        if($this->user->counter >= $set->number + 1) {
            return to_route('user.grade');
        }

        for($i = $this->user->counter;$i < $this->user->counter+5;$i++) {
            $question = Question::where('num',$i)->where('year',$request->year)->with('answer')->first();
            if($question->answer->correct !== $request->$i) {

                $wrong = Stock::where('t_user_id',$this->user->id)->where('answer_id',$question->answer->id)->orderBy('created_at','desc')->first();

                if(is_null($wrong)) {
                    // stockに値がなかったら作成
                    $stock = Stock::create([
                        'answer_id' => $question->answer->id,
                        't_user_id' => $this->user->id,
                        'select' => $request->$i
                    ]);
                }else{
                    // stockに値があったら更新
                    $wrong->select = $request->$i;
                    $wrong->save();
                }

            }else{
                $wrong = Stock::where('t_user_id',$this->user->id)->where('answer_id',$question->answer->id)->orderBy('updated_at','desc')->first();

                // 不正解の問題があり、正解したら値を削除
                if(!is_null($wrong)) {
                    $wrong->delete();
                }

            }
        }

        // t_user更新
        if($this->user->counter == $this->user->already) {
            $this->user->already = $this->user->already + 5;
        }
        $this->user->counter = $this->user->counter + 5;
        $this->user->save();

        // 回答終了 
        if($this->user->counter >= $set->number + 1) {
            return to_route('user.grade');
        }

        return to_route('user.answer');
    }

    // 戻るボタンを押したとき
    public function back(Request $request) 
    {
        $set = Setting::first();
        if($this->user->counter >= $set->number + 1) {
            return to_route('user.grade');
        }

        $this->user->counter = $this->user->counter - 5;
        $this->user->save();
        return to_route('user.answer');
    }

    // 正答判定結果
    public function grade(Request $request) 
    {

        $set = Setting::first();
        if($this->user->already !== $set->number + 1) {
            return to_route('user.answer');
        }

        $stocks = Stock::where('t_user_id',$this->user->id)->get();
        
        if(count($stocks) <= $set->correct) {
            // 合格メール送信プログラム記述
            $data = [
                'name' => $this->user->name,
                'name_kana' => $this->user->name_kana,
                'email' => $this->user->email,
            ];

            if($this->user->pass_fail !== 2 ) {
                $fail = Mail::to($data['email'])->send(new SendMail($data));
                Mail::to('test@test.com')->send(new SendMail($data));
            }

            $this->user->pass_fail = 2;
            $this->user->save();

            $pass_fail = 2;
        }else{
            // 不合格で再度試験画面へ
            $this->user->pass_fail = 1;
            $this->user->counter = 1;
            $this->user->already = 1;
            $this->user->save();


            foreach($stocks as $num => $stock) {
                $stock->sequence = $num + 1;
                $stock->save();
            }

            $pass_fail = 1;
        }

        // $this->user->quantity = count($stocks);
        // $this->user->save();

        return view('user.mail.complete',compact('pass_fail'));
    }

}


