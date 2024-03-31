@extends('layouts.admin.app')

@section('title','Paid List')

@push('css_or_js')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-12 mb-2">
                <h1 class="page-header-title text-capitalize">
                    <div class="card-header-icon d-inline-flex mr-2 img">
                        <img src="{{dynamicAsset('/public/assets/admin/img/delivery-man.png')}}" alt="public">
                    </div>
                    <span>
                        Paid Amount List
                    </span>
                </h1>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <div class="row gx-2 gx-lg-3">
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <!-- Card -->
            <div class="card">
                <!-- Header -->
                <div class="card-header py-2">
                    <div class="search--button-wrapper">
                        <h5 class="card-title">{{translate('messages.deliveryman')}}<span
                                class="badge badge-soft-dark ml-2" id="itemCount"></span></h5>
                        <form>
                            <!-- Search -->

                            <div class="input--group input-group input-group-merge input-group-flush">
                                <input id="datatableSearch_" type="search" name="search"
                                    value="{{ request()?->search ?? null }}" class="form-control"
                                    placeholder="{{ translate('Search_by_name')}}" aria-label="Search">
                                <button type="submit" class="btn btn--secondary">
                                    <i class="tio-search"></i>
                                </button>

                            </div>
                            <!-- End Search -->
                        </form>

                        <!-- Unfold -->
                        <!-- <div class="hs-unfold ml-3">
                            <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn btn-outline-primary btn--primary font--sm"
                                href="javascript:;" data-hs-unfold-options='{
                                     "target": "#usersExportDropdown",
                                     "type": "css-animation"
                                   }'>
                                <i class="tio-download-to mr-1"></i> {{translate('messages.export')}}
                            </a>

                            <div id="usersExportDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                                <span class="dropdown-header">{{translate('messages.download_options')}}</span>
                                <a id="export-excel" class="dropdown-item" href="javascript:;">
                                    <a id="export-excel" class="dropdown-item"
                                        href="{{route('admin.delivery-man.export-delivery-man', ['type'=>'excel',request()->getQueryString()])}}">

                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="{{dynamicAsset('public/assets/admin')}}/svg/components/excel.svg"
                                            alt="Image Description">
                                        {{translate('messages.excel')}}
                                    </a>
                                    <a id="export-csv" class="dropdown-item" href="javascript:;">
                                        <a id="export-csv" class="dropdown-item"
                                            href="{{route('admin.delivery-man.export-delivery-man', ['type'=>'csv',request()->getQueryString()])}}">
                                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                                src="{{dynamicAsset('public/assets/admin')}}/svg/components/placeholder-csv-format.svg"
                                                alt="Image Description">
                                            {{translate('messages.csv')}}
                                        </a>
                            </div>
                        </div> -->
                        <!-- Unfold -->
                    </div>
                </div>
                <!-- End Header -->

                <!-- Table -->
                <div class="table-responsive datatable-custom fz--14px">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                        <thead class="thead-light">
                            <tr>
                                <th class="text-capitalize">{{ translate('messages.sl') }}</th>
                                <th class="text-capitalize w-12p">{{translate('messages.name')}}</th>
                                <th class="text-capitalize">Phone</th>
                                <th class="text-capitalize">Requested Amount</th>
                                <!-- <th class="text-capitalize">Requested Amount</th> -->
                                <th class="text-capitalize text-center">Paid Amount</th>
                                <th class="text-capitalize">Remaining Amount</th>
                                <th class="text-capitalize">Requested Date</th>
                                <th class="text-capitalize">Status</th>
                                <th class="text-capitalize text-center w-110px">{{translate('messages.action')}}</th>
                            </tr>
                        </thead>

                        <tbody id="set-rows">

                            @foreach($amounts as $key=>$amount)
                            <tr>

                                <td>{{$key+$amounts->firstItem()}}</td>

                                <td><a href="{{route('admin.delivery-man.preview', ['id'=>$amount->deiveryman_id, 'tab'=> 'transaction'])}}">{{$amount->name}}</a></td>

                                <td>{{$amount->phone}}</td>

                                <!-- <td class="text-center">{{$amount->deiveryman_id}}</td> -->

                                <td class="text-center">{{$amount->requested_amount}}</td>

                                <td class="text-center">{{$amount->paid_amount}}</td>

                                <td class="text-center">{{$amount->remaining_amount}}</td>


                                <td class="text-center">{{$amount->created_at}}</td>


                                <td class="text-capitalize {{ 
                                        $amount->status == 'requested' ? 'text-info' : 
                                        ($amount->status == 'paid' ? 'text-success' : 
                                        ($amount->status == 'partial' ? 'text-warning' : 'text-danger')) }}">
                                    {{$amount->status}}
                                </td>


                                <td>
                                    
                                    <div class="btn--container justify-content-center">
                                    <form action="" id="paymentForm">  <a class="btn btn-sm btn--primary btn-outline-primary action-btn payment-data"
                                             title="Approve and pay" data-toggle="modal" data-target="#myModal"
                                            data-id="{{$amount->id}}" data-total="{{$amount->remaining_amount}}"
                                            data-status="{{$amount->status}}"><i class="tio-done"></i></a></form>
                                        <!-- <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert"
                                            href="javascript:" data-id=""
                                            data-message="Declined the requested amount"
                                            title="Decline"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="" method="post" id="">
                                            @csrf @method('delete')
                                        </form> -->
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
            </div>
            <!-- End Card -->
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Amount Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Text fields go here -->
                <div class="form-group" id="status">
                    <label for="checkbox" class="text-primary">If pay parital amount</label>
                    <input type="checkbox" id="checkbox" style="height:15px; width:15px">
                </div>
            <form action="{{route('admin.deliveryman-requests.pay-delivery-amount')}}" method="post">

                <label for="total-amount">Total Amount</label>
                <input id="total-amount" type="text" name="total-amount" class="form-control mb-3" placeholder="Amount" value="" readonly>

                <input type="hidden" name="status_id" id="status_id">

                <div class="form-group" id="textFieldGroup" style="display: none;">
                    <label for="partial_amount">Partial Amount</label>
                    <input type="number" name="paid_amount" id="partial_amount" class="form-control"
                        id="partial_amount" onkeypress="checkAmountExceeded()">
                    <div class="errorDiv text-danger" id="errorDiv"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="submitButton">Pay</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            @csrf
            @method('post')
            </form>
        </div>
    </div>
