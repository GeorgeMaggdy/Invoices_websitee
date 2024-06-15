<?php

namespace App\Http\Controllers;

use App\Models\Inovice;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Inovice::onlyTrashed()->get();

        return view('inovices.archive', compact('invoices'));
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
        $id = $request->id_invoice;

        $invoices = Inovice::withTrashed()->where('id', $id)->restore();

        session()->flash('restore_invoice');

        return redirect('/inovices');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    // public function restore(Request $request)
    // {
    //     $id = $request->id_invoice;

    //     $invoices = Inovice::where('id', $id)->withtrashed()->get();

    //     return session()->flash('restore_invoice');

    //     return redirect('/inovices');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $invoices = Inovice::withTrashed()->where('id', $request->id_invoice)->first();

        $invoices->forceDelete();

        session()->flash('delete_invoice');

        return redirect('/archive');
    }
}
