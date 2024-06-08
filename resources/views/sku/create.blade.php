@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">SKU Management</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Row Sku</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-header px-4 py-3">
                        <h5 class="mb-0">Add New Row SKU</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3" method="POST"

                        @if(isset($edit))
                        action="{{ route('sku.update', $data->id) }}"
                    @else
                        action="{{ route('sku.store') }}"
                    @endif



                        enctype="multipart/form-data">

                            @if(isset($edit))
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            @else
                            @csrf
                            @endif
                            <div class="col-md-12">
                                <label for="sku" class="form-label">SKU Number</label>
                                <input type="number" class="form-control @error('sku') is-invalid @enderror" name="sku" id="sku" value="{{ isset($data) ? $data->sku :$sku }}" readonly>
                                @error('sku')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                              <div class="col-md-12">
                                <label for="label" class="form-label">SKU Label</label>
                                <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" id="label" value="{{ isset($data) ? $data->label : old('label') }}" placeholder="SKU Label" required>
                                @error('label')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                  </div>
                            @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="price" class="form-label">Price per KG/Unit</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ isset($data) ? $data->price : old('price', 0) }}" placeholder="Price per KG/Unit" step="0.01" required>
                                    <!-- 'step="0.01"' ensures that the input accepts two decimal places for the price -->
                                </div>
                                @error('price')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="image" class="form-label">SKU Image</label>
                                <div class="input-group">

                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image"  placeholder="Upload Sku image" >

                                </div>
                                @error('price')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="col-md-12">
                                <label for="unit" class="form-label">SKU Unit</label>
                                <div class="input-group" role="group" aria-label="Unit Options">
                                    <input type="hidden" name="unit" id="selectedUnit" value="{{ old('unit', isset($data) ? $data->unit : 'KG') }}">
                                    <button type="button" class="btn btn-outline-success unit-option {{ old('unit', isset($data) ? $data->unit : 'KG') == 'KG' ? 'active' : '' }}" data-value="KG">KG</button>
                                    <button type="button" class="btn btn-outline-success unit-option {{ old('unit', isset($data) ? $data->unit : 'KG') == 'C' ? 'active' : '' }}" data-value="Count">Count</button>
                                </div>
                                @error('unit')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                    



                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">

                                        @if(isset($edit))
                                        Update
                                    @else
                                        Submit
                                    @endif
                                        </button>
                                        <a href="{{ route('sku.index') }}" class="btn btn-secondary px-4">

                                         Cancel
                                        </a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->





    </div>
</div>
@endsection
@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let unitOptions = document.querySelectorAll('.unit-option');

        unitOptions.forEach(function (option) {
            option.addEventListener('click', function () {
                let selectedUnit = option.getAttribute('data-value');
                document.getElementById('selectedUnit').value = selectedUnit;

                // Remove 'active' class from all buttons
                unitOptions.forEach(function (btn) {
                    btn.classList.remove('active');
                });

                // Add 'active' class to the clicked button
                option.classList.add('active');


                // packet size
                if (selectedUnit== 'KG') {
                // Add 'required' attribute
                $('#packet_size').prop('required', true);
                $('#packet_div').show();
            } else {
                $('#packet_size').prop('required', false);
                $('#packet_div').hide();
            }
            });
        });
    });
</script>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const cityOptions = document.querySelectorAll('.city-option');

        cityOptions.forEach(function(option) {
            option.addEventListener('click', function() {
                this.classList.toggle('active');
            });
        });
    });
</script> --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cityButtons = document.querySelectorAll('.city-option');
        const selectedCitiesInput = document.getElementById('selectedCities');

        cityButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                this.classList.toggle('active');
                updateSelectedCities();
            });
        });

        function updateSelectedCities() {
            const selectedCities = Array.from(cityButtons)
                .filter(button => button.classList.contains('active'))
                .map(button => button.dataset.value);

            selectedCitiesInput.value = JSON.stringify(selectedCities);
        }

        document.getElementById('cityForm').addEventListener('submit', function () {
            updateSelectedCities();
        });
    });
</script>
 <script>
       $(document).ready(function() {
        $('#selectedUnit').on('change', function() {
            // Check if input value is not empty
            if ($(this).val()== 'KG') {
                // Add 'required' attribute
                $('#packet_size').prop('required', true);
                $('#packet_div').show();
            } else {
                $('#packet_size').prop('required', false);
                $('#packet_div').hide();
            }
        });
    });
 </script>
@endpush
