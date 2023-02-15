<?php

namespace App\Http\Controllers;

use App\Models\ParentInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ParentInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('parent-information');
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
        $request->validate([
            'mothers_name' => 'required|string',
            'fathers_name' => 'required|string',
            'address' => 'required|string',
            'contact_number' => 'required|string|numeric',
        ]);

        
        $parent_information = new ParentInformation; 
        $parent_information->mothers_name = $request->input('mothers_name');
        $parent_information->fathers_name = $request->input('fathers_name');
        $parent_information->contact_no = $request->input('contact_number');
        $parent_information->address = $request->input('address');
        
        $parent_information->user()->associate(Auth::id());
        $parent_information->save();
        
        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ParentInformation  $parentInformation
     * @return \Illuminate\Http\Response
     */
    public function show(ParentInformation $parentInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ParentInformation  $parentInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(ParentInformation $parentInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ParentInformation  $parentInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParentInformation $parentInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ParentInformation  $parentInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParentInformation $parentInformation)
    {
        //
    }
}
