<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function addQuestion($id){
        return view('admin.add-questions')->with('quiz_list',Quiz::where('id',$id)->first())
            ->with('questions',Question::where('quiz_id',$id)->get())
            ->with('quiz_id',$id);
    }

    public function storeQuestion(Request $request){
        $request->validate([
            'quiz_id'=>'required',
            'Question'=>'required',
            'option_a'=>'required',
            'option_b'=>'required',
            'option_c'=>'required',
            'option_d'=>'required',
            'correct_option'=>'required',

        ]);
        if (Question::create([
            'quiz_id'=>$request->quiz_id,
            'Question'=>$request->question,
            'option_a'=>$request->option_a,
            'option_b'=>$request->option_b,
            'option_c'=>$request->option_c,
            'option_d'=>$request->option_d,
            'correct_option'=>$request->correct_option,
        ])){
            return json_encode(['message' =>'success','data'=>'Question added successfully!']);
        }
        return json_encode(['message' =>'error','data'=>'Something wrong!']);
    }



}
