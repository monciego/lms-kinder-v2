<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Response;
use App\Models\Shape;
use App\Models\ShapeResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;

class ShapeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
                
        return view('shape');
    }
    
    public function showShape() { 
        $role; 
        if(Auth::user()->hasRole('teacher'))  { 
            $role = 'teacher';
            $user_id = Auth::id(); 
        
            $shapes = Shape::where('user_id', $user_id)->get();
        }
        else { 
            $role = 'student';
                        
            $shapes = Shape::all();
        }
        
      
        
        return response()->json([ 
            'shapes'=>$shapes,
            'role'=>$role,
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
            'instruction' => 'required|string',
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
            
            $shape = new Shape;
            $shape->instruction = $request->input('instruction'); 
            $shape->deadline = $request->input('deadline'); 
            
            if($request->file('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' .$extension;
                $file->move('uploads/shape/', $filename);
                $shape->image = $filename; 
            }
            
            $shape->user()->associate($user_id);
            $shape->save();
            
            return response()->json([ 
                'file'=>$request->file('image'),
                'status'=>200, 
                'message'=>'Shape Created Successfully',
            ]);
        }
    }
    
    public function storeResponses(Request $request) 
    { 
        
            
        $user_id = Auth::id();
        
        $shape_response = new ShapeResponse;
        $shape_response->image_response =  $request->input('image_response');
    
        $shape_response->user()->associate($user_id);
        $shape_response->shape()->associate($request->input('shape_id'));
        $shape_response->save();
        
        return response()->json([ 
            'status'=>200, 
            'image_response'=> $request->input('image_response'), 
            'message'=>'Shape Created Successfully',
        ]);
    
    }
    
    public function shapeResponses($id) 
    { 
    
        $student_responses = ShapeResponse::where('shape_id', $id)
        ->with('user')
        ->with('shape')
        ->get(); 
        
        return view('shape-responses', [ 'student_responses'=>$student_responses ] );
        
    }

    public function showShapeResponses($id, $user_id)
    { 
    
        $shape_responses = ShapeResponse::where('shape_id', $id)
        ->where('user_id', $user_id)
        ->with('user')
        ->with('shape')
        ->get();
        
        return view('show-shape-responses', ['shape_responses'=>$shape_responses] );
        
    }
    
    public function returnShapeScore($id)
    { 
    
        $shape_response = ShapeResponse::find($id);
        
        if ($shape_response) {
            return response()->json([ 
                'status'=>200, 
                'shape_response'=>$shape_response,
            ]);
        }
        else { 
            return response()->json([ 
                'status'=>404, 
                'message'=>'Grade Not Found',
            ]);
        }
      
    }
    
    public function updateShapeScore(Request $request, $id)
    { 
        $validator = Validator::make($request->all(), [
            'score' => 'required',
        ]);

        if ($validator->fails()) {
        
            return response()->json([
                'status'=>400, 
                'errors'=>$validator->messages(),
            ]);
            
        }
        else { 
                        
            $shape_response = ShapeResponse::find($id);
            $shape_response->score = $request->input('score');
                        
            $shape_response->save();
            
            return response()->json([ 
                'status'=>200, 
                'message'=>'Score Updated Successfully',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shape  $shape
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $role; 
        if(Auth::user()->hasRole('teacher')) { 
            $role = "teacher"; 
        }
        else { 
            $role = "student"; 
        }
        $shapes = Shape::find($id);
        
        
        $shapes_with_response = ShapeResponse::where('shape_id',$id)
        ->where('user_id', Auth::id())
        ->with(['user' => function ($q) { 
            $q->where("id", Auth::id());
        }])->get();
        
        // count shapes with response existance
        $existance = count($shapes_with_response); 
        
        if ($request->ajax()) {
            return response()->json([
                'shapes'=>$shapes,
                'role'=>$role,
                'shapes_with_response'=>$shapes_with_response,
                'existance'=>$existance,
            ]);
        }
    
        return view('show-shape', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shape  $shape
     * @return \Illuminate\Http\Response
     */
    public function edit(Shape $shape)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shape  $shape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shape $shape)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shape  $shape
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shape = Shape::find($id);
        $shape->delete();
        return response()->json([ 
            'status'=>200, 
            'shape'=>$shape,
            'message'=>'Quiz has been deleted.',
        ]);
    }
}
