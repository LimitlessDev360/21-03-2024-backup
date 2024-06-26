@extends('layouts.admin.app')

@section('title',"Add Vendor")
@push('css_or_js')

    <link href="{{ dynamicAsset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="content container-fluid initial-57">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-shop-outlined"></i>
                        Add Vendor</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        @php($language=\App\Models\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        @php($default_lang = str_replace('_', '-', app()->getLocale()))

        <form action="{{ route('admin.restaurant.store') }}" method="post" enctype="multipart/form-data" oninput="validateAccountNumber()" onsubmit ="validateTime()"
            class="js-validate" id="res_form">
            @csrf
            <div class="row g-2">
                <div class="col-lg-6">
                    <div class="card shadow--card-2">
                        <div class="card-body">
                            @if($language)
                            <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link"
                                    href="#"
                                    id="default-link"></a>
                                </li>
                                <!-- @foreach (json_decode($language) as $lang)
                                    <li class="nav-item">
                                        <a class="nav-link lang_link"
                                            href="#"
                                            id="{{ $lang }}-link">{{ \App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}</a>
                                    </li>
                                @endforeach -->
                            </ul>
                            @endif
                            <div class="lang_form" id="default-form">
                                <div class="form-group ">


            
                                        <label class="input-label" for="name">Name *</label>
                                        <input id="name" type="text" name="name" class="form-control h--45px"
                                            placeholder="Name"
                                            value="{{ old('name') }}" required>
                                   

                                <!-- <input id="name" type="text" name="name" class="form-control"
                                            placeholder="Name"
                                            value="{{ old('name') }}"> -->


                                    <!-- <input type="text" name="name" class="form-control"  placeholder="{{ translate('messages.Ex:_ABC_Company') }} " maxlength="191"  oninvalid="document.getElementById('en-link').click()" required
                                    value="{{ old('name') }}"> -->
                                </div>
                                <input type="hidden" name="lang[]" value="default">

                                <div>
                                    <!-- <label class="input-label" for="address">Address *</label>

                                    <input id="address" type="text" name="address" class="form-control"
                                            placeholder="Address"
                                            value="{{ old('address') }}"> -->

                                            <label class="input-label" for="address">Address *</label>
                                        <input id="address" type="text" name="address" class="form-control h--45px"
                                            placeholder="Address"
                                            value="{{ old('address') }}" required>

                                    <!-- <textarea id="address" name="address" class="form-control h-70px" placeholder="{{ translate('messages.Ex:_House#94,_Road#8,_Abc_City') }}" required value="{{ old('address') }}"></textarea> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow--card-2">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-1"><i class="tio-dashboard"></i></span>
                                <span>Logo & Cover</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap flex-sm-nowrap __gap-12px">
                                <label class="__custom-upload-img mr-lg-5">
                                    @php($logo = \App\Models\BusinessSetting::where('key', 'logo')->first())
                                    @php($logo = $logo->value ?? '')
                                    <label class="form-label">
                                        {{ translate('logo') }} <span class="text--primary">({{ translate('1:1') }})</span>
                                    </label>
                                    <div class="text-center">
                                        <img class="img--110 min-height-170px min-width-170px" id="viewer"
                                            src="{{ dynamicAsset('public/assets/admin/img/upload-img.png') }}"
                                            alt="logo image" />
                                    </div>
                                    <input type="file" name="logo" id="customFileEg1" class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                </label>

                                <label class="__custom-upload-img">
                                    @php($icon = \App\Models\BusinessSetting::where('key', 'icon')->first())
                                    @php($icon = $icon->value ?? '')
                                    <label class="form-label">
                                       Cover  <span class="text--primary">({{ translate('2:1') }})</span>
                                    </label>
                                    <div class="text-center">
                                        <img class="img--vertical min-height-170px min-width-170px" id="coverImageViewer"
                                            src="{{ dynamicAsset('public/assets/admin/img/upload-img.png') }}"
                                            alt="Fav icon" />
                                    </div>
                                    <input type="file" name="cover_photo" id="coverImageUpload"  class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card shadow--card-2">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-1"><i class="tio-dashboard"></i></span>
                                <span>Config</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">

                                <!-- Gst Percentage -->
                                <div class="col-md-6">
                                    <label class="input-label" for="tax">Gst %</label>
                                    <input id="tax" type="number" name="tax" class="form-control h--45px"
                                    value="{{ old('tax') }}"
                                        placeholder="18" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;"
                                        >
                                </div>

                                <!-- Gst Percentage -->
                                <div class="col-md-6">
                                <label class="input-label" for="gst_no">GST No</label>
                                <input id="gst_no" type="text" name="gst_no" class="form-control h--45px" maxlength="15"
                                value= "{{ old('gst_no') }}"
                                    placeholder="HRYD5692RH">
                                </div>

                                <!-- Gst Percentage -->
                                <div class="col-md-6">
                                <label class="input-label" for="halal_no">Halal Reg No</label>
                                <input id="halal_no" type="text" name="halal_no" class="form-control h--45px"
                                value= "{{ old('halal_no') }}"
                                    placeholder="HRY/KOI/26F/RYH5">
                                </div>

                                <!-- Estimated Time -->
                                <div class="col-md-6">
                                    <div class="position-relative">
                                        <label class="input-label" for="tax">{{translate('Estimated_Delivery_Time_(_Min_&_Maximum_Time_)')}} *</label>
                                        <input type="text" id="time_view" class="form-control" readonly>
                                        <a href="javascript:void(0)" class="floating-date-toggler">&nbsp;</a>
                                        <span class="offcanvas"></span>
                                        <span id="timeError" class="error text-danger"></span>
                                        <div class="floating--date" id="floating--date">
                                            <div class="card shadow--card-2">
                                                <div class="card-body">
                                                    <div class="floating--date-inner">
                                                        <div class="item">
                                                            <label class="input-label"
                                                                for="minimum_delivery_time">{{ translate('Minimum_Time') }}</label>
                                                            <input id="minimum_delivery_time" type="number" name="minimum_delivery_time" class="form-control h--45px" placeholder="{{ translate('messages.Ex:_30') }}"
                                                                pattern="^[0-9]{2}$" value="{{ old('minimum_delivery_time') }}" required>
                                                        </div>
                                                        <div class="item">
                                                            <label class="input-label"
                                                                for="maximum_delivery_time">{{ translate('Maximum_Time') }}</label>
                                                            <input id="maximum_delivery_time" type="number" name="maximum_delivery_time" class="form-control h--45px" placeholder="{{ translate('messages.Ex:_60') }}"
                                                                pattern="[0-9]{2}" value="{{ old('maximum_delivery_time') }}" required>
                                                        </div>
                                                        <div class="item smaller">
                                                            <select name="delivery_time_type" id="delivery_time_type" class="custom-select">
                                                                <option value="min">{{translate('messages.minutes')}}</option>
                                                                <option value="hours">{{translate('messages.hours')}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="item smaller">
                                                            <button type="button" class="btn btn--primary deliveryTime">{{ translate('done') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Halal Certificate -->
                                <div class="col-md-3">
                                <label class="__custom-upload-img mr-lg-5">
                                    @php($icon = \App\Models\BusinessSetting::where('key', 'icon')->first())
                                    @php($icon = $icon->value ?? '')
                                    <label class="form-label">
                                       Halal Certificate
                                    </label>
                                    <div class="text-center">
                                        <img class="img--vertical min-height-170px min-width-170px" id="halal"
                                            src="{{ dynamicAsset('public/assets/admin/img/upload-img.png') }}"
                                            alt="Fav icon" />
                                    </div>
                                    <input type="file" name="halal_certificate" id="halalCertificate"  class="custom-file-input"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                </label>

                                </div>

                                <!-- <div class="form-group">
                                <label class="form-label" for="">Tax</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                        <input type="radio" name="tax_include"  class="form-check-input" value="">Included
                                        </label>
                                        </div>
                                    <div class="form-check mt-3">
                                        <label class="form-check-label">
                                        <input type="radio" name="tax_include"  class="form-check-input" value="">Excluded
                                        </label>
                                        </div>             
                                </div> -->
                                          

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card shadow--card-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- <div class="form-group">
                                        <label class="input-label" for="cuisine">{{ translate('messages.cuisine') }}</label>
                                        <select name="cuisine_ids[]" id="cuisine" class="form-control h--45px min--45 js-select2-custom"
                                        multiple="multiple"  data-placeholder="{{ translate('messages.select_Cuisine') }}" >
                                            <option value="" disabled>{{ translate('messages.select_Cuisine') }}</option>
                                            @foreach (\App\Models\Cuisine::where('status',1 )->get(['id','name']) as $cu)
                                                    <option value="{{ $cu->id }}">{{ $cu->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> -->
                                    <div class="form-group">
                                        <span id="zoneError" class="error text-danger"></span>
                                        <label class="input-label" for="choice_zones">{{ translate('messages.zone') }} *
                                                <span data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.select_zone_for_map') }}"
                                                class="input-label-secondary"><img
                                                    src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="{{ translate('messages.restaurant_lat_lng_warning') }}"></span>
                                                </label>
                                        <select name="zone_id" id="choice_zones" required class="form-control h--45px js-select2-custom"
                                            data-placeholder="{{ translate('messages.select_zone') }}">
                                            <option value="{{ old('zone_id') }}" selected disabled>{{ translate('messages.select_zone') }}</option>
                                            
                                            @foreach (\App\Models\Zone::where('status',1 )->get(['id','name']) as $zone)
                                                @if (isset(auth('admin')->user()->zone_id))
                                                    @if (auth('admin')->user()->zone_id == $zone->id)
                                                        <option value="{{ $zone->id }}" selected>{{ $zone->name }}
                                                        </option>
                                                    @endif
                                                @else
                                                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="input-label" for="latitude">{{ translate('messages.latitude') }} *<span data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.restaurant_lat_lng_warning') }}"
                                                class="input-label-secondary"><img
                                                    src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="{{ translate('messages.restaurant_lat_lng_warning') }}"></span></label>
                                        <input type="text" id="latitude" name="latitude" class="form-control h--45px disabled"
                                            placeholder="{{ translate('messages.Ex:_-94.22213') }} " value="" required readonly>
                                    </div>
                                    <div class="form-group mb-md-0">
                                        <label class="input-label" for="longitude">{{ translate('messages.longitude') }} *
                                                <span data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('messages.restaurant_lat_lng_warning') }}"
                                                class="input-label-secondary"><img
                                                    src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="{{ translate('messages.restaurant_lat_lng_warning') }}"></span>
                                                </label>
                                        <input type="text" name="longitude" class="form-control h--45px disabled" placeholder="{{ translate('messages.Ex:_103.344322') }} "
                                            id="longitude" value="" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <input id="pac-input" class="controls rounded initial-8" title="{{translate('messages.search_your_location_here')}}" type="text" placeholder="{{translate('messages.search_here')}}"/>
                                    <div style="height: 370px !important" id="map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Account Info -->
                <div class="col-lg-12">
                    <div class="card shadow--card-2">
                        <div class="card-header">
                            <h4 class="card-title m-0 d-flex align-items-center"> <span class="card-header-icon mr-2"><i class="tio-user"></i></span> <span>{{ translate('messages.owner_info') }}</span></h4>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="f_name">{{ translate('messages.first_name') }} *</label>
                                        <input id="f_name" type="text" name="f_name" class="form-control h--45px"
                                            placeholder="{{ translate('messages.Ex:_Jhone') }}"
                                            value="{{ old('f_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="l_name">{{ translate('messages.last_name') }}</label>
                                        <input id="l_name" type="text" name="l_name" class="form-control h--45px"
                                            placeholder="{{ translate('messages.Ex:_Doe') }}"
                                            value="{{ old('l_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="phone">{{ translate('messages.phone') }} *</label>
                                        <input id="phone" type="number" name="phone" class="form-control h--45px" placeholder="{{ translate('messages.Ex:XXX-XXX-XXXX') }} "
                                            value="{{ old('phone') }}" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="extra_phone">Additional Phone</label>
                                        <input id="extra_phone" type="number" name="extra_phone" class="form-control h--45px" placeholder="{{ translate('messages.Ex:_XXX-XXX-XXXX') }}"
                                        value= "{{ old('extra_phone') }}"
                                        pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="extra_phone">Gpay No</label>
                                        <input id="gpay_no" type="number" name="gpay_no" class="form-control h--45px" placeholder="{{ translate('messages.Ex:_XXX-XXX-XXXX') }}"
                                        value= "{{ old('gpay_no') }}"
                                        pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                    <!-- Bank Details -->
                    <div class="col-lg-12">
                    <div class="card shadow--card-2">
                        <div class="card-header">
                            <h4 class="card-title m-0 d-flex align-items-center"> <span class="card-header-icon mr-2"><i class="tio-dashboard"></i></span> <span>Bank Details</span></h4>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="f_name">Account Holder</label>
                                        <input id="account_holder_name" type="text" name="account_holder_name" class="form-control h--45px"
                                            placeholder="Name"
                                            value="{{ old('account_holder_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="bank_name">Bank</label>
                                        <input id="bank_name" type="text" name="bank_name" class="form-control h--45px"
                                            placeholder="HDFC"
                                            value="{{ old('bank_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                <div class="form-group">
                                        <label class="input-label" for="account_type">Account Type
                                                </label>
                                        <select name="account_type" id="account_type"  class="form-control h--45px js-select2-custom"
                                            data-placeholder="Select account type">
                                            <option value="{{ old('account_type') }}" selected disabled>Select Type</option>
                
                                                    <option value="savings">Savings</option>
                                                    <option value="current">Current</option>
                                        
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="ifsc_code">IFSC</label>
                                        <input id="ifsc_code" type="text" name="ifsc_code" class="form-control h--45px" placeholder="HDFCIM22361"
                                            value="{{ old('ifsc_code') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="account_number">Account Number</label>
                                        <input id="account_number" type="number" name="account_number" class="form-control h--45px" placeholder="115969872596325"
                                        value = "{{ old('account_number') }}"
                                             >
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="confirm_account_number">Confirm Account Number</label>
                                        <input id="confirm_account_number" type="number" name="confirm_account_number" class="form-control h--45px" placeholder="115969872596325" 
                                        value = "{{ old('confirm_account_number') }}"
                                             >
                                             <span id="accountNumberError" class="error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>

                    <!-- <div class="col-lg-12">
                        <div class="card shadow--card-2 border-0">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <span class="card-header-icon mr-2"><i class="tio-label"></i></span>
                                    <span>{{ translate('tags') }}</span>
                                </h5>
                            </div>
                            <div class="card-body">
                                <input type="text" class="form-control" name="tags" placeholder="Enter tags" data-role="tagsinput">
                            </div>
                        </div>
                    </div> -->
                <div class="col-lg-12">
                    <div class="card shadow--card-2">
                        <div class="card-header">
                            <h4 class="card-title m-0 d-flex align-items-center"><span class="card-header-icon mr-2"><i class="tio-user"></i></span> <span>Vendor Login Details</span></h4>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label class="input-label" for="email">{{ translate('messages.email') }} *</label>
                                        <input id="email" type="email" name="email" class="form-control h--45px" placeholder="{{ translate('messages.Ex:_Jhone@company.com') }} "
                                            required value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="js-form-message form-group">
                                        <label class="input-label"
                                            for="signupSrPassword">{{ translate('messages.password') }} *
                                            <span class="input-label-secondary ps-1" data-toggle="tooltip" title="Atleast 6 characters"><img src="{{dynamicAsset('public/assets/admin/img/info-circle.svg')}}" alt="Atleast 6 characters"></span>

                                        </label>

                                        <div class="input-group input-group-merge">
                                            <input type="password" class="js-toggle-password form-control h--45px" name="password"
                                                id="signupSrPassword"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Atleast 6 characters"

                                                placeholder="Atleast 6 characters"
                                                aria-label="Atleast 6 characters"
                                                required data-msg="Your password is invalid. Please try again."
                                                data-hs-toggle-password-options='{
                                                                                    "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                                                                    "defaultClass": "tio-hidden-outlined",
                                                                                    "showClass": "tio-visible-outlined",
                                                                                    "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                                                                                    }'>
                                            <div class="js-toggle-password-target-1 input-group-append">
                                                <a class="input-group-text" href="javascript:;">
                                                    <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="js-form-message form-group">
                                        <label class="input-label"
                                            for="signupSrConfirmPassword">{{ translate('messages.confirm_password') }} *</label>

                                        <div class="input-group input-group-merge">
                                            <input type="password" class="js-toggle-password form-control h--45px" name="confirmPassword"
                                                id="signupSrConfirmPassword"
                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="{{ translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters') }}"

                                                placeholder="{{ translate('messages.Ex:_8+_Character') }}"
                                                aria-label="{{translate('messages.password_length_8+')}}"
                                                required data-msg="Password does not match the confirm password."
                                                data-hs-toggle-password-options='{
                                                                                        "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                                                                        "defaultClass": "tio-hidden-outlined",
                                                                                        "showClass": "tio-visible-outlined",
                                                                                        "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
                                                                                        }'>
                                            <div class="js-toggle-password-target-2 input-group-append">
                                                <a class="input-group-text" href="javascript:;">
                                                    <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn--container justify-content-end mt-3">
                <button id="reset_btn" type="button" class="btn btn--reset">{{translate('messages.reset')}}</button>
                <button type="submit" class="btn btn--primary h--45px"><i class="tio-save"></i> Save</button>
            </div>
        </form>

    </div>

@endsection

@push('script_2')
    <script src="{{ dynamicAsset('public/assets/admin') }}/js/tags-input.min.js"></script>
    <script src="{{ dynamicAsset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}&libraries=drawing,places&v=3.45.8">
    </script>
    <script>
        "use strict";
        $(document).on('ready', function() {
            $('.offcanvas').on('click', function(){
                $('.offcanvas, .floating--date').removeClass('active')
            })
            $('.floating-date-toggler').on('click', function(){
                $('.offcanvas, .floating--date').toggleClass('active')
            })
        });

        $(document).on('ready', function() {
            @if (isset(auth('admin')->user()->zone_id))
            $('#choice_zones').trigger('change');
            @endif
        });

        $("#customFileEg1").change(function() {
            readURL(this, 'viewer');
        });

        $("#halalCertificate").change(function() {
            readURL(this, 'halal');
        });


        $("#coverImageUpload").change(function() {
            readURL(this, 'coverImageViewer');
        });

        $('#res_form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '120px',
                groupClassName: 'col-lg-2 col-md-4 col-sm-4 col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{ dynamicAsset('public/assets/admin/img/400x400/img2.jpg') }}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error('{{ translate('messages.please_only_input_png_or_jpg_type_file') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('{{ translate('messages.file_size_too_big') }}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

                @php($default_location = \App\Models\BusinessSetting::where('key', 'default_location')->first())
                @php($default_location = $default_location->value ? json_decode($default_location->value, true) : 0)
                let myLatlng = {
                    lat: {{ $default_location ? $default_location['lat'] : '23.757989' }},
                    lng: {{ $default_location ? $default_location['lng'] : '90.360587' }}
                };
                let map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 13,
                    center: myLatlng,
                });
                var zonePolygon = null;
                let infoWindow = new google.maps.InfoWindow({
                    content: "{{  translate('Click_the_map_to_get_Lat/Lng!') }}",
                    position: myLatlng,
                });
                var bounds = new google.maps.LatLngBounds();
                function initMap() {
                    // Create the initial InfoWindow.
                    infoWindow.open(map);
                    //get current location block
                    infoWindow = new google.maps.InfoWindow();
                    // Try HTML5 geolocation.
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                myLatlng = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };
                                infoWindow.setPosition(myLatlng);
                                infoWindow.setContent("{{ translate('Location_found') }}");
                                infoWindow.open(map);
                                map.setCenter(myLatlng);
                            },
                            () => {
                                handleLocationError(true, infoWindow, map.getCenter());
                            }
                        );
                    } else {
                        // Browser doesn't support Geolocation
                        handleLocationError(false, infoWindow, map.getCenter());
                    }
                    //-----end block------
                    // Create the search box and link it to the UI element.
                    const input = document.getElementById("pac-input");
                    const searchBox = new google.maps.places.SearchBox(input);
                    map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
                    let markers = [];
                    searchBox.addListener("places_changed", () => {
                        const places = searchBox.getPlaces();
                        if (places.length == 0) {
                        return;
                        }
                        // Clear out the old markers.
                        markers.forEach((marker) => {
                        marker.setMap(null);
                        });
                        markers = [];
                        // For each place, get the icon, name and location.
                        const bounds = new google.maps.LatLngBounds();
                        places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        const icon = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25),
                        };
                        // Create a marker for each place.
                        markers.push(
                            new google.maps.Marker({
                            map,
                            icon,
                            title: place.name,
                            position: place.geometry.location,
                            })
                        );
                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                        });
                        map.fitBounds(bounds);
                    });
                }
                initMap();
                function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                    infoWindow.setPosition(pos);
                    infoWindow.setContent(
                        browserHasGeolocation ?
                        "Error: The Geolocation service failed." :
                        "Error: Your browser doesn't support geolocation."
                    );
                    infoWindow.open(map);
                }
                $('#choice_zones').on('change', function() {
                    var id = $(this).val();
                    $.get({
                        url: '{{ url('/') }}/admin/zone/get-coordinates/' + id,
                        dataType: 'json',
                        success: function(data) {
                            if (zonePolygon) {
                                zonePolygon.setMap(null);
                            }
                            zonePolygon = new google.maps.Polygon({
                                paths: data.coordinates,
                                strokeColor: "#FF0000",
                                strokeOpacity: 0.8,
                                strokeWeight: 2,
                                fillColor: 'white',
                                fillOpacity: 0,
                            });
                            zonePolygon.setMap(map);
                            zonePolygon.getPaths().forEach(function(path) {
                                path.forEach(function(latlng) {
                                    bounds.extend(latlng);
                                    map.fitBounds(bounds);
                                });
                            });
                            map.setCenter(data.center);
                            google.maps.event.addListener(zonePolygon, 'click', function(mapsMouseEvent) {
                                infoWindow.close();
                                // Create a new InfoWindow.
                                infoWindow = new google.maps.InfoWindow({
                            position: mapsMouseEvent.latLng,
                            content: JSON.stringify(mapsMouseEvent.latLng.toJSON(),
                                null, 2),
                        });
                        var coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null,
                            2);
                        var coordinates = JSON.parse(coordinates);
                                    document.getElementById('latitude').value = coordinates['lat'];
                                    document.getElementById('longitude').value = coordinates['lng'];
                                    infoWindow.open(map);
                                });
                            },
                        });
                    });
                    document.addEventListener('keypress', function (e) {
                if (e.keyCode === 13 || e.which === 13) {
                    e.preventDefault();
                    return false;
                }
            });

        $('#reset_btn').click(function(){
            $('#name').val(null);
            $('#tax').val(null);
            $('#address').val(null);
            $('#minimum_delivery_time').val(null);
            $('#maximum_delivery_time').val(null);
            $('#viewer').attr('src', "{{ dynamicAsset('public/assets/admin/img/upload.png') }}");
            $('#halal').attr('src', "{{ dynamicAsset('public/assets/admin/img/upload.png') }}");
            $('#customFileEg1').val(null);
            $('#coverImageViewer').attr('src', "{{ dynamicAsset('public/assets/admin/img/upload-img.png') }}");
            $('#coverImageUpload').val(null);
            $('#choice_zones').val(null).trigger('change');
            $('#f_name').val(null);
            $('#l_name').val(null);
            $('#phone').val(null);
            $('#email').val(null);
            $('#signupSrPassword').val(null);
            $('#signupSrConfirmPassword').val(null);
            zonePolygon.setMap(null);
            $('#coordinates').val(null);
            $('#latitude').val(null);
            $('#longitude').val(null);
        })


    $('.deliveryTime').click(function(){
        var min = $("#minimum_delivery_time").val();
        var max = $("#maximum_delivery_time").val();
        var type = $("#delivery_time_type").val();
        $("#floating--date").removeClass('active');
        $("#time_view").val(min+' to '+max+' '+type);

    })



    function validateAccountNumber() {
    var accountNumber = document.getElementById("account_number").value;
    var confirmAccountNumber = document.getElementById("confirm_account_number").value;
    var errorElement = document.getElementById("accountNumberError");

    if (accountNumber.trim() === "") {
        errorElement.textContent = "Account number is required";
        return false;
    } else if(confirmAccountNumber.trim() === ""){
        errorElement.textContent = "Confirm Account number is required";
        return false;
    }
    else if (accountNumber !== confirmAccountNumber) {
        errorElement.textContent = "Account numbers do not match";
        return false;
    } else {
        errorElement.textContent = "";
        return true;
    }

}


function validateTime() {
    var time = document.getElementById("time_view").value;
    var zone = document.getElementById("choice_zones").value;
    var timeError = document.getElementById("timeError");
    var zoneError = document.getElementById("zoneError");

    if (time.trim() === "") {
        timeError.textContent = "Time is required";
        return false;
    }else {
        timeError.textContent = "";
        return true;
    }

    if (zone.trim() === "") {
        zoneError.textContent = "Zone is required";
        return false;
    }else {
        zoneError.textContent = "";
        return true;
    }



}
</script>
@endpush

