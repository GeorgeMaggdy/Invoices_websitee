<?php

namespace App\Http\Controllers;

use App\Models\Inovice;
use App\Models\Inovices_attachments;
use App\Models\Inovices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;


class InovicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {

        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Inovices_details $inovices_details)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = Inovice::where('id', $id)->first();

        $details = Inovices_details::where('id_Invoice', $id)->get();

        $attachments = Inovices_attachments::where('invoice_id', $id)->get();

        return view('inovices.details', compact('invoices', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function get_file($invoice_number, $file_name)
    {

        $dir = "Attachments";
        $content = public_path($dir . '/' . $invoice_number . '/' . $file_name);
        return response()->download($content);
    }

    public function open_file($invoice_number, $file_name)
    {

        $dir = "Attachments";
        $file = public_path($dir . '/' . $invoice_number . '/' . $file_name);
        return response()->file($file);
    }

    public function update(Request $request, Inovices_details $inovices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = Inovices_attachments::findorfail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('delete', 'Your attachment has been deleted sucessfully');
        return back();
    }
}