</div>
@endsection

@push('script_2')
<script>
"use strict";
$(document).on('ready', function() {
    // INITIALIZATION OF DATATABLES
    // =======================================================
    let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

    $('#column1_search').on('keyup', function() {
        datatable
            .columns(1)
            .search(this.value)
            .draw();
    });

    $('#column2_search').on('keyup', function() {
        datatable
            .columns(2)
            .search(this.value)
            .draw();
    });

    $('#column3_search').on('keyup', function() {
        datatable
            .columns(3)
            .search(this.value)
            .draw();
    });

    $('#column4_search').on('keyup', function() {
        datatable
            .columns(4)
            .search(this.value)
            .draw();
    });


    // INITIALIZATION OF SELECT2
    // =======================================================
    $('.js-select2-custom').each(function() {
        let select2 = $.HSCore.components.HSSelect2.init($(this));
    });
});

$(document).ready(function() {
    $('#myModal').on('shown.bs.modal', function() {
        // Calculate top margin to vertically center the modal
        var modalHeight = $(this).find('.modal-dialog').height();
        var topMargin = ($(window).height() - modalHeight) / 2;
        $(this).find('.modal-dialog').css('margin-top', topMargin);


        ///partial amount
        $('#checkbox').change(function() {
            if ($(this).is(':checked')) {
                $('#textFieldGroup').show();
            } else {
                $('#textFieldGroup').hide();
            }
        });
    });

    $(".payment-data").on("click", function() {
        var totalAmount = $(this).data('total');
        var requestId = $(this).data('id');
        var status = $(this).data('status');
        $("#total-amount").val(totalAmount);
        $("#status").val(status);
        $("#status_id").val(requestId);
    });
});



function checkAmountExceeded() {
    document.getElementById('partial_amount').addEventListener('input', function() {
        var partial = this.value;
        var total = document.getElementById('total-amount').value;
        var errorDiv = document.getElementById('errorDiv');
        var submitButton = document.getElementById('submitButton');
        // Check if the first digit of partial amount has been entered
        if (partial.length > 0 && total.length > 0 && parseFloat(partial) > parseFloat(total)) {
            // If partial amount is greater than total amount
            errorDiv.innerHTML = 'Partial amount cannot be greater than total amount';
            submitButton.disabled = true; 
        } else {
            // If partial amount is less than or equal to total amount or no value entered yet
            errorDiv.innerHTML = '';
            submitButton.disabled = false;
            this.submit();
        }
    });
}



</script>

@endpush