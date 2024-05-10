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
                        Slot Time
                    </span>
                </h2>
            </div>

            <a href="" class="btn btn--primary pull-right"><i class="tio-add-circle"></i> </a>

        </div>
    </div>
    <!-- End Page Header -->
    <div class="card resturant--cate-form">
        <div class="card-body">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs">
                            @foreach($weekDays as $week)
                            <li class=""><a data-toggle="tab" href="#tabing{{$week->id}}" class="day btn btn-light ">
                                    {{$week->name}}</a></li>
                            @endforeach
                            <!-- <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
  <li><a data-toggle="tab" href="#menu2">Menu 2</a></li> -->
                        </ul>
                    </div>
                    <div class="col-12">
                        <div class="tab-content mt-4">
                            @foreach($weekDays as $week)
                            <div id="tabing{{$week->id}}" class="tab-pane fade in {{$week->id==1?'active':''}}">

                                <form action="{{route('admin.add-slot.add')}}" method="post"
                                    enctype="multipart/form-data" id="formslots{{$week->id}}">

                                    <h3>{{$week->name}}</h3>
                                    @csrf
                                    <div class="row g-2 d-flex" id="variationInputs{{$week->id}}">
                                        <div class=" d-flex gap-3 variation ">
                                            <div class="d-flex col-6  gap-3">
                                                <div class="form-group ">
                                                    <label class="input-label"
                                                        for="exampleFormControlInput1">{{ translate('messages.available_time_starts') }}</label>
                                                    <input type="time" name="slots[1][start_time]"
                                                        class="form-control available_time_starts"
                                                        id="available_time_starts"
                                                        placeholder="{{ translate('messages.Ex:_10:30_am') }} ">
                                                </div>
                                                <div class="d-flex">
                                                    <div class="form-group ">
                                                        <label class="input-label"
                                                            for="exampleFormControlInput1">{{ translate('messages.available_time_ends') }}</label>
                                                        <input type="time" name="slots[1][end_time]"
                                                            class="form-control available_time_end"
                                                            id="available_time_ends" placeholder="5:45 pm">
                                                    </div>
                                                    <span onclick="addVariation('{{$week->id}}')"
                                                        class="rounded fw-bold border border-secondary btn btn-primary  "
                                                        style="font-size: 18px; height: 40px; margin-top:55px; margin-left:20px;">
                                                        +
                                                    </span>
                                                </div>





                                            </div>

                                        </div>

                                    </div>

                                    <input type="hidden" name="slots[day_id]" value="{{$week->id}}">
                                    <!-- Static Button -->
                                    <!-- <button id="reset_btn" type="reset" class="btn btn--reset">{{translate('messages.reset')}}</button> -->
                                    <!-- Static Button -->
                                    <button type="submit"
                                        class="btn btn--primary mt-5">{{translate('messages.submit')}}</button>

                                </form>
                            </div>
                            @endforeach





                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



</div>
@endsection

@push('script_2')
<script src="{{dynamicAsset('public/assets/admin')}}/js/view-pages/category-index.js"></script>
<!-- <script>
        "use strict";
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script> -->
<script>
count = 0;
var lastClickedDay = null;

function toggleInput(day) {
    count++;
    // Hide input container of last clicked day
    if (lastClickedDay) {
        var lastClickedInputContainer = document.getElementById(
            "input-container-" + lastClickedDay
        );
        lastClickedInputContainer.style.display = "none";
    }

    // Show input container of the clicked day
    var inputContainer = document.getElementById("input-container-" + day);
    inputContainer.style.display = "block";

    // Update last clicked day
    lastClickedDay = day;
}

function addInputField(containerId, id) {
    var inputContainer = document.getElementById(containerId);
    var newInputField = document.createElement("div");
    newInputField.classList.add("input-field");
    newInputField.innerHTML =
        '<div class="d-flex gap-3" ><input type="text" class="form-control" placeholder="Enter time">' +
        '<button class="btn btn-success mt-2" onclick="addInputField(\'' +
        containerId + id "')\">+</button>" +
        '<button class="btn btn-danger mt-2" onclick="deleteInputField(this)">-</button> </div>';
    inputContainer.appendChild(newInputField);
}

function deleteInputField(button) {
    var inputContainer = button.value.parentNode.parentNode;
    inputContainer.removeChild(button.parentNode);
    console.log(inputContainer);
}
</script>
<style>
/* Preserve old styles */
.day {
    background-color: lightgray;
    margin: 10px;
    display: inline-block;
    text-align: center;

    cursor: pointer;
}

.highlight {
    background-color: lightblue;
}

.input-container {
    margin-top: 10px;
    display: none;
    /* Hide by default */
}

.input-field {
    margin-bottom: 5px;
}

.input-field input {
    width: 200px;
}
</style>
<!-- <script>
      var i=0;
$('#add').click (function(){
  ++i;

  ('#input-container-Monday').append(
    `<div class="d-flex gap-3" ><input type="text" class="form-control" placeholder="Enter time" name="input[`+i+`]['Monday']">' +
          '<button class="btn btn-success mt-2 remove" onclick="addInputField">+</button>" 
          '<button class="btn btn-danger mt-2" onclick="deleteInputField(this)">-</button> </div>`
  );
});

$(document).on('click','.remove',function(){
  $(this).parents('div').remove();
});
    </script> -->
<script>
let variations = [];
count = 1;

function addVariation(id) {
    const variationInputs = document.getElementById('variationInputs' + id);
    count++;
    // Create a new variation div
    const newVariationDiv = document.createElement('div');
    newVariationDiv.classList.add('variation');

    // Add inputs for variation name, price, and delete button
    newVariationDiv.innerHTML = `
            <div class="row">
                <div class="d-flex gap-3 mt-2">
                <div class="col d-flex variation col-6 gap-3">
                                    <div class="">
                                    <div class="form-group ">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.available_time_starts') }}</label>
                                        <input type="time" name="slots[` + count + `][start_time]" class="form-control"
                                            id="available_time_starts"
                                            placeholder="{{ translate('messages.Ex:_10:30_am') }} " required>
                                    </div>
                                    </div>
                                    <div class="">
                                    <div class="form-group ">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.available_time_ends') }}</label>
                                        <input type="time" name="slots[` + count + `][end_time]" class="form-control"
                                            id="available_time_ends" placeholder="5:45 pm" onchange=" saveVariations()" required>
                                    </div>
                                    </div>
                                    <button class="deleteVariationBtn rounded fw-bold justify-content-center fs-5 fw-bold border border-secondary btn btn-danger " style="width: 85px; height:40px; margin-top:55px;">Delete</button>
                                </div>
                 
                </div>
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

    });
}

function saveVariations() {
    // Reset variations array
    variations = [];

    // Get all variation input fields
    const variationInputs = document.querySelectorAll('.variation');

    // Loop through each variation input
    variationInputs.forEach(variationDiv => {
        const startInput = variationDiv.querySelector('.available_time_starts');
        const endInput = variationDiv.querySelector('.available_time_end');

        // Get variation name and price values
        // const variationName = startInput.value.trim();
        const variationPrice = parseFloat(endInput.value);

        // Check if both name and price are provided and price is a valid number
        if (variationName && !isNaN(variationPrice)) {
            // Create a variation object and add to variations array
            const variation = {
                start_time: variationName,
                end_time: variationPrice
            };
            variations.push(variation);
        }
    });

    // Display the collected variations in the console for debugging
    console.log(variations);
}
</script>
@endpush