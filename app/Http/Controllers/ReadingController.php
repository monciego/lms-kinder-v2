<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Response;
use App\Models\Result;
use App\Models\Reading;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class ReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('teacher')) {
            $readings = Reading::where('user_id', Auth::id())->get();
            
            return view('reading' , [ 
                'readings' => $readings
            ]);
        }
        else { 
            $readings = Reading::all();
            
            return view('reading' , [ 
                'readings' => $readings
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
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
        
            return response()->json([
                'status'=>400, 
                'errors'=>$validator->messages(),
            ]);
            
        }
        else { 
            
            $user_id = Auth::id();
            
            $reading = Reading::create([
                'title' => $request->title,
                'content' => $request->content,
            ]);
            
            
            
            $reading->user()->associate($user_id);
            $reading->save();
            
            return response()->json([ 
                'status'=>200, 
                'message'=>'Content Created Successfully',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reading  $reading
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $reading = Reading::where('id', $id)->first();
        
        return response()->json([
            "reading" => $reading,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reading  $reading
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reading = Reading::find($id);
        
        if ($reading) {
            return response()->json([ 
                'status'=>200, 
                'reading'=>$reading,
            ]);
        }
        else { 
            return response()->json([ 
                'status'=>404, 
                'reading'=>$reading, 
                'id'=>$id,
                'message'=>'Reading Not Found',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reading  $reading
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
        
            return response()->json([
                'status'=>400, 
                'errors'=>$validator->messages(),
            ]);
            
        }
        else { 
                        
            $reading = Reading::find($id);
            $reading->title = $request->input('title');
            $reading->content = $request->input('content');
                        
            $reading->save();
            
            return response()->json([ 
                'status'=>200, 
                'message'=>'Content Updated Successfully',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reading  $reading
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reading = Reading::find($id);
        $reading->delete();
        return response()->json([ 
            'status'=>200, 
            'reading'=>$reading,
            'message'=>'Reading content has been deleted.',
        ]);
    }
}
