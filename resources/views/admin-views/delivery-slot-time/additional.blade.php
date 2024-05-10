@extends('layouts.admin.app')

@section('title',translate('messages.add_additional_slot'))

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
                        Add Additional
                    </span>
                </h2>
            </div>
        </div>
    </div>
    <h1>Add Slots for </h1>
    <form method="POST" action="">
        @csrf
        <input type="hidden" name="day_id" value="">

        <div id="time-slots">
            <div class="time-slot">
                <div class="mb-3">
                    <label class="form-label">Start Time</label>
                    <input type="time" name="start_time[]" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">End Time</label>
                    <input type="time" name="end_time[]" class="form-control" required>
                </div>
            </div>
        </div>

        <button type="button" id="add-slot" class="btn btn-secondary">Add Another Slot</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    document.getElementById('add-slot').addEventListener('click', function() {
        let container = document.getElementById('time-slots');
        let originalSlot = container.children[0];
        let newSlot = originalSlot.cloneNode(true); // Clone the original time slot
        let removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.innerText = 'Remove';
        removeBtn.className = 'btn btn-danger btn-sm mt-2 mb-2';
        removeBtn.onclick = function() { 
            newSlot.remove(); 
        };

        newSlot.appendChild(removeBtn);
        container.appendChild(newSlot);
    });
</script>
</div>

@endsection