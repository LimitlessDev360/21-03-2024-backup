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
                        {{translate('time-slot')}}
                    </span>
                </h2>
            </div>

            <a href="" class="btn btn--primary pull-right"><i class="tio-add-circle"></i>
                {{translate('messages.Add_New_slot')}}</a>

        </div>
    </div>
    <!-- End Page Header -->


    <div class="card mt-3">
        <div class="card-header py-2">
            <div class="search--button-wrapper">
                <h5 class="card-title"><span class="card-header-icon">
                        <i class="tio-category-outlined"></i>
                    </span> {{translate('messages.Slot_list')}}<span class="badge badge-soft-dark ml-2"
                        id="itemCount"></span></h5>
                <form>

                    <!-- Search -->
                    <div class="input--group input-group input-group-merge input-group-flush">
                        <input type="search" name="search" value="" class="form-control"
                            placeholder="{{ translate('Ex_:_Time_slot') }}" aria-label="">
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

            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Day</th>
                        <th>Slot ID</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dayWiseSlots as $day => $slots)
                    <!-- Day Header -->
                    <tr class="day-header">
                        <td colspan="6">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <strong>{{ $day }}</strong>
                                <a href=""
                                    class="btn btn-success mr-2">Add Additional</a>
                            </div>
                        </td>
                    </tr>
                    @foreach ($slots as $slot)
                    <tr>
                        <td></td>
                        <td>{{ $slot->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($slot->created_at)->toFormattedDateString() }}</td>
                        <td>
                            <a href="{{ route('admin.slots.edit', $slot->id) }}"
                                class="btn btn-sm btn-outline-primary">Edit</a>
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $slot->id }}').submit();">
                                Delete
                            </button>
                            <form id="delete-form-{{ $slot->id }}"
                                action="{{ route('admin.slots.destroy', $slot->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>

            @if(count($dayWiseSlots) === 0)
            <div class="empty--data">
                <img src="{{dynamicAsset('/public/assets/admin/img/empty.png')}}" alt="public">
                <h5>
                    {{translate('no_data_found')}}
                </h5>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection

@push('script_2')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
.day-header {
    background-color: #f8f9fa;
    /* Light gray background for day headers */
}
</style>
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