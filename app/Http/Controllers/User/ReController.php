<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\T_user;
use App\Models\Stock;
use App\Models\Question;
use App\Models\Setting;

class ReController extends Controller
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

        // すでに合格していたら404
        if($user->pass_fail !== 1) {
            abort(404);
        }

        $this->idno = $idno;
        $this->user = $user;

    }

    // 不合格画面
    public function index() {
        $pass_fail = 1;
        return view('user.mail.complete',compact('pass_fail'));
    }

    public function first() {
        return to_route('user.restart');
    } 

    // 不合格後の問題再表示
    public function restart() 
    {
        $stocks = Stock::where('t_user_id',$this->user->id)->get();
        $num = count($stocks);
 
        if($num < $this->user->counter) {
            return to_route('user.score');
        }

        // 間違った問題を5問づつ表示
        $counter = $this->user->counter;
        $data = Stock::where([['t_user_id',$this->user->id],['sequence','>=',$counter],['sequence','<',$counter+5]])->get();

        $user_detail = $this->user;

        // dd($data);


        return view('user.reanswer',compact('data','user_detail','num'));
    }



    // 問題を評価
    public function regrade(Request $request)
    {

        // 解答した問題をupdate
        foreach($request->item as $key => $value){
            $stock = Stock::where('t_user_id',$this->user->id)->where('answer_id',$key)->update
            ([
                'select' => $value,
            ]);
        }

        if($this->user->already == $this->user->counter) {
            $this->user->already = $this->user->already + 5;
        }
        $this->user->counter = $this->user->counter + 5;
        $this->user->save();

        return to_route('user.restart');
    }

    // 戻るボタンを押したときの処理
    public function reback() {
        $this->user->counter = $this->user->counter -5;
        $this->user->save();
        return to_route('user.restart');
    }

    public function score() {
        $stocks = Stock::where('t_user_id',$this->user->id)->with('answer')->get();
        $correct = 0;
        foreach($stocks as $stock) {
            if($stock->answer->correct == $stock->select) {
                //正解の問題を削除するプログラム
                $stock->delete();
            }
        }
        // 本番環境は101
        $set = Setting::first();
        $this->user->already = $set->number + 1;
        $this->user->counter = $set->number + 1;
        $this->user->pass_fail = 0;
        $this->user->save();
        return to_route('user.grade');
    }
}
