<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sections = Section::all();
        $products = Product::all();

        return view('products.products', compact('sections', 'products'));
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

        // $request->validate(
        //     [
        //         'product_name' => 'required|max:255',
        //         'description' =>  'required',
        //         'section_id' => 'required',

        //     ],
        //     [
        //         'product_name.required' => 'The product name is required',
        //         'product_name.max' => 'The maximum characters for the product name is 255chars',
        //         'description.required' => 'The notes filed is required',
        //         'section_id.required' => 'You have to select a section',

        //     ]
        // );

        Product::create([

            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id,

        ]);
        session()->flash('Add', 'Product added successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = Section::where('section_name', $request->section_name)->first()->id;
        $products = Product::findorfail($request->id);
        $products->update([

            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);
        session()->flash('edit', 'Product updated sucessfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $id = $request->id;
        $products = Product::findorfail($id);
        $products->delete();

        session()->flash('delete', 'Product deleted sucessfully');
        return redirect()->back();
    }
}
