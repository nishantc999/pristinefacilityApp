@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Employee Management</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                            <h5 class="mb-0">Edit User</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3" method="POST" action="{{ route('employeemanagement.update', $employee->id) }}"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-group">
                                    <label for="emp_code">Employee Code:</label>
                                    <input type="text" name="emp_code" class="form-control @error('emp_code') is-invalid @enderror" value="{{ old('emp_code', $employee->emp_code) }}" placeholder="Enter Employee Code" readonly disabled>
                                    @error('emp_code')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $employee->name) }}" placeholder="Enter Name">
                                    @error('name')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $employee->email) }}" placeholder="Enter Email">
                                    @error('email')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                             
                        
                                <div class="col-md-6">
                                    <label for="father_name">Father's Name:</label>
                                    <input type="text" name="father_name" class="form-control @error('father_name') is-invalid @enderror" value="{{ old('father_name', $employee->father_name) }}" placeholder="Enter Father's Name">
                                    @error('father_name')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_name">Mother's Name:</label>
                                    <input type="text" name="mother_name" class="form-control @error('mother_name') is-invalid @enderror" value="{{ old('mother_name', $employee->mother_name) }}" placeholder="Enter Mother's Name">
                                    @error('mother_name')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="gender">Gender:</label>
                                    <input type="text" name="gender" class="form-control @error('gender') is-invalid @enderror" value="{{ old('gender', $employee->gender) }}" placeholder="Enter Gender">
                                    @error('gender')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="age">Age:</label>
                                    <input type="text" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age', $employee->age) }}" placeholder="Enter Age">
                                    @error('age')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="blood_group">Blood Group:</label>
                                    <input type="text" name="blood_group" class="form-control @error('blood_group') is-invalid @enderror" value="{{ old('blood_group', $employee->blood_group) }}" placeholder="Enter Blood Group">
                                    @error('blood_group')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nominee_name">Nominee Name:</label>
                                    <input type="text" name="nominee_name" class="form-control @error('nominee_name') is-invalid @enderror" value="{{ old('nominee_name', $employee->nominee_name) }}" placeholder="Enter Nominee Name">
                                    @error('nominee_name')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nominee_relation">Relationship With Nominee:</label>
                                    <input type="text" name="nominee_relation"
                                        class="form-control @error('nominee_relation') is-invalid @enderror"
                                        value="{{ old('nominee_relation', $employee->nominee_relation) }}" placeholder="Enter Relationship With Nominee">
                                    @error('nominee_relation')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="form-group">
                                    <label for="registration_status">Registration Status:</label>
                                    <input type="checkbox" name="registration_status" class="form-control @error('registration_status') is-invalid @enderror" value="1" {{ old('registration_status', $employee->registration_status) ? 'checked' : '' }}>
                                    @error('registration_status')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                <div class="col-md-6">
                                    <label for="dob">Date of Birth:</label>
                                    <input type="text" name="dob" class="form-control datepicker @error('dob') is-invalid @enderror" value="{{ old('dob', $employee->dob) }}" placeholder="Enter Date of Birth">
                                    @error('dob')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="date_of_joining">Date of Joining:</label>
                                    <input type="text" name="date_of_joining" class="form-control datepicker @error('date_of_joining') is-invalid @enderror" value="{{ old('date_of_joining', $employee->date_of_joining) }}" placeholder="Enter Date of Joining">
                                    @error('date_of_joining')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="mobile_no">Mobile Number:</label>
                                    <input type="text" name="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" value="{{ old('mobile_no', $employee->mobile_no) }}" placeholder="Enter Mobile Number">
                                    @error('mobile_no')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="p_address">Permanent Address:</label>
                                    <textarea name="p_address" class="form-control @error('p_address') is-invalid @enderror" rows="3" placeholder="Enter Permanent Address">{{ old('p_address', $employee->employeeDetail->p_address) }}</textarea>
                                    @error('p_address')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="c_address">Current Address:</label>
                                    <textarea name="c_address" class="form-control @error('c_address') is-invalid @enderror" rows="3" placeholder="Enter Alternate Address">{{ old('c_address', $employee->employeeDetail->c_address) }}</textarea>
                                    @error('c_address')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="state_id" class="form-label">State</label>
                                    <select name="state_id" id="state_id" class="form-select"
                                        data-placeholder="Choose State" onchange="get_district_on_state_id(this)"
                                        required>
                                        <option value="">Select</option>

                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}"
                                                {{ $employee->employeeDetail->state_id == $state->id ? 'selected' : '' }}>
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
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $employee->employeeDetail->district_id == $district->id ? 'selected' : '' }}>
                                                {{ $district->district_title }}</option>
                                        @endforeach

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
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ $employee->employeeDetail->city_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                           
                                <div class="col-md-6">
                                    <label for="total_experience">Total Experience:</label>
                                    <input type="text" name="total_experience" class="form-control @error('total_experience') is-invalid @enderror" value="{{ old('total_experience', $employee->total_experience) }}" placeholder="Enter Total Experience">
                                    @error('total_experience')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="qualification">Qualification:</label>
                                    <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror" value="{{ old('qualification', $employee->qualification) }}" placeholder="Enter Qualification">
                                    @error('qualification')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="designation">Designation:</label>
                                    <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $employee->designation) }}" placeholder="Enter Designation">
                                    @error('designation')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="expertise">Expertise:</label>
                                    <input type="text" name="expertise" class="form-control @error('expertise') is-invalid @enderror" value="{{ old('expertise', $employee->expertise) }}" placeholder="Enter Expertise">
                                    @error('expertise')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="salary">Salary:</label>
                                    <input type="number" step="0.01" name="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary', $employee->salary) }}" placeholder="Enter Salary">
                                    @error('salary')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group card card-body">
                                    <h6>Assign Work</h6>
                                    <div class="form-group">
                                        <label for="shift_id">Select Client:</label>
                                        <select name="client_id" id="client_id"
                                            class="form-control @error('client_id') is-invalid @enderror" 
                                            >
                                            <option value="">Select Client</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}" {{ old('client_id', $employee->client_id) == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                    
                                        @error('client_id')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="shift_id">Select Shift:</label>
                                        <select name="shift_id" id="shift_id"
                                            class="form-control @error('shift_id') is-invalid @enderror" onchange="get_shift_wise_site(this)">
                                            <option value="">Select Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}" {{ old('shift_id', $employee->shift_id) == $shift->id ? 'selected' : '' }}>
                                                    {{ $shift->name }} ({{ $shift->start_time->format('H:i') }} - {{ $shift->end_time->format('H:i') }})
                                                </option>
                                            @endforeach
                                        </select>
                                    
                                        @error('shift_id')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="site_id">Select Site:</label>
                                        <select name="site_id" id="site_id"
                                            class="form-control @error('site_id') is-invalid @enderror" onchange="getAreaSiteWise(this)">
                                            <option value="">Select Site</option>
                                            @foreach ($sites as $site)
                                                <option value="{{ $site->id }}" {{ old('site_id', $employee->site_id) == $site->id ? 'selected' : '' }}>{{ $site->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('site_id')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="area_id">Select Area:</label>
                                        <select name="area_id" id="area_id"
                                            class="form-control @error('area_id') is-invalid @enderror">
                                            <option value="">Select Area</option>
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}" {{ old('area_id', $employee->area_id) == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('area_id')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="family_detail">Family Details:</label>
                                    <div id="family-details-container">
                                        @foreach ($employee->family_detail as $index => $detail)
                                            <div class="family-detail-entry card card-body">
                                                <input type="text" name="family_detail[{{ $index }}][name]" class="form-control mb-2 @error('family_detail.' . $index . '.name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('family_detail.' . $index . '.name', $detail['name']) }}" required>
                                                @error('family_detail.' . $index . '.name')
                                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                @enderror
                        
                                                <input type="text" name="family_detail[{{ $index }}][dob]" class="form-control mb-2 datepicker @error('family_detail.' . $index . '.dob') is-invalid @enderror" value="{{ old('family_detail.' . $index . '.dob', $detail['dob']) }}" placeholder="Enter Date of Birth" required>
                                                @error('family_detail.' . $index . '.dob')
                                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                @enderror
                        
                                                <input type="text" name="family_detail[{{ $index }}][age]" class="form-control mb-2 @error('family_detail.' . $index . '.age') is-invalid @enderror" placeholder="Enter Age" value="{{ old('family_detail.' . $index . '.age', $detail['age']) }}" required>
                                                @error('family_detail.' . $index . '.age')
                                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                @enderror
                        
                                                <input type="text" name="family_detail[{{ $index }}][sex]" class="form-control mb-2 @error('family_detail.' . $index . '.sex') is-invalid @enderror" placeholder="Enter Sex" value="{{ old('family_detail.' . $index . '.sex', $detail['sex']) }}" required>
                                                @error('family_detail.' . $index . '.sex')
                                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                @enderror
                        
                                                <input type="text" name="family_detail[{{ $index }}][relationship]" class="form-control mb-2 @error('family_detail.' . $index . '.relationship') is-invalid @enderror" placeholder="Enter Relationship" value="{{ old('family_detail.' . $index . '.relationship', $detail['relationship']) }}" required>
                                                @error('family_detail.' . $index . '.relationship')
                                                    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                                @enderror
                        
                                                {{-- <button type="button" class="btn btn-danger remove-family-detail">Remove</button> --}}
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-primary mt-2" id="add-family-detail">Add More Family Member</button>
                                </div>
                        
                                <div class="form-group">
                                    <label for="documents">Documents:</label>
                                    <br>
                                    <label for="documents">Aadhar card:</label>
                                    <input type="file" name="aadhar_card" class="form-control mb-2"
                                        accept="image/*,.pdf">
                                    <label for="documents">Pan card:</label>
                                    <input type="file" name="pan_card" class="form-control mb-2"
                                        accept="image/*,.pdf">
                                        <label for="documents">passbook:</label>
                                    <input type="file" name="passbook" class="form-control mb-2"
                                        accept="image/*,.pdf">
                                        <label for="documents">Police verification:</label>
                                    <input type="file" name="police_verification" class="form-control mb-2"
                                        accept="image/*,.pdf">
                                        <label for="documents">Medical:</label>
                                    <input type="file" name="medical" class="form-control mb-2"
                                        accept="image/*,.pdf">
                                </div>

                                <div class="form-group">
                                    <label for="registration_status">Registration Status:</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input" type="radio" name="registration_status" value="1" id="flexCheckSuccess" {{ old('registration_status', $employee->registration_status) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexCheckSuccess">
                                                Completed
                                            </label>
                                        </div>
                                        <div class="form-check form-check-danger">
                                            <input class="form-check-input" type="radio" name="registration_status" value="0" id="flexCheckDanger" {{ old('registration_status', $employee->registration_status) == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexCheckDanger">
                                                Pending
                                            </label>
                                        </div>
                                        @error('registration_status')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
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



        </div>
    </div>
@endsection
@push('script')
<script>
        $( '#client_id' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    } );
$(document).ready(function() {
        $('#client_id').on('change', function() {
            var clientId = $(this).val();
            if (clientId) {
                $.ajax({
                    url: '/get-shifts/' + clientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#shift_id').empty();
                        $('#shift_id').append('<option value="">Select Shift</option>');
                        $.each(data, function(key, value) {
                            $('#shift_id').append('<option value="' + value.id + '">' + value.name + ' ('+value.start_time +' - '+value.end_time+')'+'</option>');
                        });
                    }
                });
            } else {
                $('#shift_id').empty();
                $('#shift_id').append('<option value="">Select Shift</option>');
            }
        });
    });
    function get_shift_wise_site(e) {
        var shiftId = $('#shift_id').val();
        var id = $('#client_id').val();
      
        var shiftId = $('#shift_id').val();
        if (id != null) {
            $.ajax({
                type: "get",

                url: "{{ route('clientmanagement.getSiteByClientAndShift') }}",
                data: {
                   
                    clientId: id,
                    shiftId: shiftId
                },

                success: function(result) {

                    $('#site_id').html('<option value="">Select Site</option>');
                    $.each(result, function(index, site) {
                        $('#site_id').append('<option value="' + site.id + '">' + site.name +
                            '</option>');
                    });



                }
            });
        }

    }

    function getAreaSiteWise(e) {
        id = e.value;
    
        if (id != null) {
            $.ajax({
                type: "get",

                url: "{{ route('clientmanagement.getAreaSiteWise') }}",
                data: {
                    site_id: id,
                 
                },

                success: function(result) {

                    $('#area_id').html('<option value="">Select Site</option>');
                    $.each(result, function(index, site) {
                        $('#area_id').append('<option value="' + site.id + '">' + site.name +
                            '</option>');
                    });



                }
            });
        }

    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let familyDetailIndex = {{ count($employee->family_detail) }};

        document.getElementById('add-family-detail').addEventListener('click', function() {
            const container = document.getElementById('family-details-container');
            const newEntry = document.createElement('div');
            newEntry.className = 'family-detail-entry card card-body';

            newEntry.innerHTML = `
                <input type="text" name="family_detail[${familyDetailIndex}][name]" class="form-control mb-2" placeholder="Enter Name" required>
                <input type="text" name="family_detail[${familyDetailIndex}][dob]" class="form-control mb-2 datepicker" placeholder="Enter Date of Birth" required>
                <input type="text" name="family_detail[${familyDetailIndex}][age]" class="form-control mb-2" placeholder="Enter Age" required>
                <input type="text" name="family_detail[${familyDetailIndex}][sex]" class="form-control mb-2" placeholder="Enter Sex" required>
                <input type="text" name="family_detail[${familyDetailIndex}][relationship]" class="form-control mb-2" placeholder="Enter Relationship" required>
                <button type="button" class="btn btn-danger remove-family-detail w-25">Remove</button>
            `;

            container.appendChild(newEntry);

            newEntry.querySelector('.remove-family-detail').addEventListener('click', function() {
                newEntry.remove();
            });

            familyDetailIndex++;
        });

        document.querySelectorAll('.remove-family-detail').forEach(button => {
            button.addEventListener('click', function() {
                button.parentElement.remove();
            });
        });
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
