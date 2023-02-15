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

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            'quiz_name' => 'required|string|max:255',
            'instruction' => 'required|string',
            'deadline' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else {
            $user_id = Auth::id();

            $quiz = new Quiz;
            $quiz->quiz_name = $request->input('quiz_name');
            $quiz->instruction = $request->input('instruction');
            $quiz->deadline = $request->input('deadline');
            $quiz->category = $request->input('category');


            $quiz->subject()->associate($request->input('subject_id'));
            $quiz->user()->associate($user_id);
            $quiz->save();

            return response()->json([
                'status'=>200,
                'message'=>'Quiz Created Successfully',
            ]);
        }
    }

    public function storeResult(Request $request)
    {

        $quiz_id = $request->quiz_id;
        $user_id = Auth::id();
        $result = new Result;
        $result->score = $request->score;

        $result->user()->associate($user_id);
        $result->quiz()->associate($quiz_id);
        $result->save();
        return response()->json([
            'quiz_id'=>$quiz_id,
            'message'=>'Score added successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $quiz_id = $id;
        $user_id = Auth::id();

        if(Auth::user()->hasRole('teacher'))  {
            $questions = Question::where('quiz_id', $quiz_id)->with('responses')->get();
            $quiz = Quiz::where('id',$quiz_id)->first();

            if ($request->ajax()) {
                return response()->json([
                    'message'=>'Question Added Successfully'
                ]);
            }

            return view('question', [
                'questions' => $questions,
                'quiz' => $quiz,
                'quiz_id' => $quiz_id
            ]);
        }
        else {
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

            $quiz = Quiz::where('id',$quiz_id)->first();
            $responses = Response::where('user_id', $user_id)->get();

            $score = [];

            foreach($answered_questions as $answered_question ) {
                foreach ($answered_question->responses as $response ) {
                    if ($answered_question-> key_answer == $response->answer) {
                        $score[] = $response->answer;
                    }
                }
            }
            $score = count($score);

            if ($request->ajax()) {
                return response()->json([
                    'answered_questions'=>$answered_questions,
                    'count'=>$count,
                    'quiz_id'=>$quiz_id,
                    'result_existance'=>$result_existance,
                    'score'=>$score,
                ]);
            }

            return view('question', [
                'questions' => $questions,
                'answered_questions' => $answered_questions,
                'quiz' => $quiz ,
                'count'=>$count,
                'quiz_id' => $quiz_id ,
                'count_total_question' => $count_total_question,
                'score' => $score
            ]);
        }

    }

    public function showMathProblem()
    {
        return view('math-problem');
    }

    public function showColor()
    {
        return view('color');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showQuizResponses($id){

        $results = Result::where('quiz_id', $id)
        ->with('user')
        ->with(['quiz' => function ($q) use ($id) {
            $q->where('id', $id);
        }
        ])
        ->get();

        $questions_count = Question::where('quiz_id', $id)
        ->count();


        // $quiz = Quiz::where('id', $id)->get();
        return view('response', [
            'results' => $results,
            'questions_count' => $questions_count
        ]);

    }

    public function showQuizResponseAnswers($id, $quiz_id) {

        $user_id = $id;
        $answered_questions = Question::where('quiz_id', $quiz_id)
        ->with([
            'responses' => function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            }
        ])
        ->get();

        $quiz = Quiz::where('id', $quiz_id)
        ->with(['results' => function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            }
        ])
        ->first();
        $count_total_question = count($answered_questions);

        return view('response-answers', [
            'answered_questions' => $answered_questions,
            'count_total_question' => $count_total_question,
            'quiz' => $quiz
        ]);

    }

    public function showColorQuizzes() {
        $role ;
        if(Auth::user()->hasRole('teacher')) {
            $role = "teacher";
            $user_id = Auth::id();
            $quizzes = Quiz::where('user_id', $user_id)
            ->where('category', 'color')
            ->with('user')
            ->get();


            return response()->json([
                'quizzes'=>$quizzes,
                'role'=>$role,
            ]);
        }
        else {
            $role = "student";
            $quizzes = Quiz::with('user')
            ->where('category', 'color')
            ->with('user')
            ->get();


            return response()->json([
                'quizzes'=>$quizzes,
                'role'=>$role,
            ]);
        }
    }

    public function showMathProblemQuizzes() {
        $role ;
        if(Auth::user()->hasRole('teacher')) {
            $role = "teacher";
            $user_id = Auth::id();
            $quizzes = Quiz::where('user_id', $user_id)
            ->where('category', 'math-problem')
            ->with('user')
            ->get();


            return response()->json([
                'quizzes'=>$quizzes,
                'role'=>$role,
            ]);
        }
        else {
            $role = "student";
            $quizzes = Quiz::with('user')
            ->where('category', 'math-problem')
            ->with('user')
            ->get();


            return response()->json([
                'quizzes'=>$quizzes,
                'role'=>$role,
            ]);
        }
    }

    public function showQuizzes(Request $request, $id) {

        if(Auth::user()->hasRole('teacher')) {

            $user_id = Auth::id();
            $quizzes = Quiz::where('user_id', $user_id)
            ->where('category', 'quiz')
            ->where('subject_id', $id)
            ->with('user')
            ->get();

            return view('quiz', ['quizzes'=> $quizzes, 'subject_id'=> $id]);

        }
        else {

            $quizzes = Quiz::with('user')
            ->where('category', 'quiz')
            ->where('subject_id', $id)
            ->with('user')
            ->get();

            return view('quiz', ['quizzes'=> $quizzes, 'subject_id'=> $id]);
        }

    }

    public function showExercises(Request $request, $id) {

        if(Auth::user()->hasRole('teacher')) {

            $user_id = Auth::id();
            $quizzes = Quiz::where('user_id', $user_id)
            ->where('category', 'exercise')
            ->where('subject_id', $id)
            ->with('user')
            ->get();

            return view('exercise', ['quizzes'=> $quizzes, 'subject_id'=> $id]);

        }
        else {

            $quizzes = Quiz::with('user')
            ->where('category', 'exercise')
            ->where('subject_id', $id)
            ->with('user')
            ->get();

            return view('quiz', ['quizzes'=> $quizzes, 'subject_id'=> $id]);
        }

    }

    public function showExaminations(Request $request, $id) {

        if(Auth::user()->hasRole('teacher')) {

            $user_id = Auth::id();
            $quizzes = Quiz::where('user_id', $user_id)
            ->where('category', 'exams')
            ->where('subject_id', $id)
            ->with('user')
            ->get();

            return view('exam', ['quizzes'=> $quizzes, 'subject_id'=> $id]);

        }
        else {

            $quizzes = Quiz::with('user')
            ->where('category', 'exams')
            ->where('subject_id', $id)
            ->with('user')
            ->get();

            return view('exam', ['quizzes'=> $quizzes, 'subject_id'=> $id]);
        }

    }

    public function edit($id)
    {


        $quiz = Quiz::find($id);

        if ($quiz) {
            return response()->json([
                'status'=>200,
                'quiz'=>$quiz,
            ]);
        }
        else {
            return response()->json([
                'status'=>404,
                'message'=>'Quiz Not Found',
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
            'quiz_name' => 'required|string|max:255',
            'instruction' => 'string',
            'deadline' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);

        }
        else {

            $quiz = Quiz::find($id);

            if ($quiz) {

                $quiz->quiz_name = $request->input('quiz_name');
                $quiz->instruction = $request->input('instruction');
                $quiz->deadline = $request->input('deadline');
                $quiz->save();

                return response()->json([
                    'status'=>200,
                    'message'=>'Quiz Updated Successfully',
                    'quiz'=>$quiz,
                ]);

            }
            else {

                return response()->json([
                    'status'=>404,
                    'message'=>'Account Not Found',
                ]);

            }

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
        $quiz = Quiz::find($id);
        $quiz->delete();
        return response()->json([
            'status'=>200,
            'quiz'=>$quiz,
            'message'=>'Quiz has been deleted.',
        ]);
    }
}
