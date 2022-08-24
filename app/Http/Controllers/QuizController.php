<?php

namespace App\Http\Controllers;

use App\Models\ExamCandidate;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function index(){
if (session('user_role')=='admin'){
    return view('admin.quiz-list')->with('quiz_list',Quiz::all());
}
        return view('user.quiz-list')->with('quiz_list',Quiz::join('questions','quizzes.id','=','questions.quiz_id')->distinct('quizzes.id')
            ->select('quizzes.id as quiz_id','quizzes.*')
            ->get());
    }

    public function addQuiz(){
        return view('admin.add-quiz');
    }

    public function storeQuiz(Request $request){
        $request->validate([
            'title'=>'required',
            'from_time'=>'required',
            'to_time'=>'required',
            'duration'=>'required',

        ]);
        if (Quiz::create([
            'title'=>$request->title,
            'from_time'=>$request->from_time,
            'to_time'=>$request->to_time,
            'duration'=>$request->duration,
        ])){
            return json_encode(['message' => 'success', 'data' => 'Exam: '.$request->title.' added successfully!']);
        }
        return json_encode(['message' =>'error','data' => 'Exam: '.$request->title.' was not added. Something wrong!']);
    }
    public function updateQuiz(Request $request){
        
        if (Quiz::update([
            'title'=>$request->title,
            'from_time'=>$request->from_time,
            'to_time'=>$request->to_time,
            'duration'=>$request->duration,
        ])){
            return json_encode(['message' => 'success', 'data' => 'Exam: '.$request->title.' updated successfully!']);
        }
        return json_encode(['message' =>'error','data' => 'Exam: '.$request->title.' was not updated. Something wrong!']);
    }

    public function joinQuiz($id){
        

        ExamCandidate::create([
           'user_id'=>session('user_id'),
           'quiz_id'=>$id
        ]);

        return view('user.give-quiz')->with('quiz',Quiz::where('id',$id)->first())
            ->with('questions',Question::where('quiz_id',$id)->get())
            ->with('start_time',Carbon::now());
    }

    public function editQuiz($id){
        $quiz= Quiz::find($id);
        return view('admin.edit', compact('quiz'));
    }

    public function DeleteQuestion(Request $request)
    {
        $Question = Quiz::find($request->id);

        if($Question->delete()){
            return json_encode(['message' =>'success','data'=>'Question deleted successfully!']);
        }else{
            return json_encode(['message' =>'error','data'=>'Something wrong deleting!']);
        }
    }

}
