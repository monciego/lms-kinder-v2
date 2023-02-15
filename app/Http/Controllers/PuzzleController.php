<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Response;
use App\Models\Shape;
use App\Models\ShapeResponse;
use App\Models\Puzzle;
use App\Models\PuzzleResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class PuzzleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('teacher')) { 
            $puzzles = Puzzle::where('user_id', Auth::id())->with('user')->get();
            return view('puzzle', [
                'puzzles'=>$puzzles,
            ]);
        }
        else { 
            $puzzles = Puzzle::all();
            return view('puzzle', [ 
                'puzzles'=>$puzzles,
            ]);
        }
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
            'image' => 'required|image|mimes:jpg,png,jpeg',
            'title' => 'required|string',
            'deadline' => 'required|string',
        ]);

        if ($validator->fails()) {
        
            return response()->json([
                'status'=>400, 
                'errors'=>$validator->messages(),
            ]);
            
        }
        else { 
            
            $user_id = Auth::id();
            
            $puzzle = new Puzzle;
            $puzzle->title = $request->input('title'); 
            $puzzle->deadline = $request->input('deadline'); 
            
            if($request->file('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' .$extension;
                $file->move('uploads/puzzle/', $filename);
                $puzzle->image = $filename; 
            }
            
            $puzzle->user()->associate($user_id);
            $puzzle->save();
            
            return response()->json([ 
                'puzzle'=>$request->file('image'),
                'status'=>200, 
                'message'=>'Shape Created Successfully',
            ]);
        }
    }
    
    public function storePuzzleResponse(Request $request) 
    { 
        $validator = Validator::make($request->all(), [
            'puzzle_image' => 'required',
        ]);
        
        if ($validator->fails()) {
        
            return response()->json([
                'status'=>400, 
                'message'=>'aaaaa', 
                'errors'=>$validator->messages(),
            ]);
            
        } 
        else { 
            $user_id = Auth::id();
        
            $puzzle_response = new PuzzleResponse;
            $puzzle_response->image =  $request->puzzle_image;
        
            $puzzle_response->user()->associate($user_id);
            $puzzle_response->puzzle()->associate($request->puzzle_id);
            $puzzle_response->save();
            
            return response()->json([ 
                'status'=>200, 
                'puzzle_imageadewwdwd'=>$request->puzzle_image,
                'puzzle_id'=>$request->puzzle_id,
                'message'=>'Puzzle Created Successfully',
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        
        if ($request->ajax()) { 
            return response()->json([ 
                'message'=>'title',
            ]);
        }
        
        $puzzle = Puzzle::where('id', $id)->get();
        $response = PuzzleResponse::where('puzzle_id', $id)->where('user_id', Auth::id())->get();
        
        
        $count = count($response);
        return view('show-puzzle', [ 
            'puzzle'=>$puzzle,
            'count'=>$count,
            'response'=>$response,
        ]);
    }
    
    public function showPuzzleResponseTable(Request $request, $id)
    { 
        $puzzle_responses =  PuzzleResponse::where('puzzle_id', $id)->with('user')->get();
        
        return view('show-puzzle-response-table', [
            'puzzle_responses'=>$puzzle_responses,
        ]);
    }
    
    public function showPuzzleResponseTeacher(Request $request, $id , $user_id) 
    { 
        $response = PuzzleResponse::where('puzzle_id', $id)->where('user_id', $user_id)->get();
        return view('show-puzzle-response-teacher', [ 
            'response'=>$response,
        ]);
    }
    
    public function editScore($id) { 
        $puzzle_response = PuzzleResponse::find($id);
        
        if ($puzzle_response) {
            return response()->json([ 
                'status'=>200, 
                'puzzle_response'=>$puzzle_response,
            ]);
        }
        else { 
            return response()->json([ 
                'status'=>404, 
                'puzzle_response'=>$puzzle_response, 
                'id'=>$id,
                'message'=>'Grade Not Found',
            ]);
        }
    }
    
    public function updateScore(Request $request, $id) { 
                        
        $puzzle_response = PuzzleResponse::find($id);
        $puzzle_response->score = $request->input('score');             
        $puzzle_response->save();
        
        return response()->json([ 
            'status'=>200, 
            'message'=>'Score Updated Successfully',
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $puzzle = puzzle::find($id);
        $puzzle->delete();
        return response()->json([ 
            'status'=>200, 
            'puzzle'=>$puzzle,
            'message'=>'Puzzle has been deleted.',
        ]);
    }
}
