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
                            <h5 class="mb-0">Add New Employee</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3" method="POST" action="{{ route('employeemanagement.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="emp_code">Employee Code:</label>
                                    <input type="text" name="emp_code" readonly
                                        class="form-control @error('emp_code') is-invalid @enderror"
                                        value="{{ $EmpCode+1 }}" placeholder="Enter Employee Code">
                                    @error('emp_code')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        placeholder="Enter Name" required>
                                    @error('name')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Enter Email">
                                    @error('email')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                              

                        
                              
                                <div class="form-group">
                                    <label for="father_name">Father's Name:</label>
                                    <input type="text" name="father_name"
                                        class="form-control @error('father_name') is-invalid @enderror"
                                        value="{{ old('father_name') }}" placeholder="Enter Father's Name" required>
                                    @error('father_name')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="mother_name">Mother's Name:</label>
                                    <input type="text" name="mother_name"
                                        class="form-control @error('mother_name') is-invalid @enderror"
                                        value="{{ old('mother_name') }}" placeholder="Enter Mother's Name" required>
                                    @error('mother_name')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender:</label>
                                   
                                        <select name="gender" id="gender"
                                        class="form-control @error('gender') is-invalid @enderror" required>
                                        <option value="">Select Gender</option>
                                        <option value="M">male</option>
                                        <option value="F">Female</option>
                                        <option value="O">Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="age">Age:</label>
                                    <input type="text" name="age"
                                        class="form-control @error('age') is-invalid @enderror"
                                        value="{{ old('age') }}" placeholder="Enter Age" >
                                    @error('age')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="blood_group">Blood Group:</label>
                                    <input type="text" name="blood_group"
                                        class="form-control @error('blood_group') is-invalid @enderror"
                                        value="{{ old('blood_group') }}" placeholder="Enter Blood Group">
                                    @error('blood_group')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nominee_name">Nominee Name:</label>
                                    <input type="text" name="nominee_name"
                                        class="form-control @error('nominee_name') is-invalid @enderror"
                                        value="{{ old('nominee_name') }}" placeholder="Enter Nominee Name">
                                    @error('nominee_name')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>

                              
                                <div class="form-group">
                                    <label for="dob">Date of Birth:</label>
                                    <input type="date" name="dob"
                                        class="form-control @error('dob') is-invalid @enderror"
                                        value="{{ old('dob') }}" placeholder="Enter Date of Birth" required>
                                    @error('dob')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="date_of_joining">Date of Joining:</label>
                                    <input type="date" name="date_of_joining"
                                        class="form-control @error('date_of_joining') is-invalid @enderror"
                                        value="{{ old('date_of_joining') }}" placeholder="Enter Date of Joining" required>
                                    @error('date_of_joining')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="mobile_no">Mobile Number:</label>
                                    <input type="text" name="mobile_no" id="mobile"
                                        class="form-control @error('mobile_no') is-invalid @enderror"
                                        value="{{ old('mobile_no') }}" placeholder="Enter Mobile Number">
                                    @error('mobile_no')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="p_address">Permanent Address:</label>
                                    <textarea name="p_address" class="form-control @error('p_address') is-invalid @enderror" rows="3"
                                        placeholder="Enter Permanent Address" required>{{ old('p_address') }}</textarea>
                                    @error('p_address')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="c_address">Current Address:</label>
                                    <textarea name="c_address" class="form-control @error('c_address') is-invalid @enderror" rows="3"
                                        placeholder="Enter Alternate Address" required>{{ old('c_address') }}</textarea>
                                    @error('c_address')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="total_experience">Total Experience:</label>
                                    <input type="text" name="total_experience"
                                        class="form-control @error('total_experience') is-invalid @enderror"
                                        value="{{ old('total_experience') }}" placeholder="Enter Total Experience">
                                    @error('total_experience')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="qualification">Qualification:</label>
                                    <input type="text" name="qualification"
                                        class="form-control @error('qualification') is-invalid @enderror"
                                        value="{{ old('qualification') }}" placeholder="Enter Qualification">
                                    @error('qualification')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="designation">Designation:</label>
                                    <input type="text" name="designation"
                                        class="form-control @error('designation') is-invalid @enderror"
                                        value="{{ old('designation') }}" placeholder="Enter Designation" required>
                                    @error('designation')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="expertise">Expertise:</label>
                                    <input type="text" name="expertise"
                                        class="form-control @error('expertise') is-invalid @enderror"
                                        value="{{ old('expertise') }}" placeholder="Enter Expertise" required>
                                    @error('expertise')
                                        <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="salary">Salary:</label>
                                    <input type="number" step="0.01" name="salary"
                                        class="form-control @error('salary') is-invalid @enderror"
                                        value="{{ old('salary') }}" placeholder="Enter Salary">
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
                                            onchange="get_shift_wise_site(this)">
                                            <option value="">Select Client</option>
                                            @foreach ($clients as $shift)
                                                <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                            @endforeach
                                        </select>
    
                                        @error('client_id')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="shift_id">Select Shift:</label>
                                        <select name="shift_id" id="shift_id"
                                            class="form-control @error('shift_id') is-invalid @enderror" required>
                                            <option value="">Select Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}">{{ $shift->name }}
                                                    ({{ $shift->start_time->format('H:i') }} -
                                                    {{ $shift->end_time->format('H:i') }})</option>
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
                                        </select>
                                        @error('site_id')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="area_id">Select Area:</label>
                                     
    
                                            <select name="area_id" id="area_id"
                                            class="form-control @error('area_id') is-invalid @enderror" >
                                            <option value="">Select Area</option>
                                        </select>
                                        @error('area_id')
                                            <div class="invalid-feedback" style="display: block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            
                               
                                <div class="form-group">
                                    <label for="family_detail">Family Details:</label>
                                    <div id="family-details-container">
                                        <div class="family-detail-entry card card-body">
                                            <input type="text" name="family_detail[0][name]"
                                                class="form-control mb-2 @error('family_detail.0.name') is-invalid @enderror"
                                                placeholder="Enter Name" value="{{ old('family_detail.0.name') }}"
                                                required>
                                            @error('family_detail.0.name')
                                                <div class="invalid-feedback" style="display: block">{{ $message }}
                                                </div>
                                            @enderror

                                            <input type="date" name="family_detail[0][dob]"
                                                class="form-control mb-2 @error('family_detail.0.dob') is-invalid @enderror"
                                                value="{{ old('family_detail.0.dob') }}" required>
                                            @error('family_detail.0.dob')
                                                <div class="invalid-feedback" style="display: block">{{ $message }}
                                                </div>
                                            @enderror

                                            <input type="text" name="family_detail[0][age]"
                                                class="form-control mb-2 @error('family_detail.0.age') is-invalid @enderror"
                                                placeholder="Enter Age" value="{{ old('family_detail.0.age') }}"
                                                required>
                                            @error('family_detail.0.age')
                                                <div class="invalid-feedback" style="display: block">{{ $message }}
                                                </div>
                                            @enderror

                                            <input type="text" name="family_detail[0][sex]"
                                                class="form-control mb-2 @error('family_detail.0.sex') is-invalid @enderror"
                                                placeholder="Enter Sex" value="{{ old('family_detail.0.sex') }}"
                                                required>
                                            @error('family_detail.0.sex')
                                                <div class="invalid-feedback" style="display: block">{{ $message }}
                                                </div>
                                            @enderror

                                            <input type="text" name="family_detail[0][relationship]"
                                                class="form-control mb-2 @error('family_detail.0.relationship') is-invalid @enderror"
                                                placeholder="Enter Relationship"
                                                value="{{ old('family_detail.0.relationship') }}" required>
                                            @error('family_detail.0.relationship')
                                                <div class="invalid-feedback" style="display: block">{{ $message }}
                                                </div>
                                            @enderror

                                            {{-- <button type="button" class="btn btn-danger remove-family-detail">Remove</button> --}}
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary mt-2" id="add-family-detail">Add More
                                        Family Member</button>
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
                                    {{-- <input type="checkbox" name="registration_status"
                                        class="form-control @error('registration_status') is-invalid @enderror"
                                        value="1" {{ old('registration_status') ? 'checked' : '' }}> --}}
                                        <div class="d-flex align-items-center gap-3">
                                            
                                            <div class="form-check form-check-success">
                                                <input class="form-check-input" type="radio" name="registration_status" value="1" id="flexCheckSuccess" {{ old('registration_status')==1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexCheckSuccess">
                                                 Completed
                                                </label>
                                              </div>
                                              <div class="form-check form-check-danger">
                                                <input class="form-check-input" type="radio" name="registration_status" value="0" id="flexCheckDanger" {{ old('registration_status')==0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexCheckDanger">
                                                 Panding
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
            <!--end row-->





        </div>
    </div>
@endsection
@push('script')
    <script>
        function get_shift_wise_site(e) {
            id = e.value;
          
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
            let familyDetailIndex = 1;

            document.getElementById('add-family-detail').addEventListener('click', function() {
                const container = document.getElementById('family-details-container');
                const newEntry = document.createElement('div');
                newEntry.className = 'family-detail-entry card card-body';

                newEntry.innerHTML = `
                <input type="text" name="family_detail[${familyDetailIndex}][name]" class="form-control mb-2" placeholder="Enter Name" required>
                <input type="date" name="family_detail[${familyDetailIndex}][dob]" class="form-control mb-2" required>
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
