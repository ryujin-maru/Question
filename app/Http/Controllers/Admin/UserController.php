<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\T_user;
use App\Models\Question;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use SplFileObject;

class UserController extends Controller
{
    
    public function question(Request $request) {
        $displays = Question::select('year')->groupBy('year')->get();
        $setting = Setting::first(); 

        $year = $request->input('sort');
        // dd(!is_null($year));
        $query = Question::query()->orderBy('year')->orderBy('num');
        if(!is_null($year)) {
            $query->where('year',$year);
            $select = $year;
        }else{
            $query->where('year',$setting->year);
            $select = $setting->year;
        }

        $questions = $query->get();
        return view('admin.question',compact('questions','displays','select'));
    }

    public function delete(Request $request) {
        $year = $request->year;
        Question::where('year',$year)->delete();

        $set = Setting::first();
        if($set->year == $year) {
            $question = Question::groupBy('year')->select('year')->orderBy('year')->first();
            $set->year = $question->year;
        }
        
        return to_route('admin.question')->with(['success' => '削除しました。']);
    }

    public function edit(Request $request) {
        $id = $request->route('id');
        $question = Question::where('id',$id)->with('answer')->firstOrFail();
        return view('admin.detail',compact('question'));
    }

    public function questionUpdate(Request $request) {
        
        DB::transaction(function () use($request) {
            $question = Question::where('id',$request->route('id'))->with('answer')->first();

            $question->question = $request->ques;
            $question->save();

            $question->answer->answer_1 = $request->ans1;
            $question->answer->answer_2 = $request->ans2;
            $question->answer->answer_3 = $request->ans3;
            $question->answer->correct = $request->correct;
            $question->answer->save();
        });

        return to_route('admin.question')->with(['success' => '編集しました。']);
    }

    public function import() {
        return view('admin.import');
    }

    public function csv_handle(Request $request) {
        $request->validate([
            'import' => 'required|mimes:csv,txt'
        ]);
        $upload_file = $request->file('import');
        $file_path = $request->file('import')->path($upload_file);
        $file = new SplFileObject($file_path);
        $file->setFlags(SplFileObject::READ_CSV);

        $count = 1;
        foreach($file as $row) {
            if($count > 1) {
                DB::transaction(function() use($row) {
                    if(isset($row[0])) {

                        $num = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
                        $question = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
                        $year = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');
                        $answer1 = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');
                        $answer2 = mb_convert_encoding($row[4], 'UTF-8', 'SJIS');
                        $answer3 = mb_convert_encoding($row[5], 'UTF-8', 'SJIS');
                        $correct = mb_convert_encoding($row[6], 'UTF-8', 'SJIS');

                        $exist = Question::where('year',$year)->where('num',$num)->with('answer')->first();

                        switch($correct) {
                            case 1:
                                $correct_num  = "answer_1";
                            break;

                            case 2:
                                $correct_num  = "answer_2";
                            break;

                            case 3:
                                $correct_num  = "answer_3";
                            break;
                        }

                        if(is_null($exist)) {
                            $q = Question::create([
                                'num' => $num,
                                'question' => $question,
                                'year' => $year,
                            ]);
        
                            $a = Answer::create([
                                "question_id" => $q->id,
                                "answer_1" => $answer1,
                                "answer_2" => $answer2,
                                "answer_3" => $answer3,
                                "correct" => $correct_num,
                            ]);
                        }else{
                            $exist->question = $question;
                            $exist->save();

                            // dd($exist->answer->answer_1);
                            $exist->answer->answer_1 = $answer1;
                            $exist->answer->answer_2 = $answer2;
                            $exist->answer->answer_3 = $answer3;
                            $exist->answer->correct = $correct_num;
                            $exist->answer->save();
                        }
                    }
                    
                });
            }
            $count++;
        }

        return to_route('admin.import')->with(['success' => 'インポートしました。']);
    }

    public function confirm(Request $request) {
        $id = $request->route('id');
        $user = T_user::where('id',$id)->firstOrFail();
        return view('admin.confirm',compact('user'));
    }

    public function user(Request $request) {
        if($request->year !== null && $request->year !== "all") {
            $users = T_user::where('year',$request->year)->get();
        }else{
            $users = T_user::get();
        }
        $years = T_user::select('year')->groupBy('year')->orderBy('year')->get();

        return view('admin.user',compact('users','years'));
    }

    public function setting() {
        $year = Setting::first();
        $displays = Question::select('year')->groupBy('year')->get();
        return view('admin.setting',compact('year','displays'));
    } 

    public function year_up(Request $request) {
        $year = $request->year;
        $set = Setting::first();
        $set->year = $year;
        $set->number = $request->number;
        $set->correct = $request->correct;
        $set->save();
        return to_route('admin.setting')->with('success','更新しました。');
    }

    public function sort(Request $request) {
        $year = $request->year;

        $users = T_user::where('year',$year)->where('pass_fail','!=','2')->get();

        if(count($users) >= 1) {
            return to_route('admin.question')->with('success','受験中のユーザーがいます。');
        }
        
        $questions = Question::where('year',$year)->orderBy('num')->get();
        
        $ids = $request->id;
        // 問題番号変更
        foreach($ids as $index => $id) {
            if($id['name'] !== $index + 1) {
                $questions[$id['name'] - 1]->num = $index + 1;
                $questions[$id['name'] - 1]->save();
            }
        }
        return to_route('admin.question')->with('success','変更しました。');
    }

    public function user_csv(Request $request) {
        $year = $request->year;

        $query = T_user::query();
        if(!is_null($year) && $year !== 'all') {
            $query->where('year',$year);
        }
        $users = $query->get();
        
        $fileName = 'user.csv';

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment;'
        );

        $callback = function() use($users) {
            $stream = fopen('php://output','w');
            $arr = array(
                'id',
                '会員番号',
                '名前',
                '名前(カナ)',
                'ポジション',
                'メールアドレス',
                '現在回答問題',
                '回答数',
                '合否',
                '作成日',
                '修正日'
            );
            $arr = mb_convert_encoding($arr, 'SJIS', 'UTF-8');
            fputcsv($stream,$arr);

            foreach($users as $user) {
                $arrayInfo = array(
                    'id' => $user->id,
                    '会員番号' => $user->idno,
                    '名前' => mb_convert_encoding($user->name,'SJIS', 'UTF-8'),
                    '名前(カナ)' => mb_convert_encoding($user->name_kana,'SJIS', 'UTF-8'),
                    'ポジション' => mb_convert_encoding($user->position,'SJIS', 'UTF-8'),
                    'メールアドレス' => $user->email,
                    '現在回答問題' => $user->year,
                    '回答数' => $user->counter,
                    '合否' => $user->pass_fail,
                    '作成日' => $user->created_at,
                    '修正日' => $user->updated_at,
                );
                // $arrayInfo= mb_convert_encoding($arrayInfo, 'SJIS', 'UTF-8');
                fputcsv($stream,$arrayInfo);
            }

            fclose($stream);

        };
        return response()->streamDownload($callback, $fileName, $headers);

    }

}
