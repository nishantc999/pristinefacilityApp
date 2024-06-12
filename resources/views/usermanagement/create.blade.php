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
                                enctype="multipart/form-data" id="userForm">
                                @csrf
                                <div class="col-md-12">
                                    <label for="role_id" class="form-label">Role</label>
                                    <select class="form-control @error('role_id') is-invalid @enderror" name="role_id"
                                        id="role_id" required>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id') == $role->id ? 'selected' : '' }}
                                                data-type="{{ $role->role_type }}">{{ $role->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('role_id')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <input type="hidden" id="role_type" name="role_type"
                                    value="{{ old('role_type', $user->role->role_type ?? '') }}">
                                <div class="col-md-12" id="userIdsContainer" style="display: none;">

                                    <label for="user_ids" class="form-label">Select Users</label>
                                    <select multiple class="form-control @error('user_ids') is-invalid @enderror"
                                        id="user_ids" name="user_ids[]"data-placeholder="Choose Any">
                                        <option></option>
                                        <!-- Options will be dynamically populated using JavaScript -->
                                    </select>
                                    <div id="noUsersMessage" class="text-danger mt-2" style="display: none;"></div>
                                    <span class="invalid-feedback" role="alert" id="user_ids_error"
                                        style="display: none;">
                                        <strong>Please select at least one user.</strong>
                                    </span>
                                    @error('user_ids')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
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
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('username') }}" placeholder="username" id="username" required>
                                    @error('username')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" name="email"
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
                                        name="address" id="mobile_no" placeholder="address"
                                        value="{{ old('address') }}" required>
                                    @error('address')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-4">
                                    <label for="state_id" class="form-label">State</label>
                                    <select name="state_id" id="state_id"
                                        class="form-select @error('state_id') is-invalid @enderror"
                                        data-placeholder="Choose State" onchange="get_district_on_state_id(this)"
                                        required>
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
                                    <select name="district_id" id="district_id"
                                        class="form-select @error('district_id') is-invalid @enderror"
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
                                    <select name="city_id" id="city_id"
                                        class="form-select @error('city_id') is-invalid @enderror"
                                        data-placeholder="Choose State" required>
                                        <option value="">Select</option>
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="card" id="workassignment" style="display: none;">
                                    <div class="card-body">
                                       <h5>Assign Work (optional)</h5>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label for="client_id">Client</label>
                                        <select name="client_id" id="client_id"
                                            class="form-control @error('client_id') is-invalid @enderror">
                                            <option value="">Select Client</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="site_id">Site</label>
                                        <select name="site_id" id="site_id"
                                            class="form-control @error('site_id') is-invalid @enderror">
                                            <option value="">Select Site</option>
                                        </select>
                                        @error('site_id')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shift_id">Shift</label>
                                        <select name="shift_id" id="shift_id"
                                            class="form-control @error('shift_id') is-invalid @enderror">
                                            <option value="">Select Shift</option>
                                        </select>
                                        @error('shift_id')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                </div>
                                </div>



                                <div class="col-md-12">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="password"
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
        // $(document).ready(function () {
        //         $('#role_id').on('change', function () {
        //             const selectedRoleId = $(this).val();
        //             const roleType = $(this).find('option:selected').data('type');

        //             if (roleType == 2) {
        //                 $('#userIdsContainer').show();
        //                 fetchUsers(selectedRoleId);
        //             } else {
        //                 $('#userIdsContainer').hide();
        //                 $('#noUsersMessage').hide();
        //             }
        //         });

        //         function fetchUsers(roleId) {
        //             $.ajax({
        //                 url: '/get-users-by-role/' + roleId,
        //                 type: 'GET',
        //                 success: function (response) {
        //                     $('#user_ids').empty();
        //                     $('#noUsersMessage').hide();

        //                     if (response.users.length > 0) {
        //                         $.each(response.users, function (index, user) {
        //                             $('#user_ids').append('<option value="' + user.id + '">' + user.name + '</option>');
        //                         });
        //                     } else {
        //                         $('#noUsersMessage').text('Please create at least 1 user for the role: ' + response.child_role_name).show();
        //                     }
        //                 },
        //                 error: function (xhr, status, error) {
        //                     console.error(error);
        //                 }
        //             });
        //         }
        //     });

        $('#user_ids').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
        $(document).ready(function() {
            $('#role_id').on('change', function() {
                const selectedRoleId = $(this).val();
                const roleType = $(this).find('option:selected').data('type');

                if (roleType == 2) {
                    $('#userIdsContainer').show();
                    fetchUsers(selectedRoleId);
                    $('#user_ids').prop('required', true);
                } else {
                    $('#userIdsContainer').hide();
                    $('#noUsersMessage').hide();
                    $('#user_ids').prop('required', false);
                    $('#user_ids_error').hide();
                }
            });

            function fetchUsers(roleId) {
                $.ajax({
                    url: '/get-users-by-role/' + roleId,
                    type: 'GET',
                    success: function(response) {
                        $('#user_ids').empty();
                        $('#noUsersMessage').hide();

                        if (response.users.length > 0) {
                            $.each(response.users, function(index, user) {
                                $('#user_ids').append('<option value="' + user.id + '">' + user
                                    .name + ' /Mobile No.: ' + user.user_detail.mobile_no +
                                    '</option>');
                            });
                        } else {
                            $('#noUsersMessage').text('Please create at least 1 user for the role: ' +
                                response.child_role_name).show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            @if (old('role_id'))
                const oldRoleId = {{ old('role_id') }};
                const roleSelect = $('#role_id');
                const oldRoleType = roleSelect.find('option:selected').data('type');

                if (oldRoleType == 2) {
                    fetchUsers(oldRoleId);
                    userContainer.show();
                }
            @endif
            $('#userForm').on('submit', function(e) {
                if ($('#role_id').find('option:selected').data('type') == 2 && $('#user_ids').val()
                    .length == 0) {
                    e.preventDefault();
                    $('#user_ids_error').show();
                } else {
                    $('#user_ids_error').hide();
                }
            });
        });


        var roleSelect1 = document.getElementById('role_id');

        // Add change event listener to the role select element
        roleSelect1.addEventListener('change', function() {
            // Get the selected role ID
            var selectedRoleId = this.value;

            // Check if the selected role ID is 2 or 3
            if (selectedRoleId == 2 || selectedRoleId == 3) {
                // Show the additional input field for displaying ID
                document.getElementById('workassignment').style.display = 'flex';

            } else {
                // Hide the additional input field for displaying ID
                document.getElementById('workassignment').style.display = 'none';
            }
        });
        @if (old('role_id'))
            const oldRoleId = {{ old('role_id') }};
            const roleSelect = $('#role_id');


            if (oldRoleId == 2 || oldRoleId == 3) {
                document.getElementById('workassignment').style.display = 'flex';
            }
        @endif

        // end

        // site shift 

        $(document).ready(function() {
            $('#client_id').change(function() {
                var clientId = $(this).val();
                if (clientId) {
                    $.ajax({
                        url: '/assignments/sites/' + clientId,
                        type: 'GET',
                        success: function(data) {
                            $('#site_id').empty().append(
                                '<option value="">Select Site</option>');
                            $.each(data, function(key, value) {
                                $('#site_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#site_id').empty().append('<option value="">Select Site</option>');
                    $('#shift_id').empty().append('<option value="">Select Shift</option>');
                }
            });

            $('#site_id').change(function() {
                var siteId = $(this).val();
                if (siteId) {
                    $.ajax({
                        url: '/assignments/shifts/' + siteId,
                        type: 'GET',
                        success: function(data) {
                            $('#shift_id').empty().append(
                                '<option value="">Select Shift</option>');
                            $.each(data, function(key, value) {
                                $('#shift_id').append('<option value="' + value.id +
                                    '">' + value.name + ' (' + value.start_time +
                                    ' - ' + value.end_time + ')</option>');
                            });
                        }
                    });
                } else {
                    $('#shift_id').empty().append('<option value="">Select Shift</option>');
                }
            });
        });
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role_id');
            const userIdsContainer = document.getElementById('userIdsContainer');
            const roleTypeInput = document.getElementById('role_type');

            // Show or hide user IDs container based on role type
            function toggleUserIdsContainer() {
                const selectedOption = roleSelect.options[roleSelect.selectedIndex];
                const roleType = selectedOption.getAttribute('data-type');

                if (roleType == 2) {
                    userIdsContainer.style.display = 'block';
                    roleTypeInput.value = roleType;
                } else {
                    userIdsContainer.style.display = 'none';
                    roleTypeInput.value = roleType;
                }
            }

            // Initial call to set the state based on current role type
            toggleUserIdsContainer();

            // Add event listener to toggle container on role change
            roleSelect.addEventListener('change', toggleUserIdsContainer);

            // Ensure container is visible if role_type is 2 after validation fails
            if (roleTypeInput.value == 2) {
                userIdsContainer.style.display = 'block';
            }
        });
    </script>
@endpush
