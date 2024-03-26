@extends('layouts.admin.app')

@section('title','Assgin Products')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">
                        <div class="card-header-icon d-inline-flex mr-2 img">
                            <img src="{{dynamicAsset('public/assets/admin/img/sub-category.png')}}" alt="">
                        </div>
                        <span>Assign products to vendor</span>
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card resturant--cate-form">
            <div class="card-body">
                <form action="{{ route('admin.restaurant.assign-products', [$data]) }}" method="POST"
            class="js-validate" id="res_form">
                @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-label"
                                    for="parent_id">Products
                                    <span class="input-label-secondary">*</span></label>
                                    <select name="product_ids[]" class="form-control border js-select2-custom"
                                multiple="multiple">
                                <option>Select Product</option>
                                    @foreach($foods as $food)
                                        <option value="{{$food['id']}}" >{{$food['name']}}</option>
                                    @endforeach
                            </select>

                            </div>
                        </div>
                        <!-- <h3>{{$data}}</h3> -->
                        <!-- <div class="col-md-6">

                            <div class="form-group lang_form" id="default-form">
                                <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}}</label>
                                <input type="text" name="purchase_price" class="form-control" placeholder="{{ translate('Ex:_Sub_Category_Name') }}"   maxlength="191" required>
                            </div>

             
                        </div> -->
                        <div class="col-md-12">
                            <div class="btn--container justify-content-end">
                                <!-- Static Button -->
                                <button type="reset" id="reset_btn" class="btn btn--reset">{{translate('reset')}}</button>
                                <!-- Static Button -->
                                <button type="submit" class="btn btn--primary">Assign</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">{{translate('messages.sub_category_list')}}<span class="badge badge-soft-dark ml-2" id="itemCount">2</span></h5>
                    <form>
                        <!-- Search -->
                        <div class="input--group input-group input-group-merge input-group-flush">
                            <input id="datatableSearch" name="search" value="" type="search" class="form-control" placeholder="{{ translate('Ex_:_Sub_Categories') }}" aria-label="{{translate('messages.search_sub_categories')}}">
                            <input type="hidden" name="sub_category" value="1">
                            <button type="submit" class="btn btn--secondary">
                                <i class="tio-search"></i>
                            </button>
                        </div>
                        <!-- End Search -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script src="{{dynamicAsset('public/assets/admin')}}/js/view-pages/sub-category-index.js"></script>
    <script>
                $('#res_form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
    </script>
@endpush
