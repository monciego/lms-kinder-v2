<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Response;
use App\Models\Result;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;




class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('teacher')) {
            $grade = User::findOrFail(Auth::id());
            $grade_level  = $grade->grade;
            $students_grades = Grade::with([
                'user' => function ($q) use ($grade_level) {
                    $q->where('grade', $grade_level);
                }
            ])->get();
            return view('grade', ['students_grades'=>$students_grades] );
        }
        else {
            $students_grades = Grade::where('user_id', Auth::id())->with('user')->get();
            return view('grade', ['students_grades'=>$students_grades] );
        }
    }

      public function viewPDF()
    {
            $grade = User::findOrFail(Auth::id());
            $grade_level  = $grade->grade;
            $students_grades = Grade::with([
                'user' => function ($q) use ($grade_level) {
                    $q->where('grade', $grade_level);
                }
            ])->get();
            // dd($students_grades);
        return view('view-pdf', compact('students_grades'));
    }


    public function downloadPDF()
    {

         $grade = User::findOrFail(Auth::id());
            $grade_level  = $grade->grade;
            $students_grades = Grade::with([
                'user' => function ($q) use ($grade_level) {
                    $q->where('grade', $grade_level);
                }
            ])->get();
        $pdf = Pdf::loadView('view-pdf', compact('students_grades'))->setOptions(['defaultFont' => 'sans-serif']);;
        return $pdf->download('grade.pdf');
        // return view('admin.reports.index', compact('scholars', 'sch'))->with('scholars' , $scholars);
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
        //
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
        $grade = Grade::find($id);

        if ($grade) {
            return response()->json([
                'status'=>200,
                'grade'=>$grade,
            ]);
        }
        else {
            return response()->json([
                'status'=>404,
                'grade'=>$grade,
                'id'=>$id,
                'message'=>'Grade Not Found',
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
            'grade' => 'required|string',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);

        }
        else {

            $grade = Grade::find($id);
            $grade->grade = $request->input('grade');
            $grade->save();

            return response()->json([
                'status'=>200,
                'message'=>'Grade Updated Successfully',
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
        //
    }
}
