@extends('layouts.landing.app')
@section('title', 'Vendor Registration')
@push('css_or_js')
<link rel="stylesheet" href="{{ dynamicAsset('public/assets/landing') }}/css/style.css" />
@endpush
@section('content')
<!-- Page Header Gap -->
<div class="h-148px"></div>
<!-- Page Header Gap -->

<section class="m-0 landing-inline-1 section-gap">
    <div class="container">
        <!-- Page Header -->
        <div class="step__header">
            <h4 class="title"> Vendor Registration</h4>
            <div class="step__wrapper">
                <div class="step__item active">
                    <span class="shapes"></span>
                    {{ translate('messages.general_information') }}
                </div>
                <div class="step__item active">
                    <span class="shapes"></span>
                    {{ translate('messages.business_plan') }}
                </div>
                <div class="step__item active">
                    <span class="shapes"></span>
                    {{ translate('messages.complete') }}
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card __card">
            <div class="card-body">
                <div class="succeed--status">
                    <img class="img"
                    src="{{\App\CentralLogics\Helpers::onerror_image_helper($logo, dynamicStorage('storage/app/public/restaurant/'.$logo), dynamicAsset('public/assets/admin/img/100x100/food-default-image.png'), 'restaurant/') }}"
                    alt="image">
                    <h4 class="title">{{ translate('Congratulations!') }}</h4>
                    <h6 class="subtitle">
                        {{ translate('messages.Your_registration_has_been_completed_successfully.') }}
                    </h6>
                    <div>
                       Login
                        <strong>After 5 minutes</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
