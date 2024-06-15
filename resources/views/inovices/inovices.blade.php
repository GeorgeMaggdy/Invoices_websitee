@extends('layouts.master')
@section('title')
Invoices List
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Bills</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Inovice List</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')


@if(session()->has('delete_invoice'))

<script>
    window.onload = function() {

        notif({

            msg: "Your bill has been deleted successfully",
            type: "success"
        })
    }
</script>



@endif


@if(session()->has('restore_invoice'))

<script>
    window.onload = function() {

        notif({

            msg: "Your bill has been restored successfully",
            type: "success"
        })
    }
</script>



@endif





@if (session()->has('Update'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('Update') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif


<div class="row">


    <!--/div-->

    <!--div-->

    <!--/div-->

    <!--div-->
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <!-- <div class="d-flex justify-content-between">
                                        <h4 class="card-title mg-b-0">Bordered Table</h4>
                                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                                    </div> -->

                <a href="inovices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i class="fas fa-plus"></i>&nbsp; Add bill</a>


            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Invoice number</th>
                                <th class="border-bottom-0">Invoice date</th>
                                <th class="border-bottom-0">Due date</th>
                                <th class="border-bottom-0">Product</th>
                                <th class="border-bottom-0">Section</th>
                                <th class="border-bottom-0">Commission</th>
                                <th class="border-bottom-0">Discount</th>
                                <th class="border-bottom-0">Tax rate</th>
                                <th class="border-bottom-0">Vat value</th>
                                <th class="border-bottom-0">Total</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Notes</th>
                                <th class="border-bottom-0">Notes</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i =0;
                            @endphp

                            @foreach($invoices as $invoice)
                            @php
                            $i++;
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$invoice->invoice_number}}</td>
                                <td>{{$invoice->invoice_Date}}</td>
                                <td>{{$invoice->Due_date}}</td>
                                <td>{{$invoice->product}}</td>
                                <td>
                                    <a href="{{ url('InvoicesDetails') }}/{{ $invoice->id }}">{{ $invoice->section->section_name }}</a>
                                </td>
                                <td>{{$invoice->Amount_Commission}}</td>
                                <td>{{$invoice->Discount}}</td>
                                <td>{{$invoice->Rate_VAT}}</td>
                                <td>{{$invoice->Value_VAT}}</td>
                                <td>{{$invoice->Total}}</td>
                                <td>
                                    @if ($invoice->Value_Status == 1)
                                    <span class="text-success">{{ $invoice->Status }}</span>
                                    @elseif($invoice->Value_Status == 2)
                                    <span class="text-danger">{{ $invoice->Status }}</span>
                                    @else
                                    <span class="text-warning">{{ $invoice->Status }}</span>
                                    @endif

                                </td>
                                <td>{{$invoice->note}}</td>

                                <td>
                                    <div class="dropdown">
                                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary" data-toggle="dropdown" id="dropdownMenuButton" type="button">Processes <i class="fas fa-caret-down ml-1"></i></button>
                                        <div class="dropdown-menu tx-13">
                                            <a class="dropdown-item" href="{{url('edit_invoice')}}/{{$invoice->id}}">Edit invoice</a>

                                            <a class="dropdown-item" data-toggle="modal" data-id_invoice="{{ $invoice->id }}" data-target="#delete_file">Delete</a>

                                            <a class="dropdown-item" href="{{url('edit_status')}}/{{$invoice->id}}">Edit Payment Status</a>

                                            <a class="dropdown-item" data-toggle="modal" data-id_invoice="{{ $invoice->id }}" data-target="#archive_file">Archive</a>

                                            <a class="dropdown-item" href="{{url('print_bill')}}/{{$invoice->id}}">Print Bill</a>




                                        </div>
                                    </div>

                                </td>







                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->

    <!--div-->

    </tfoot>
    </table>
</div>
</div>
</div>
</div>
<!-- delete -->
<div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete attachment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('delete_invoice')}}" method="post">

                {{ csrf_field() }}
                <div class="modal-body">
                    <p class="text-center">
                    <h6 style="color:red">?Are you sure of deleting this invoice</h6>
                    </p>

                    <input type="hidden" name="id_invoice" id="id_invoice" value="">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Archive bills -->
<div class="modal fade" id="archive_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Archive attachment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('archive_invoice')}}" method="post">

                {{ csrf_field() }}
                <div class="modal-body">
                    <p class="text-center">
                    <h6 style="color:red">?Are you sure of archiveing this invoice</h6>
                    </p>

                    <input type="hidden" name="id_invoice" id="id_invoice" value="">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection

@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>


<script>
    $('#delete_file').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id_invoice = button.data('id_invoice')
        var modal = $(this)

        modal.find('.modal-body #id_invoice').val(id_invoice);

    })
</script>


<script>
    $('#archive_file').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id_invoice = button.data('id_invoice')
        var modal = $(this)

        modal.find('.modal-body #id_invoice').val(id_invoice);

    })
</script>

<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection