<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Response;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    
    public function index(Request $request)
    {
        $role; 
        $quiz_id = $request->quiz_id;
        $user_id = Auth::id();
        $questions;
        $answered_questions; 
        $count;
        $result_existance;
        $count_total_question;
      
        if(Auth::user()->hasRole('teacher'))  { 
            $role = 'teacher';
            $questions = Question::where('quiz_id', $quiz_id)->with('responses')->get();
            $quiz = Quiz::where('id' , $quiz_id)->get();
            $responses = "";
            $answered_questions = "";
            $count = "";
            $result_existance = "";
            $count_total_question = "";
        }
        else { 
            $role = 'student';
            
            $questions = Question::where('quiz_id', $quiz_id)->whereDoesntHave('responses', function ($q) { 
                $q->where('user_id', 'like', Auth::id());
            })->get();
            
            $answered_questions = Question::where('quiz_id', $quiz_id)
            ->with([
                'responses' => function ($q) use ($user_id) {
                    $q->where('user_id', $user_id);
                }
            ])
            ->whereHas('responses', function ($q) { 
                $q->where('user_id', 'like', Auth::id());
            })->get();   
                                    
            $count = $questions->count();
            
            $result_existance = Result::where('quiz_id' , $quiz_id)
            ->where('user_id', $user_id)
            ->count();
            
            $count_total_question = Question::where('quiz_id' , $quiz_id)->count();
            
            $quiz = Quiz::where('id' , $quiz_id)->get();
            $responses = Response::where('user_id', $user_id)->get();
        }
        
        
        return response()->json([ 
            'questions'=>$questions,
            'quiz'=>$quiz,
            'role'=>$role,
            'response'=>$responses,
            'answered_questions'=>$answered_questions,
            'count'=>$count,
            'result_existance'=>$result_existance,
            'count_total_question'=>$count_total_question,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'image' => 'image|mimes:jpg,png,jpeg',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'key_answer' => 'required|string',
        ]);

        if ($validator->fails()) {
        
            return response()->json([
                'status'=>400, 
                'errors'=>$validator->messages(),
            ]);
            
        }
        else { 
            
            $quiz_id = $request->quiz_id;
            
            $question = Question::create([
                'question' => $request->question,
                'option_1' => $request->option_1,
                'option_2' => $request->option_2,
                'option_3' => $request->option_3,
                'option_4' => $request->option_4,
                'key_answer' => $request->key_answer,
            ]);
            
            if($request->file('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' .$extension;
                $file->move('uploads/quiz/', $filename);
                $question->image = $filename; 
            }
            
            
            $question->quiz()->associate($quiz_id);
            $question->save();
            
            return response()->json([ 
                'status'=>200, 
                'message'=>'Question Created Successfully',
            ]);
        }
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        
        if ($question) {
            return response()->json([ 
                'status'=>200, 
                'question'=>$question,
            ]);
        }
        else { 
            return response()->json([ 
                'status'=>404, 
                'message'=>'Question Not Found',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'key_answer' => 'required|string',
        ]);

        if ($validator->fails()) {
        
            return response()->json([
                'status'=>400, 
                'errors'=>$validator->messages(),
            ]);
            
        }
        else { 
            
            $quiz_id = $request->quiz_id;
            
            $question = Question::find($id); 
            
            $question->question =  $request->input('question');
            $question->option_1 =  $request->input('option_1');
            $question->option_2 =  $request->input('option_2');
            $question->option_3 =  $request->input('option_3');
            $question->option_4 =  $request->input('option_4');
            $question->key_answer =  $request->input('key_answer');
                        
            $question->save();
            
            return response()->json([ 
                'status'=>200, 
                'message'=>'Question Updated Successfully',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();
        return response()->json([ 
            'status'=>200, 
            'question'=>$question,
            'message'=>'Question has been deleted.',
        ]);
    }
}
