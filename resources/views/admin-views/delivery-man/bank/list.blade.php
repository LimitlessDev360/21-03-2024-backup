@extends('layouts.admin.app')

@section('title','Bank Details')

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
                        Bank List
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
                        <h5 class="card-title">Deliveryman Bank List<span
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

                <div class="row justify-content-end mt-2 pr-3">
             <div class="col-auto">
                <!-- Button to end process -->
                <form action="" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-info">Add</button>
                </form>
                    </div>
                    </div>
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
                                <th class="text-capitalize">Bank</th>
                                <th class="text-capitalize">IFSC</th>
                                <th class="text-capitalize">Account Number</th>
                                <th class="text-capitalize">Account Type</th>
                                <th class="text-capitalize">Status</th>
                                <th class="text-capitalize text-center w-110px">{{translate('messages.action')}}</th>
                            </tr>
                        </thead>

                        <tbody id="set-rows">

                            @foreach($banks as $key=>$bank)
                            <tr>

                                <td>{{$key+$banks->firstItem()}}</td>

                                <td><a href=""></a>{{$bank->deliveryman_name}}</td>

                                <td>{{$bank->deliveryman_phone}}</td>


                                <td>{{$bank->bank_name}}</td>


                                <td>{{$bank->ifsc_code}}</td>

                                <td>{{$bank->account_number}}</td>

                                <td>{{$bank->account_type}}</td>


                                <td class="text-capitalize {{ 
                                        $bank->is_active == 1 ? 'text-success' : 'text-danger'}} font-weight-bold">

                                        {{$bank->is_active ? "Active" : "In Active"}}
                                </td>
                                


                                <td class="text-capitalize">
                                   

                                <button class="btn btn-sm btn--primary btn-outline-primary action-btn"
                                             title="Edit"><i class="tio-invisible"></i></button>
                                    <!-- <div class="btn--container justify-content-center">
                                    <form action="" method= 'post'>  <button class="btn btn-sm btn--primary btn-outline-primary action-btn payment-data"
                                             title="Approve and pay"><i class="tio-invisible"></i></button>
                                          
                                    @csrf @method('delete')
                                    </form>
                                    </div> -->
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
</script>

@endpush