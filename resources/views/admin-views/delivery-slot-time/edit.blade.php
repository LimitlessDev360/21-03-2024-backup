@extends('layouts.admin.app')

@section('title',translate('messages.update_slot'))

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
                        Edit Slot
                    </span>
                </h2>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.slots.update', $slot->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time" class="form-control" id="start_time" name="start_time"
                        value="{{ $slot->start_time }}" required>
                </div>

                <div class="mb-3">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $slot->end_time }}"
                        required>
                </div>

                <div class="btn--container justify-content-end mt-5">
                    <button id="reset_btn" type="button" class="btn btn--reset">{{translate('messages.reset')}}</button>
                    <button type="submit" class="btn btn--primary">{{translate('messages.update')}}</button>
                </div>

            </form>
        </div>
        <!-- End Table -->
    </div>
</div>

@endsection