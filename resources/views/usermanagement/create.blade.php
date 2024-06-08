@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User Management</div>
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
                            <h5 class="mb-0">Create New User</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3" method="POST" action="{{ route('usermanagement.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label for="role_id" class="form-label">Role</label>
                                    <select class="form-control @error('role_id') is-invalid @enderror" name="role_id"
                                        id="role_id" required>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('role_id')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>






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
                                <div class="col-md-6">
                                    <label for="mobile_no" class="form-label">State</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                                        name="state" id="mobile_no" placeholder="state" value="{{ old('state') }}"
                                        required>
                                    @error('state')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control @error('city_name') is-invalid @enderror"
                                        name="city_name" id="city_name" placeholder="City Name"
                                        value="{{ old('city_name') }}" required>
                                    @error('city_name')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>




                                {{-- <div class="col-md-12" id="single_warehouse_div">
                                <label for="warehouse" class="form-label">Select Warehouse</label>
                                <select class="form-control @error('warehouse') is-invalid @enderror"  value="{{ old('warehouse') }}" id="warehouse"  name="warehouse" required>
                                    <option value="">Select Warehouse</option>
                                   @foreach ($warehouses as $warehouse)
                                    <option value="{{$warehouse->id}}" {{old('warehouse')==$warehouse->id?'selected':''}}>{{$warehouse->name}}</option>
                                   @endforeach

                               </select>
                                @error('city')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                  </div>
                            @enderror

                            </div> --}}


                                {{-- <div class="col-md-12" id="distributor_city_div">
                                <label for="cities" class="form-label">Belongs to Cities</label>
                                <div class="input-group" role="group" aria-label="City Options">
                                    @foreach ($cities as $city)


                                        <button type="button" style="margin-right: 5px;" class="btn btn-outline-primary city-option " data-value="{{ $city->id }}">{{ $city->city_name }}</button>
                                    @endforeach
                                    <input type="hidden" name="distributor_cities" id="selectedCities" >
                                </div>
                                @error('distributor_cities')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> --}}
                                {{--    <div class="col-md-12" id="distributor_city_div">
                                    <label for="multiple-select-field" class="form-label">Belongs to Cities</label>
                                    <select class="form-select" id="multiple-select-field"
                                        data-placeholder="Choose Cities" name="distributor_cities[]" multiple>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ old('city') == $city->id ? 'selected' : '' }}>{{ $city->city_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('distributor_cities')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                 --}}
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
        $(document).ready(function() {

            $('#legal_name_div').hide();
            $('#distributor_city_div').hide();
            $('#distributor_div').hide();
            $('#warehouse_div').hide();

            if ($('#role_id').val() != 6) {
                $('#fe_div').hide();
            }
            if ($('#role_id').val() == 1) {
                $('#distributor_city_div').show();
                $('#single_city_div').hide();


            }
            if ($('#role_id').val() == 2 || $('#role_id').val() == 1) {
                $('#legal_name_div').show();
                $('#single_city_div').hide();


            }
            if ($('#role_id').val() == 3 || $('#role_id').val() == 4 || $('#role_id').val() ==
                5) { // for admin role id and security
                $('#distributor_div').show();
                $('#warehouse_div').show();
                $('#single_city_div').show();
            }

            if ($('#role_id').val() == 6) { // for admin role id and security
                $('#distributor_div').show();
                $('#warehouse_div').hide();
                $('#single_city_div').show();
                $('#fe_div').show();
            }
            // for goverment
            if ($('#role_id').val() == 7 || $('#role_id').val() == 8) {
                $('#single_city_div').hide();
            }





            $('#role_id').change(function() {
                var role_id = $(this).val();

                // Make AJAX request
                $.ajax({
                    url: "{{ route('role.get_role_name') }}",
                    method: 'GET',
                    data: {
                        role_id
                    },
                    success: function(response) {
                        if (response.role_id == 2 || response.role_id ==
                            1) { // role id 2 for Miller, 1 for Distributor
                            $('#legal_name_div').show();
                            $('#single_city_div').hide();
                            // $('#legal_name').prop('required', true);

                            if (response.role_id == 1) {

                                $('#distributor_city_div').show();
                                $('#city').prop('required', false);
                            } else {
                                // $('#single_city_div').show();
                                // $('#city').prop('required', true);
                                $('#distributor_city_div').hide();
                            }

                        } else {
                            $('#legal_name_div').hide();
                            $('#legal_name').prop('required', false);
                        }
                        // if (response.role_id == 6) {
                        //     $('#fe_div').show();
                        // } else {
                        //     $('#fe_div').hide();
                        // }


                        // for admin
                        if (response.role_id == 3 || response.role_id == 5 || response
                            .role_id == 4) {
                            $('#distributor_div').show();
                            // $('#distributor').prop('required', true);
                            $('#warehouse_div').show();
                            $('#single_city_div').show();
                        } else {
                            $('#distributor_div').hide();
                            $('#distributor').prop('required', false);
                            $('#warehouse_div').hide();
                        }
                        if (response.role_id == 6) {
                            $('#fe_div').show();
                            $('#distributor_div').show();
                            // $('#distributor').prop('required', true);
                            $('#warehouse_div').hide();
                            $('#single_city_div').show();
                        } else {
                            $('#fe_div').hide();
                        }
                        if (response.role_id == 7 || response.role_id == 8) {
                            $('#single_city_div').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });


        });






        document.getElementById("username").addEventListener("keypress", function(event) {
            var usernameInput = event.target.value + event
            .key; // Get the value of the username input including the newly pressed key

            // Define a regular expression pattern for valid usernames
            var usernamePattern =
            /^[a-zA-Z0-9_.]{0,50}$/; // Modified to allow up to 20 characters for real-time validation

            // Check if the username matches the pattern
            if (!usernamePattern.test(usernameInput)) {
                event.preventDefault(); // Prevent default action (typing invalid characters)
            }
        });
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
