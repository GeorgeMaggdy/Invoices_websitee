<?php

namespace App\Http\Controllers;

use App\Models\Inovice;
use App\Models\Inovices_attachments;
use App\Models\Inovices_details;
use App\Models\User;

//use http\Client\Curl\User;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AddInvoice;
use Illuminate\Support\Facades\Notification;
use App\Models\Section;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Auth;
//use App\Http\Controllers\User;
// use Illuminate\Foundation\Auth\User;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class InoviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $invoices = Inovice::all();
        return view('inovices.inovices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('inovices.add_inovices', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $invoices = Inovice::create([

            'invoice_number' => $request->invoice_number,

            'invoice_Date' => $request->invoice_Date,

            'Due_date' => $request->Due_date,

            'section_id' => $request->Section,

            'product' => $request->product,

            'Amount_collection' => $request->Amount_collection,

            'Amount_Commission' => $request->Amount_Commission,

            'Value_VAT' => $request->Value_VAT,

            'Rate_VAT' => $request->Rate_VAT,

            'Discount' => $request->Discount,

            'Total' => $request->Total,

            'Status' =>  'unpaid',

            'Value_Status' => 2,

            'note' => $request->note,



        ]);

        $invoice_id = Inovice::latest()->first()->id;
        $invoice_detatils = Inovices_details::create([

            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' =>  'unpaid',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => Auth()->user()->name,


        ]);

        if ($request->hasFile('pic')) {


            $invoice_id = Inovice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Inovices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            //move the pic

            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


//        $user = User::get();
//        $invoices = Inovice::latest()->first();
//        Notification::send($user, new \App\Notifications\AddInvoice($invoices));



        session()->flash('Add', 'Your bill has been added sucessfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */

    public function display($id)
    {

        $invoices = Inovice::where('id', $id)->first();

        return view('inovices.update_status', compact('invoices'));
    }


    public function read($id)
    {

        $invoices = Inovice::where('id', $id)->first();

        return view('inovices.invoice_print', compact('invoices'));
    }

    public function show($id)
    {
        $invoices = Inovice::where('id', $id)->first();
        $sections = Section::all();
        return view('inovices.edit_inovice', compact('invoices', 'sections'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = Inovice::where('id', $id)->first();

        $details = Inovices_details::where('id_invoice', $id)->get();

        $attachments = Inovices_attachments::where('invoice_id', $id)->get();

        return view('details', compact('invoices', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $invoices = Inovice::findorfail($request->invoice_id);
        $invoices->update([

            'invoice_number' => $request->invoice_number,

            'invoice_Date' => $request->invoice_Date,

            'Due_date' => $request->Due_date,

            'section_id' => $request->Section,

            'product' => $request->product,

            'Amount_collection' => $request->Amount_collection,

            'Amount_Commission' => $request->Amount_Commission,

            'Value_VAT' => $request->Value_VAT,

            'Rate_VAT' => $request->Rate_VAT,

            'Discount' => $request->Discount,

            'Total' => $request->Total,

            'note' => $request->note,



        ]);
        session()->flash('edit', 'the invoice has been edited successfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)


    {
        $id = $request->id_invoice;
        $invoice = Inovice::where('id', $id)->first();
        $attachments = Inovices_attachments::where('invoice_id', $id)->first();

        if (!empty($attachments->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($attachments->invoice_number);
        }
        $invoice->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/inovices');


        // $invoices->delete();
        // Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        // session()->flash('delete', 'The attachment has been deleted sucessfully');
        // return back();
    }

    public function updateStatus(Request $request, $id)
    {

        $invoices = Inovice::findorfail($id);

        if ($request->Status == 'Paid') {

            $invoices->update([

                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            Inovices_details::create([

                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' =>  'paid',
                'Value_Status' => 1,
                'Payment_Date' => $request->Payment_Date,
                'note' => $request->note,
                'user' => Auth()->user()->name,

            ]);
        } else {


            $invoices->update([

                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            Inovices_details::create([

                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' =>  'Partially Paid',
                'Value_Status' => 3,
                'Payment_Date' => $request->Payment_Date,
                'note' => $request->note,
                'user' => Auth()->user()->name,

            ]);
        }
        session()->flash('Update', 'Your payment status has been updated');

        return redirect('/inovices');
    }



    public function  getProducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    public function Paid_Bill()
    {


        $invoices = Inovice::where('Value_Status', 1)->get();

        return view('inovices.Paid_Bill', compact('invoices'));
    }



    public function Unpaid_bill()
    {


        $invoices = Inovice::where('Value_Status', 2)->get();

        return view('inovices.unpaid_bill', compact('invoices'));
    }



    public function partially_paid()
    {


        $invoices = Inovice::where('Value_Status', 3)->get();

        return view('inovices.partiallypaid', compact('invoices'));
    }


    public function archive(REQUEST $request)
    {

        $id = $request->id_invoice;
        $invoice = Inovice::where('id', $id)->first();
        $attachments = Inovices_attachments::where('invoice_id', $id)->first();

        if (!empty($attachments->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($attachments->invoice_number);
        }
        $invoice->Delete();
        session()->flash('archive_invoice');
        return redirect('/archive');
    }
}
