<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    $sections=  Section::all();
        return view('sections.section',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' =>  'required',
        ],[

            'section_name.required'=>'the section name is required',
                'section_name.unique'=>'the name has been taken before',
                'description.required'=>'the description text is required',


            ]


        );

               Section::create([

                   'section_name'=>$request->section_name,
                   'description'=>$request->description,
                   'created_by'=>auth()->user()->name,

               ]);
               return redirect()->back();


           }


    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id=$request->id;

        $request->validate([
            'section_name' => 'required|unique:sections|max:255'.$id,
            'description' =>  'required',
        ]
        ,[

                'section_name.required'=>'the section name is required',
                'section_name.unique'=>'the name has been taken before',
                'description.required'=>'the description text is required',

            ]

        );

        $section=Section::findorfail($id);
        $section->update([
            'section_name'=>$request->section_name,
            'description'=>$request->description,

        ]);

        session()->flash('edit','the section has been updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->id;

      $section_del= Section::findorfail($id);

      $section_del->delete();

      session()->flash('delete','Successfuly deleted!');
      return redirect('/sections');
    }
}
