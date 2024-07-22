<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReproduceController extends Controller
{
    public function index() {
        $years = Question::select('year')->groupBy('year')->orderBy('year')->get();
        return view('admin.reproduce',compact('years'));
    }

    public function output(Request $request) {
        
        $fileName = 'test.csv';

        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment;'
        );

        
        $callback = function() use($request) {
            $year = $request->year;
            $questions = Question::where('year',$year)->with('answer')->orderBy('num')->get();
            $stream = fopen('php://output','w');
            $arr = array(
                '問題番号',
                '問題文',
                '試験年度',
                '回答１',
                '回答２',
                '回答３',
                '正解',
            );
            $arr = mb_convert_encoding($arr, 'SJIS', 'UTF-8');
    
            fputcsv($stream,$arr);
            foreach($questions as $question) {
                switch($question->answer->correct) {
                    case 'answer_1':
                        $correct_num = 1;
                        break;
                    case 'answer_2':
                        $correct_num = 2;
                        break;
                    case 'answer_3':
                        $correct_num = 3;
                        break;
                }

                $arrayInfo = array(
                    '問題番号' => $question->num,
                    '問題文' => $question->question,
                    '試験年度' => $question->year,
                    '回答１' => $question->answer->answer_1,
                    '回答２' => $question->answer->answer_2,
                    '回答３' => $question->answer->answer_3,
                    '正解' => $correct_num,
                );
    
                $arrayInfo = mb_convert_encoding($arrayInfo, 'SJIS', 'UTF-8');
                fputcsv($stream,$arrayInfo);
            }
    
            // dd($stream);
            fclose($stream);
        };
        

        
        // return Response::make($stream, 200, $headers); 
        return response()->streamDownload($callback, $fileName, $headers);
    }

    public function copy(Request $request) {
        $output = $request->output;
        $copy = $request->copy;

        $questions_output = Question::where('year',$output)->with('answer')->get();
        $questions_copy = Question::where('year',$copy)->delete();

        foreach($questions_output as $question) {
            DB::transaction(function() use($question,$copy) {
                $new_question = Question::create([
                    'id' => $question->id,
                    'num' => $question->num,
                    'question' => $question->question,
                    'year' => $copy,
                ]);

                Answer::create([
                    'question_id' => $new_question->id,
                    'answer_1' => $question->answer->answer_1,
                    'answer_2' => $question->answer->answer_2,
                    'answer_3' => $question->answer->answer_3,
                    'correct' => $question->answer->correct,
                ]);

            });
        }
        return to_route('admin.reproduce')->with('reproduce','複写しました。');
    }

    public function tests(Request $request) {
        $cor = $request->file('cor');
        $filePath = $cor->path();

        $cor2Path = $request->file('cor2')->storeAs('uploads', 'uploaded_file4.csv');
        $cor2FullPath = Storage::path($cor2Path);

        $cor2 = fopen($cor2FullPath,'w');
        

        $file = fopen($filePath,'r');
        $count = 0;

        while($handle = fgetcsv($file)) {
            // $question = mb_convert_encoding($handle[0],'UTF-8','SJIS');
            // $answer_1 = mb_convert_encoding($handle[1],'UTF-8','SJIS');
            // $answer_2 = mb_convert_encoding($handle[2],'UTF-8','SJIS');
            // $answer_3 = mb_convert_encoding($handle[3],'UTF-8','SJIS');

            // $data = ['',$question,'',$answer_1,$answer_2,$answer_3,''];
            // if(!isset($handle[1])) {
            //     return;
            // }
            $data = ['',$handle[0],'',$handle[1],$handle[2],$handle[3],''];
            fputcsv($cor2,$data);
        }
        fclose($file);
        fclose($cor2);
    }
}
