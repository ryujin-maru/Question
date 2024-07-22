<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\T_user;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Date;

class QuestionController extends Controller
{

    public function index(Request $request) {
        //リファラを確認してsessionに保存処理

        //ユーザーチェック
        $user = T_user::where('idno',$request->idno)->orderBy('created_at','desc')->first();
        if(is_null($user)) {
            $user = T_user::createUser($request);
        }

        //合否チェック
        if($user->pass_fail == 2) {
            $pass = true;
        }else{
            $pass = false;
        }

        //有効期限30日以内
        $date = new Carbon($user->created_at);
        $now = Carbon::now();
        $deadline = Carbon::create($date)->diffInDays(Carbon::create($now));

        if($deadline > 30) {

            //合格かつ期限切れで新ユーザー作成
            if($pass) {
                $user = T_user::createUser($request);
            }else{
                $data = '有効期限切れ';
                return view('user.index',compact('data'));
            }
        }

        //ユーザーデータセッションに保存
        $request->session()->put('idno',$user->idno);

        return to_route('user.answer');
        
    }
}
