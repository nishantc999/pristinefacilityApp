@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Client Management</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
                {{-- <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div> --}}
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Create New Client</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3" method="POST" action="{{ route('clientmanagement.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" placeholder="Name" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-12">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="email" id="email" required>
                                    @error('email')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="col-md-12">
                                    <label for="mobile_no" class="form-label">Mobile No.</label>
                                    <input type="text" class="form-control @error('mobile_no') is-invalid @enderror"
                                        name="mobile_no" id="mobile" placeholder="Mobile No."
                                        value="{{ old('mobile_no') }}" required>
                                    @error('mobile_no')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-12">
                                    <label for="mobile_no" class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" id="mobile_no" placeholder="address" value="{{ old('address') }}"
                                        required>
                                    @error('address')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-4">
                                    <label for="state_id" class="form-label">State</label>
                                    <select name="state_id" id="state_id" class="form-select"
                                        data-placeholder="Choose State" onchange="get_district_on_state_id(this)" required>
                                        <option value="">Select</option>

                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">
                                                {{ $state->state_title }}</option>
                                        @endforeach
                                    </select>
                                        @error('state_id')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                </div>
                                <div class="col-md-4">
                                    <label for="district_id" class="form-label">District</label>
                                    <select name="district_id" id="district_id" class="form-select"
                                        data-placeholder="Choose State" onchange="get_city_on_district_id(this)" required>
                                        <option value="">Select</option>

                                    </select>

                                        @error('district_id')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                </div>
                                <div class="col-md-4">
                                    <label for="city_id" class="form-label">City</label>
                                    <select name="city_id" id="city_id" class="form-select"
                                        data-placeholder="Choose State" required>
                                        <option value="">Select</option>
                                    </select>
                                        @error('city_id')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                </div>





                               
                                <div class="col-md-12">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="mobile_no" placeholder="password"
                                        value="{{ old('password') }}" required>
                                    @error('password')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>




                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Submit</button>

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
        document.addEventListener('DOMContentLoaded', function() {
            let unitOptions = document.querySelectorAll('.unit-option');

            unitOptions.forEach(function(option) {
                option.addEventListener('click', function() {
                    let selectedUnit = option.getAttribute('data-value');
                    document.getElementById('selectedUnit').value = selectedUnit;

                    // Remove 'active' class from all buttons
                    unitOptions.forEach(function(btn) {
                        btn.classList.remove('active');
                    });

                    // Add 'active' class to the clicked button
                    option.classList.add('active');



                });
            });
        });
    </script>


    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const cityButtons = document.querySelectorAll('.city-option');
        //     const selectedCitiesInput = document.getElementById('selectedCities');

        //     cityButtons.forEach(function(button) {
        //         button.addEventListener('click', function() {
        //             this.classList.toggle('active');
        //             updateSelectedCities();
        //         });
        //     });

        //     function updateSelectedCities() {
        //         const selectedCities = Array.from(cityButtons)
        //             .filter(button => button.classList.contains('active'))
        //             .map(button => button.dataset.value);

        //         selectedCitiesInput.value = JSON.stringify(selectedCities);
        //     }

        //     document.getElementById('cityForm').addEventListener('submit', function() {
        //         updateSelectedCities();
        //     });
        // });
    </script>
 
    <script>
        document.getElementById('mobile').addEventListener('keypress', function(event) {
            // Get the input value
            let inputValue = event.target.value;

            // Ensure it's a number key and not a special key like backspace or delete
            if (!isNaN(Number(event.key))) {
                // If input length is already 10 and user tries to add more digits, prevent that
                if (inputValue.length >= 10) {
                    event.preventDefault();
                }

            } else {
                // Prevent non-numeric input
                event.preventDefault();
            }
        });

        document.getElementById('mobile').addEventListener('input', function(event) {
            let inputValue = event.target.value;
            let validationMessage = document.getElementById('validationMessage');

            if (inputValue.length != 10) {
                validationMessage.textContent = ''; // Clear previous validation message
            } else {
                validationMessage.textContent = 'Please enter exactly 10 digits.';
            }
        });
    </script>
@endpush
