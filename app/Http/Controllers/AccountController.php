<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Grade;
use App\Models\Result;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $users = User::all()->except(Auth::id());
        }
        else {
            $teacher = User::where('id',Auth::id())->first();
            $grade = $teacher->grade;
            $users = User::whereRoleIs('student')->where('grade', $grade)->get();
        }
        return view('account', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function studentProgress($id)
    {
      /* $grade = Subject::where('id', $id)->with('grade_level')->first();
        $grade_id = $grade->grade_level->id;
        $students = User::with('results', 'grades')->where('grade', $grade_id)->whereRoleIs('student')->get();

        $results = Result::with('quiz', 'user')->get();
        dd($results); */
        
        $student = User::findOrFail($id);
        $student_grade_level = $student->grade; 
        
        // english
        $english = Subject::where('subject_name', 'english')
                        ->where('grade_level_id', $student_grade_level)
                        ->first();
        $english_id = $english->id;
        $english_quizzes = Quiz::where('subject_id', $english_id)->get();
        $english_total_quiz = count($english_quizzes); 
        
        $english_quiz_id = [];
        foreach($english_quizzes as $english_quiz ) {
            $english_quiz_id[] = $english_quiz->id;
        }
        
        $english_student_response_count = Result::whereIn('quiz_id', $english_quiz_id)
                            ->where('user_id', $id)
                            ->count();
                            
        if($english_total_quiz > 0)
        {
            $english_progress_decimal = $english_student_response_count / $english_total_quiz; 
            $english_progress_percentage = $english_progress_decimal * 100;
        }
        else 
        {
            $english_progress_percentage = 0;
        }
        
        
        // math
        $math = Subject::where('subject_name', 'math')
                        ->where('grade_level_id', $student_grade_level)
                        ->first();
        $math_id = $math->id;
        $math_quizzes = Quiz::where('subject_id', $math_id)->get();
        $math_total_quiz = count($math_quizzes); 
        
        $math_quiz_id = [];
        foreach($math_quizzes as $math_quiz ) {
            $math_quiz_id[] = $math_quiz->id;
        }
        
        $math_student_response_count = Result::whereIn('quiz_id', $math_quiz_id)
                            ->where('user_id', $id)
                            ->count();
                            
        if($math_total_quiz > 0)
        {
            $math_progress_decimal = $math_student_response_count / $math_total_quiz; 
            $math_progress_percentage = $math_progress_decimal * 100;
        }
        else 
        {
            $math_progress_percentage = 0;
        }
        
        // science
        $science = Subject::where('subject_name', 'science')
                        ->where('grade_level_id', $student_grade_level)
                        ->first();
        $science_id = $science->id;
        $science_quizzes = Quiz::where('subject_id', $science_id)->get();
        $science_total_quiz = count($science_quizzes); 
        
        $science_quiz_id = [];
        foreach($science_quizzes as $science_quiz ) {
            $science_quiz_id[] = $science_quiz->id;
        }
        
        $science_student_response_count = Result::whereIn('quiz_id', $science_quiz_id)
                            ->where('user_id', $id)
                            ->count();
                            
        if($science_total_quiz > 0)
        {
            $science_progress_decimal = $science_student_response_count / $science_total_quiz; 
            $science_progress_percentage = $science_progress_decimal * 100;
        }
        else 
        {
            $science_progress_percentage = 0;
        }
        
        
        // filipino
        $filipino = Subject::where('subject_name', 'filipino')
                        ->where('grade_level_id', $student_grade_level)
                        ->first();
        $filipino_id = $filipino->id;
        $filipino_quizzes = Quiz::where('subject_id', $filipino_id)->get();
        $filipino_total_quiz = count($filipino_quizzes); 
        
        $filipino_quiz_id = [];
        foreach($filipino_quizzes as $filipino_quiz ) {
            $filipino_quiz_id[] = $filipino_quiz->id;
        }
        
        $filipino_student_response_count = Result::whereIn('quiz_id', $filipino_quiz_id)
                            ->where('user_id', $id)
                            ->count();
                            
        if($filipino_total_quiz > 0)
        {
            $filipino_progress_decimal = $filipino_student_response_count / $filipino_total_quiz; 
            $filipino_progress_percentage = $filipino_progress_decimal * 100;
        }
        else 
        {
            $filipino_progress_percentage = 0;
        }
        
        
        // mapeh
        $mapeh = Subject::where('subject_name', 'mapeh')
                        ->where('grade_level_id', $student_grade_level)
                        ->first();
        $mapeh_id = $mapeh->id;
        $mapeh_quizzes = Quiz::where('subject_id', $mapeh_id)->get();
        $mapeh_total_quiz = count($mapeh_quizzes); 
        
        $mapeh_quiz_id = [];
        foreach($mapeh_quizzes as $mapeh_quiz ) {
            $mapeh_quiz_id[] = $mapeh_quiz->id;
        }
        
        $mapeh_student_response_count = Result::whereIn('quiz_id', $mapeh_quiz_id)
                            ->where('user_id', $id)
                            ->count();
                            
        if($mapeh_total_quiz > 0)
        {
            $mapeh_progress_decimal = $mapeh_student_response_count / $mapeh_total_quiz; 
            $mapeh_progress_percentage = $mapeh_progress_decimal * 100;
        }
        else 
        {
            $mapeh_progress_percentage = 0;
        }
        
        
        // mtb
        $mtb = Subject::where('subject_name', 'mtb')
                        ->where('grade_level_id', $student_grade_level)
                        ->first();
        $mtb_id = $mtb->id;
        $mtb_quizzes = Quiz::where('subject_id', $mtb_id)->get();
        $mtb_total_quiz = count($mtb_quizzes); 
        
        $mtb_quiz_id = [];
        foreach($mtb_quizzes as $mtb_quiz ) {
            $mtb_quiz_id[] = $mtb_quiz->id;
        }
        
        $mtb_student_response_count = Result::whereIn('quiz_id', $mtb_quiz_id)
                            ->where('user_id', $id)
                            ->count();
                            
        if($mtb_total_quiz > 0)
        {
            $mtb_progress_decimal = $mtb_student_response_count / $mtb_total_quiz; 
            $mtb_progress_percentage = $mtb_progress_decimal * 100;
        }
        else 
        {
            $mtb_progress_percentage = 0;
        }
        
        
        return view('students-progress', [
            'student' => $student,
        
            'english_total_quiz' => $english_total_quiz,
            'english_student_response_count' => $english_student_response_count,
            'english_progress_percentage' => $english_progress_percentage,
            
            'math_total_quiz' => $math_total_quiz,
            'math_student_response_count' => $math_student_response_count,
            'math_progress_percentage' => $math_progress_percentage,
            
            'science_total_quiz' => $science_total_quiz,
            'science_student_response_count' => $science_student_response_count,
            'science_progress_percentage' => $science_progress_percentage,
            
            'filipino_total_quiz' => $filipino_total_quiz,
            'filipino_student_response_count' => $filipino_student_response_count,
            'filipino_progress_percentage' => $filipino_progress_percentage,
            
            'mapeh_total_quiz' => $mapeh_total_quiz,
            'mapeh_student_response_count' => $mapeh_student_response_count,
            'mapeh_progress_percentage' => $mapeh_progress_percentage,
            
            'mtb_total_quiz' => $mtb_total_quiz,
            'mtb_student_response_count' => $mtb_student_response_count,
            'mtb_progress_percentage' => $mtb_progress_percentage,
        ]);
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else {

            if($request->role_id == 'admin') {
                $grade_level = null;
            }
            else {
                $grade_level = $request->grade;
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'grade' => $grade_level,
                'password' => Hash::make($request->password),
            ]);
            $user->attachRole($request->role_id);

            $user_id = $user->id;

            if ($user->hasRole('student')) {
                $grade = Grade::create([
                    'user_id' => $user_id,
                    'grade' => 'n/a'
                ]);
            }

            return response()->json([
                'status'=>200,
                'status'=>$user_id,
                'grade_level'=>$grade_level,
                'message'=>'Account Created Successfully',
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
        $user = User::where('id', $id)->with('parent_information')->get();
        return view('parents-information-view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if ($user->hasRole('admin ')) {
            $show_grade_level = false;
        }
        else {
            $show_grade_level = true;
        }

        if ($user) {
            return response()->json([
                'status'=>200,
                'show_grade_level'=>$show_grade_level,
                'user'=>$user,
            ]);
        }
        else {
            return response()->json([
                'status'=>404,
                'message'=>'Account Not Found',
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);

        }
        else {

            $user = User::find($id);

            if ($user) {

                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->grade = $request->input('grade');
                $user->password = Hash::make($request->input('password'));
                $user->save();

                if ($request->ajax()) {
                    return response()->json([
                        'status'=>200,
                        'message'=>'Account Updated Successfully',
                        'user'=>$user,
                    ]);
                }

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
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'status'=>200,
            'user'=>$user,
            'message'=>'Account has been deleted.',
        ]);
    }
}
