<?php

namespace App\Http\Services;

use App\Models\Question;
use App\Models\T_user;
use App\Models\Setting;

Class AnswerService {

    //Get and view the right question
    public function return_Q($idno) {

        $user = T_user::where('idno',$idno)->orderBy('id','desc')->first();
        $counter = $user->counter;
        // $data = Question::where('year','2023')->where('num','>=',$counter)->where('num','<',$counter+5)->with(['answer.stock'=>function($query) use($user){
        //     $query->where('t_user_id',$user->id);
        // }])->get();
        $year = Setting::first();
        $data = Question::where('year',$year->year)->where('num','>=',$counter)->where('num','<',$counter+5)->orderBy('num')->with(['answer.stock'=>function($query) use($user){
            $query->where('t_user_id',$user->id);
        }])->get();
        return [$data,$user];
    }
}