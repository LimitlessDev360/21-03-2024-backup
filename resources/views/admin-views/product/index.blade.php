@extends('layouts.admin.app')

@section('title', translate('Add_New_Product'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ dynamicAsset('public/assets/admin/css/tags-input.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid"  >
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0" >
                    <h1 class="page-header-title"><i class="tio-add-circle-outlined"></i> {{ translate('messages.Add_New_Product') }}</h1>
                </div>
            </div>
        </div>

        <!-- End Page Header -->
        <form action="{{ route('admin.food.store') }}" method="post" id="food_form" enctype="multipart/form-data">
            @csrf
            <div class="row g-2">
                <div class="col-lg-6">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-body pb-0">
                            @php($language = \App\Models\BusinessSetting::where('key', 'language')->first())
                            @php($language = $language->value ?? null)
                            @php($default_lang = str_replace('_', '-', app()->getLocale()))
                                @if ($language)
                                    <!-- <ul class="nav nav-tabs mb-4">
                                        <li class="nav-item">
                                            <a class="nav-link lang_link active"
                                                href="#"
                                                id="default-link">{{ translate('Default') }}</a>
                                        </li>
                                        @foreach (json_decode($language) as $lang)
                                            <li class="nav-item">
                                                <a class="nav-link lang_link "
                                                    href="#"
                                                    id="{{ $lang }}-link">{{ \App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}</a>
                                            </li>
                                        @endforeach
                                    </ul> -->
                                @endif
                        </div>
                        @if ($language)
                            <div class="card-body">

                                <div class="lang_form"
                                id="default-form">


                                <div class="form-group">
                                    <label class="input-label"
                                        for="default_name">{{ translate('messages.name') }} *
                                    </label>
                                    <input type="text" name="name[]" id="default_name"
                                        class="form-control"
                                        placeholder="{{ translate('messages.name') }}"
                                        required

                                        oninvalid="document.getElementById('en-link').click()">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                        for="exampleFormControlInput1">{{ translate('messages.short_description') }}
                                    </label>
                                    <textarea type="text" name="description[]" class="form-control ckeditor min-height-154px"></textarea>
                                </div>
                            </div>

                                @foreach (json_decode($language) as $lang)
                                <div class="d-none lang_form"
                                id="{{ $lang }}-form">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="{{ $lang }}_name">{{ translate('messages.name') }}
                                                ({{ strtoupper($lang) }})
                                            </label>
                                            <input type="text" name="name[]" id="{{ $lang }}_name"
                                                class="form-control"
                                                placeholder="{{ translate('messages.new_food') }}"
                                                oninvalid="document.getElementById('en-link').click()">
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{ $lang }}">
                                        <div class="form-group mb-0">
                                            <label class="input-label"
                                                for="exampleFormControlInput1">{{ translate('messages.short_description') }}
                                                ({{ strtoupper($lang) }})</label>
                                            <textarea type="text" name="description[]" class="form-control ckeditor min-height-154px"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="card-body">
                                <div id="default-form">
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.name') }}
                                            ({{ translate('Default') }})</label>
                                        <input type="text" name="name[]" class="form-control"
                                            placeholder="{{ translate('messages.new_food') }}" >
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.short_description') }}</label>
                                        <textarea type="text" name="description[]" class="form-control ckeditor min-height-154px"></textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow--card-2 border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <span>{{ translate('Image') }} <small
                                        class="text-danger">({{ translate('messages.Ratio_200x200') }})</small></span>
                            </h5>
                            <div class="form-group mb-0 h-100 d-flex flex-column align-items-center justify-content-center">
                                <label>
                                    <center id="image-viewer-section" class="my-auto">
                                        <img class="initial-52 object--cover border--dashed" id="viewer"
                                            src="{{ dynamicAsset('/public/assets/admin/img/upload.png') }}"
                                            alt="banner image" />
                                        <input type="file" name="image" id="customFileEg1" class="d-none" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    </center>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-dashboard-outlined"></i>
                                </span>
                                <span> {{ translate('Info') }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <!-- <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1">{{ translate('messages.vendor') }} *<span
                                                class="input-label-secondary"></span></label>
                                        <select name="restaurant_id" id="restaurant_id"
                                            data-placeholder="{{ translate('messages.select_vendor') }}"
                                            class="js-data-example-ajax form-control"
                                            oninvalid="this.setCustomValidity('{{ translate('messages.please_select_vendor') }}')">

                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1">{{ translate('messages.category') }}<span
                                                class="input-label-secondary">*</span></label>
                                        <select name="category_id" id="categoryId"
                                            class="form-control js-select2-custom get-request"
                                            oninvalid="this.setCustomValidity('Select Category')">
                                            <option value="" selected disabled>
                                                {{ translate('Select_Category') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category['id'] }}">{{ $category['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1">{{ translate('messages.sub_category') }}<span
                                                class="input-label-secondary" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="{{ translate('messages.category_required_warning') }}"><img
                                                    src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                                    alt="{{ translate('messages.category_required_warning') }}"></span></label>
                                        <select name="sub_category_id" id="sub-categories"
                                            class="form-control js-select2-custom">
                                            <option value="" selected disabled>
                                                {{ translate('Select_Sub_Category') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-6 col-lg-3">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.food_type') }}</label>
                                        <select name="veg" id="veg"
                                            class="form-control js-select2-custom">
                                            <option value="" selected disabled>
                                                {{ translate('Select_Preferences') }}</option>
                                            <option value="0">{{ translate('messages.non_veg') }}</option>
                                            <option value="1">{{ translate('messages.veg') }}</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-md-3" id="maximum_cart_quantity">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="maximum_cart_quantity">{{ translate('messages.MaximumPurchaseQuantityLimit') }}
                                            <span
                                            class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="{{ translate('If_this_limit_is_exceeded,_customers_can_not_buy_the_product_in_a_single_purchase.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                        </label>
                                        <input type="number"  placeholder="{{ translate('messages.Ex:_10') }}" class="form-control" name="maximum_cart_quantity" min="0" id="cart_quantity">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-dashboard-outlined"></i>
                                </span>
                                <span>{{ translate('messages.addon') }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <label class="input-label"
                                for="exampleFormControlSelect1">{{ translate('Select_Add-on') }}<span
                                    class="input-label-secondary" data-toggle="tooltip"
                                    data-placement="right"
                                    data-original-title="{{ translate('messages.vendor_required_warning') }}"><img
                                        src="{{ dynamicAsset('/public/assets/admin/img/info-circle.svg') }}"
                                        alt="{{ translate('messages.vendor_required_warning') }}"></span></label>
                            <select name="addon_ids[]" class="form-control border js-select2-custom"
                                multiple="multiple" id="category_add_on">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2"><i class="tio-date-range"></i></span>
                                <span>{{ translate('messages.Availability') }} *</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.available_time_starts') }}</label>
                                        <input type="time" name="available_time_starts" class="form-control"
                                            id="available_time_starts"
                                            placeholder="{{ translate('messages.Ex:_10:30_am') }} " required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.available_time_ends') }}</label>
                                        <input type="time" name="available_time_ends" class="form-control"
                                            id="available_time_ends" placeholder="5:45 pm" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2"><i class="tio-ruppes-outlined"></i></span>
                                <span>{{ translate('Price_Information') }}</span>
                            </h5>
                        </div>
                        <div class="card-body" id="variationInputs">
                            <div class="row g-1 " class="variation">
                                <div class="col-lg-4 d-flex gap-2">
                                    <div class="form-group mb-0 w-50">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.price') }} *</label>
                                        <input type="number" min="0" max="999999999999.99" required
                                            step="0.01"  name="product_portion[1][price]" class="form-control"
                                            placeholder="{{ translate('messages.price') }}" required>
                                    </div>
                                    <div class="form-group mb-0 w-50">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.portion') }} *</label>
                                        <input type="text" min="0" max="999999999999.99" required
                                            step="0.01"  name="product_portion[1][portion]" class="form-control"
                                            placeholder="{{ translate('messages.portion') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mb-0 w-70">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.discount_type') }}

                                        </label>
                                        <select name="product_portion[1][discount_type]" class="form-control js-select2-custom">
                                            <option value="percent">{{ translate('messages.percent').' (%)' }}</option>
                                            <option value="amount">{{ translate('messages.amount').' ('.\App\CentralLogics\Helpers::currency_symbol().')'  }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mb-0 w-70">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.discount') }}
                                            <span class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="{{ translate('Currently_you_need_to_manage_discount_with_the_vendor.') }}">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                        </label>
                                        <input type="number" min="0" max="9999999999999999999999"
                                            value="0" name="product_portion[1][discount]" class="form-control"
                                            placeholder="{{ translate('messages.Ex:_100') }} ">
                                    </div>
                                </div>
                                <a onclick="addVariation()" class="rounded d-flex fw-bold justify-content-center border border-secondary btn btn-primary  align-items-center p-3" style="font-size: 18px; height: 40px; margin-top:38px;">+</a>
       
                            </div>
                            </div>
                        <div class="form-check mt-5 ml-4">
                        <input class="form-check-input" type="checkbox" id="preorderCheckbox" style= "width:15px; height:15px;">
                        <label class="form-check-label ml-2" for="preorderCheckbox">
                        Preorder
                        </label>
                        </div>

                        <div class="form-check mt-3 ml-4 mb-3">
        <input class="form-check-input" type="checkbox" id="currentOrderCheckbox" style= "width:15px; height:15px;">
        <label class="form-check-label ml-2" for="currentOrderCheckbox">
            Current Order
        </label>
    </div>
<input type="hidden" id="preorderValue" name="is_preorder" value="0">
<input type="hidden" id="currentOrderValue" name="is_current_order" value="0">
                    </div>
                </div>
                <!-- <div class="col-lg-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header flex-wrap">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-canvas-text"></i>
                                </span>
                                <span>{{ translate('messages.variations') }}</span>
                            </h5>
                            <a class="btn text--primary-2" id="add_new_option_button">
                                {{ translate('add_new_variation') }}
                                <i class="tio-add"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <div id="add_new_option">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="col-lg-12">
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
                </div>
                <div class="col-lg-12">
                    <div class="btn--container justify-content-end">
                        <button type="reset" id="reset_btn"
                            class="btn btn--reset">{{ translate('messages.reset') }}</button>
                        <button type="submit"
                            class="btn btn--primary">{{ translate('messages.submit') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection


@push('script_2')
    <script src="{{ dynamicAsset('public/assets/admin') }}/js/tags-input.min.js"></script>
    <script src="{{ dynamicAsset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{dynamicAsset('public/assets/admin')}}/js/view-pages/product-index.js"></script>
    <script>
        "use strict";
        $(document).ready(function() {
            $("#add_new_option_button").click(function(e) {
                $('#empty-variation').hide();
                count++;
                let add_option_view = `
                    <div class="__bg-F8F9FC-card view_new_option mb-2">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <label class="form-check form--check">
                                    <input id="options[` + count + `][required]" name="options[` + count + `][required]" class="form-check-input" type="checkbox">
                                    <span class="form-check-label">{{ translate('Required') }}</span>
                                </label>
                                <div>
                                    <button type="button" class="btn btn-danger btn-sm delete_input_button"
                                        title="{{ translate('Delete') }}">
                                        <i class="tio-add-to-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-xl-4 col-lg-6">
                                    <label for="">{{ translate('name') }}</label>
                                    <input required name=options[` + count +
                    `][name] class="form-control new_option_name" type="text" data-count="`+
                    count +`">
                                </div>

                                <div class="col-xl-4 col-lg-6">
                                    <div>
                                        <label class="input-label text-capitalize d-flex align-items-center"><span class="line--limit-1">{{ translate('messages.selcetion_type') }} </span>
                                        </label>
                                        <div class="resturant-type-group px-0">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input show_min_max" data-count="`+count+`" type="radio" value="multi"
                                                name="options[` + count + `][type]" id="type` + count +
                    `" checked
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Multiple Selection') }}
                    </span>
                </label>

                <label class="form-check form--check mr-2 mr-md-4">
                    <input class="form-check-input hide_min_max" data-count="`+count+`" type="radio" value="single"
                    name="options[` + count + `][type]" id="type` + count +
                    `"
                                                >
                                                <span class="form-check-label">
                                                    {{ translate('Single Selection') }}
                    </span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6">
        <div class="row g-2">
            <div class="col-6">
                <label for="">{{ translate('Min') }}</label>
                                            <input id="min_max1_` + count + `" required  name="options[` + count + `][min]" class="form-control" type="number" min="1">
                                        </div>
                                        <div class="col-6">
                                            <label for="">{{ translate('Max') }}</label>
                                            <input id="min_max2_` + count + `"   required name="options[` + count + `][max]" class="form-control" type="number" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="option_price_` + count + `" >
                                <div class="bg-white border rounded p-3 pb-0 mt-3">
                                    <div  id="option_price_view_` + count + `">
                                        <div class="row g-3 add_new_view_row_class mb-3">
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">{{ translate('Option_name') }}</label>
                                                <input class="form-control" required type="text" name="options[` +
                    count +
                    `][values][0][label]" id="">
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <label for="">{{ translate('Additional_price') }}</label>
                                                <input class="form-control" required type="number" min="0" step="0.01" name="options[` +
                    count + `][values][0][optionPrice]" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 p-3 mr-1 d-flex "  id="add_new_button_` + count +
                    `">
                                        <button type="button" class="btn btn--primary btn-outline-primary add_new_row_button" data-count="`+
                    count +`">{{ translate('Add_New_Option') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;

                $("#add_new_option").append(add_option_view);
            });
        });

        function add_new_row_button(data) {
            count = data;
            countRow = 1 + $('#option_price_view_' + data).children('.add_new_view_row_class').length;
            let add_new_row_view = `
            <div class="row add_new_view_row_class mb-3 position-relative pt-3 pt-sm-0">
                <div class="col-md-4 col-sm-5">
                        <label for="">{{ translate('Option_name') }}</label>
                        <input class="form-control" required type="text" name="options[` + count + `][values][` +
                countRow + `][label]" id="">
                    </div>
                    <div class="col-md-4 col-sm-5">
                        <label for="">{{ translate('Additional_price') }}</label>
                        <input class="form-control"  required type="number" min="0" step="0.01" name="options[` +
                count +
                `][values][` + countRow + `][optionPrice]" id="">
                    </div>
                    <div class="col-sm-2 max-sm-absolute">
                        <label class="d-none d-sm-block">&nbsp;</label>
                        <div class="mt-1">
                            <button type="button" class="btn btn-danger btn-sm deleteRow"
                                title="{{ translate('Delete') }}">
                                <i class="tio-add-to-trash"></i>
                            </button>
                        </div>
                </div>
            </div>`;
            $('#option_price_view_' + data).append(add_new_row_view);

        }

        $('#restaurant_id').on('change', function () {
            let route = '{{ url('/') }}/admin/restaurant/get-addons?data[]=0&restaurant_id=';
            let restaurant_id = $(this).val();
            let id = 'add_on';
            getRestaurantData(route,restaurant_id, id);

        });

        $('#categoryId').on('change', function () {
            let route = '{{ url('/') }}/admin/restaurant/get_category_addons?data[]=0&category_id=';
            let restaurant_id = $(this).val();
            let id = 'category_add_on';
            getAddonsData(route,restaurant_id, id);

        });
        function getRestaurantData(route, restaurant_id, id) {
            $.get({
                url: route + restaurant_id,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        function getAddonsData(route, category_id, id) {
            $.get({
                url: route + category_id,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        $('.get-request').on('change', function () {
            let route = '{{ url('/') }}/admin/food/get-categories?parent_id='+$(this).val();
            let id = 'sub-categories';
            getRequest(route, id);
        });

        function getRequest(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function(data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        $(document).on('ready', function() {
            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
        $('.js-data-example-ajax').select2({
            ajax: {
                url: '{{ url('/') }}/admin/restaurant/get-restaurants',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#food_form').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{ route('admin.food.store') }}',
                data: $('#food_form').serialize(),
                data: formData,                
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    console.log(data);
                    if (data.errors) {
                        for (let i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('{{ translate('messages.product_added_successfully') }}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function() {
                            location.href =
                                '{{ route('admin.food.list') }}';
                        }, 2000);
                    }
                }
            });
        });

        $('#reset_btn').click(function() {
            $('#restaurant_id').val(null).trigger('change');
            $('#category_id').val(null).trigger('change');
            $('#categories').val(null).trigger('change');
            $('#sub-veg').val(0).trigger('change');
            $('#add_on').val(null).trigger('change');
            $('#viewer').attr('src', "{{ dynamicAsset('public/assets/admin/img/upload.png') }}");
        })
        </script>
            <script>
        let variations = [];
count=1;
        function addVariation() {
            count++;
            const variationInputs = document.getElementById('variationInputs');

            // Create a new variation div
            const newVariationDiv = document.createElement('div');
            newVariationDiv.classList.add('variation');

            // Add inputs for variation name, price, and delete button
            newVariationDiv.innerHTML = `
            
          
            <div class="d-flex mt-2 row ">
 <div class="col-lg-4 d-flex gap-2">
                                    <div class="form-group  mb-0 w-50">
                                    <label class="input-label"
                                            for="exampleFormControlInput1"> </label>
                                        <input type="number" min="0" max="999999999999.99"  required 
                                            step="0.01"  name="product_portion[`+ count +`][price]" class="form-control price w-100"
                                            placeholder="{{ translate('messages.price') }}"  required>
                                    </div>
                                    <div class="form-group   mb-0 w-50"  >
                                    <label class="input-label"
                                            for="exampleFormControlInput1"></label>
                                        <input type="text" min="0" max="999999999999.99" required 
                                            step="0.01"  name="product_portion[`+ count +`][portion]" class="form-control portion w-100"
                                            placeholder="{{ translate('messages.portion') }}"  required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mb-0 w-80" >
                                    <label class="input-label"
                                            for="exampleFormControlInput1"></label>
                                        <select name="product_portion[`+ count +`][discount_type]" class="form-control js-select2-custom " >
                                            <option value="percent">{{ translate('messages.percent').' (%)' }}</option>
                                            <option value="amount">{{ translate('messages.amount').' ('.\App\CentralLogics\Helpers::currency_symbol().')'  }}</option>
                                        </select >
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group  mb-0 w-80 " >
                                    <label class="input-label"
                                            for="exampleFormControlInput1"></label>
                                        <input type="number" min="0" max="9999999999999999999999"
                                            value="0" name="product_portion[`+ count +`][discount]" class="form-control"
                                            placeholder="{{ translate('messages.Ex:_100') }} " >
                                    </div>
                                </div>

                    <button class="deleteVariationBtn rounded fw-bold justify-content-center fs-5 fw-bold border border-secondary btn btn-danger  p-1" style="height: 40px; width:70px;">Delete</button>
              
                </div>
         
            `;

            // Append the new variation div to the container
            variationInputs.appendChild(newVariationDiv);

            // Attach event listener to the delete button within this variation div
            const deleteBtn = newVariationDiv.querySelector('.deleteVariationBtn');
            deleteBtn.addEventListener('click', () => {
                // Remove the entire variation div when delete button is clicked
                variationInputs.removeChild(newVariationDiv);
                // After removing, save variations again to update the array
                console.log(variationInputs);
            });
        }

        // function saveVariations() {
        //     // Reset variations array
         
        //     variations = [];
         
        //     // Get all variation input fields
        //     const variationInputs = document.querySelectorAll('.variation');

        //     // Loop through each variation input
        //     variationInputs.forEach(variationDiv => {
        //         const nameInput = variationDiv.querySelector('.price');
        //         const priceInput = variationDiv.querySelector('.portion');

        //         // Get variation name and price values
        //         const variationName = nameInput.value.trim();
        //         const variationPrice = parseFloat(priceInput.value);

        //         // Check if both name and price are provided and price is a valid number
        //         if (variationName && !isNaN(variationPrice)) {
        //             // Create a variation object and add to variations array
        //             const variation = {
        //                 name: variationName,
        //                 price: variationPrice
        //             };
        //             variations.push(variation);
        //         }
        //     });

        //     // Display the collected variations in the console for debugging
        //     console.log(variations);
        // }
    </script>
    <script>
    // JavaScript to update hidden input fields based on checkbox state
    document.getElementById('preorderCheckbox').addEventListener('change', function() {
        document.getElementById('preorderValue').value = this.checked ? 1 : 0;
    });

    document.getElementById('currentOrderCheckbox').addEventListener('change', function() {
        document.getElementById('currentOrderValue').value = this.checked ? 1 : 0;
    });
</script>

@endpush
