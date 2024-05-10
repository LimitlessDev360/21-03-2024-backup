@extends('layouts.admin.app')

@section('title',translate('messages.update_Service'))

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
                        <img src="{{dynamicAsset('public/assets/admin/img/sub-category.png')}}" alt="">
                    </div>
                    <span>
                        Edit Serivce
                    </span>
                </h2>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <div class="card">

        <div class="card-body">
            <form action="{{ route('admin.service.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')
                <div class="row gap-4 d-flex  justify-content-start ">

                    <div class="form-group lang_form col-3" id="default-form">
                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}}</label>
                        <input type="text" name="name" class="form-control" placeholder="{{ translate('Ex:_Name') }}"
                            maxlength="191" value="{{$service->name}}">

                    </div>
                    <div class="form-group lang_form col-3" id="default-form">
                        <label class="input-label"
                            for="exampleFormControlInput1">{{translate('messages.amount')}}</label>
                        <input type="text" name="amount" class="form-control"
                            placeholder="{{ translate('Ex:_amount') }}" value="{{$service->amount}}">

                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-0 w-70">
                            <label class="input-label"
                                for="exampleFormControlInput1">{{ translate('messages.tax_rate') }}

                            </label>
                            <select name="tax_rate" class="form-control js-select2-custom">
                                <option value="percent" {{ $service->tax_rate == 'percent' ? 'selected' : '' }}>
                                    {{ translate('messages.percent').' (%)' }}</option>
                                <option value="amount" {{ $service->tax_rate == 'amount' ? 'selected' : '' }}>
                                    {{ translate('messages.amount').' ('.\App\CentralLogics\Helpers::currency_symbol().')'  }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group lang_form col-3" id="default-form">
                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.Km')}}</label>
                        <input type="number" name="km" class="form-control" placeholder="{{ translate('Ex:_amount') }}"
                            maxlength="191" value="{{$service->km}}">

                    </div>



                    <div class="col-3 d-flex gap-5">
                        <div class="form-check  mt-5">
                            <input class="form-check-input" type="radio" name="inclusive" id="flexRadioDefault1"
                                value="1" {{ $service->inclusive == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexRadioDefault1">
                                inclusive
                            </label>
                        </div>
                        <div class="form-check  mt-5">
                            <input class="form-check-input" type="radio" name="inclusive" id="flexRadioDefault2"
                                value="2" {{ $service->exclusive == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="flexRadioDefault2">
                                exclusive
                            </label>
                        </div>
                    </div>
                    <div class="form-check form-switch col-3 mt-5">
                        <label class="toggle-switch toggle-switch-sm ml-2" for="stocksCheckbox">
                            <input type="checkbox" data-url="" class="toggle-switch-input " id="stocksCheckbox"
                                name="taxable" value="1" {{ $service->taxable == 1 ? 'checked' : '' }}>
                            <span class="toggle-switch-label">
                                <span class="toggle-switch-indicator"></span>
                            </span>
                        </label>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-4">
                    </div>
                    <div class="col-12">
                        <div class="form-group pt-2 mb-0">

                            <div class="btn--container justify-content-end mt-5">
                                <!-- <button id="reset_btn" type="button"
                                    class="btn btn--reset">{{translate('messages.reset')}}</button> -->
                                <button type="submit" class="btn btn--primary">{{translate('messages.update')}}</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- End Table -->
    </div>
</div>

@endsection