@extends('layouts.admin.app')
@push('css_or_js')

@endpush
@section('content')

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h2 class="page-header-title text-capitalize">
                    <div class="card-header-icon d-inline-flex mr-2 img">
                        <img src="{{dynamicAsset('public/assets/admin/img/category.png')}}" alt="">
                    </div>
                    <span>
                        {{translate('Service-List')}}
                    </span>
                </h2>
            </div>

            <a href="{{ route('admin.add-service') }}" class="btn btn--primary pull-right"><i class="tio-add-circle"></i>
                {{translate('messages.Add_service')}}</a>

        </div>
    </div>
    <!-- End Page Header -->


    <div class="card mt-3">
        <div class="card-header py-2">
            <div class="search--button-wrapper">
                <h5 class="card-title"><span class="card-header-icon">
                        <i class="tio-category-outlined"></i>
                    </span> {{translate('messages.Service_list')}}<span class="badge badge-soft-dark ml-2"
                        id="itemCount"></span></h5>
                <form>

                    <!-- Search -->
                    <div class="input--group input-group input-group-merge input-group-flush">
                        <input type="search" name="search" value="" class="form-control"
                            placeholder="{{ translate('Ex_:_service_list') }}" aria-label="">
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                </form>

                <div class="hs-unfold ml-3">
                    <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn btn-outline-primary btn--primary font--sm"
                        href="javascript:;" data-hs-unfold-options=''>
                        <i class="tio-download-to mr-1"></i> {{translate('messages.export')}}
                    </a>

                    <div id="usersExportDropdown"
                        class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        <span class="dropdown-header">{{translate('messages.download_options')}}</span>
                        <a target="__blank" id="export-excel" class="dropdown-item" href="">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="{{dynamicAsset('public/assets/admin')}}/svg/components/excel.svg"
                                alt="Image Description">
                            {{translate('messages.excel')}}
                        </a>
                        <a target="__blank" id="export-csv" class="dropdown-item" href="">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="{{dynamicAsset('public/assets/admin')}}/svg/components/placeholder-csv-format.svg"
                                alt="Image Description">
                            {{translate('messages.csv')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive datatable-custom">
            <table id="columnSearchDatatable" class="table table-borderless table-thead-bordered table-align-middle"
                data-hs-datatables-options=''>
                <thead class="thead-light">
                    <tr>
                        <th>{{ translate('messages.sl') }}</th>
                        <th>{{translate('messages.name')}}</th>
                        <th>{{translate('messages.amount')}}</th>
                        <th>{{translate('messages.tax_rate')}}</th>
                        <th>{{translate('messages.taxable')}}</th>
                        <th class="text-cetner w-130px">{{translate('messages.action')}}</th>
                    </tr>
                </thead>

                <tbody id="table-div">
                    @foreach( $services as $key =>$service )
                    <tr>
                        <td>
                            <div class="pl-3">
                                {{ $key + $services->firstItem() }}

                            </div>
                        </td>
                        <td>
                            <div class="pl-2">
                                {{$service->name}}
                            </div>
                        </td>
                        <td>
                            <div class="pl-2">
                                {{$service->amount}}
                            </div>
                        </td>
                        <td>
                            <div class="pl-2">
                                {{$service->tax_rate}}
                            </div>
                        </td>



                        <td>
                            <label class="toggle-switch toggle-switch-sm ml-2" for="stocksCheckbox">
                                <input type="checkbox" data-url="" class="toggle-switch-input redirect-url"
                                    id="stocksCheckbox" {{ $service->taxable == 1 ? 'checked' : '' }}>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </td>
                        <td>

                        <div class="btn--container">
                        <a href="{{ route('admin.service.edit', $service->id) }}"
                                class="btn btn-sm btn--primary btn-outline-primary action-btn"><i class="tio-edit"></i></a>
                                
                            <button class="btn btn-sm btn--danger btn-outline-danger action-btn"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $service->id }}').submit();">
                                <i class="tio-delete-outlined"></i>
                            </button>
                            <form id="delete-form-{{ $service->id }}"
                                action="{{ route('admin.service.destroy', $service->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
            @if(count($services) === 0)
            <div class="empty--data">
                <img src="{{dynamicAsset('/public/assets/admin/img/empty.png')}}" alt="public">
                <h5>
                    {{translate('no_data_found')}}
                </h5>
            </div>
            @endif

        </div>
        <div class="card-footer pt-0 border-0">
            <div class="page-area px-4 pb-3">
                <div class="d-flex align-items-center justify-content-end">
                    <div>
                        {!! $services->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('script_2')
<script src="{{dynamicAsset('public/assets/admin')}}/js/view-pages/category-index.js"></script>
<script>
"use strict";

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#viewer').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#customFileEg1").change(function() {
    readURL(this);
});
</script>
@endpush