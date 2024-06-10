@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User Profile</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
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
          
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{asset('assets/images/profile/'.$employee->profile)}}" alt="user profile"
                                            class="rounded-circle p-1 bg-primary" width="110">
                                        <div class="mt-3">
                                            <h4>{{ $employee->name }}</h4>
                                                <p class="text-muted font-size-sm">Employee code: {{ $employee->emp_code }}A</p>
                                            <p class="text-secondary mb-1">Designation: {{ $employee->designation }}</p>
                                        
                                            @if (ispermission('user management', 'update'))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{ route('usermanagement.edit', $employee->id) }}"
                                                        class="btn btn-outline-primary">Edit Profile</a>
                                                </div>
                                            </div>
                                            @endif
                                            {{-- <button class="btn btn-primary">Follow</button>
                                            <button class="btn btn-outline-primary">Message</button> --}}
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <ul class="list-group list-group-flush">
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Username</h6>
                                            <span class="text-secondary">{{ $employee->username }}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Email</h6>
                                            <span class="text-secondary">{{$employee->email}}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Mobile No.</h6>
                                            <span class="text-secondary">{{$employee->mobile_no}}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">City</h6>
                                            <span class="text-secondary">{{$employee->employeeDetail->city->name??''}}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">District</h6>
                                            <span class="text-secondary">{{$employee->employeeDetail->district->district_title??''}}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">State</h6>
                                            <span class="text-secondary">{{$employee->employeeDetail->state->state_title??''}}</span>
                                        </li>
                                 
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" value="John Doe" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" value="john@example.com" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" value="(239) 816-9029" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Mobile</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" value="(320) 380-4539" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control"
                                                value="Bay Area, San Francisco, CA" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="button" class="btn btn-primary px-4" value="Save Changes" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        
                           
                        </div> --}}
                        <div class="col-lg-8">
                     
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="d-flex align-items-center mb-3">Documents</h5>
                                         
                                            <div class="card-body">
                                                <h5 class="card-title">aadhar_card</h5>
                                                <p><a href="{{ asset('assets/images/' . $employee->employeeDetail->aadhar_card) }}" target="_blank">View Document</a></p>
                                                <p>Status: {{ $employee->employeeDetail->aadhar_card_status }}</p>
                                                <button class="btn btn-success approve-document" data-document="aadhar_card_status" data-id="{{ $employee->employeeDetail->employee_id }}">Approve</button>
                                                <button class="btn btn-danger reject-document" data-document="aadhar_card_status" data-id="{{ $employee->employeeDetail->employee_id }}">Reject</button>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">', pan_card</h5>
                                                <p><a href="{{ asset('assets/images/' . $employee->employeeDetail->pan_card) }}" target="_blank">View Document</a></p>
                                                <p>Status: {{ $employee->employeeDetail->pan_card_status}}</p>
                                                <button class="btn btn-success approve-document" data-document="pan_card_status" data-id="{{ $employee->employeeDetail->employee_id }}">Approve</button>
                                                <button class="btn btn-danger reject-document" data-document="pan_card_status" data-id="{{ $employee->employeeDetail->employee_id }}">Reject</button>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">passbook</h5>
                                                <p><a href="{{ asset('assets/images/' . $employee->employeeDetail->passbook) }}" target="_blank">View Document</a></p>
                                                <p>Status: {{ $employee->employeeDetail->passbook_status }}</p>
                                                <button class="btn btn-success approve-document" data-document="passbook_status" data-id="{{ $employee->employeeDetail->employee_id }}">Approve</button>
                                                <button class="btn btn-danger reject-document" data-document="passbook_status" data-id="{{ $employee->employeeDetail->employee_id }}">Reject</button>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">police_verification</h5>
                                                <p><a href="{{ asset('assets/images/' . $employee->employeeDetail->police_verification) }}" target="_blank">View Document</a></p>
                                                <p>Status: {{ $employee->employeeDetail->police_verification_status  }}</p>
                                                <button class="btn btn-success approve-document" data-document="police_verification_status" data-id="{{ $employee->employeeDetail->employee_id }}">Approve</button>
                                                <button class="btn btn-danger reject-document" data-document="police_verification_status" data-id="{{ $employee->employeeDetail->employee_id }}">Reject</button>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">medical</h5>
                                                <p><a href="{{ asset('assets/images/' . $employee->employeeDetail->medical) }}" target="_blank">View Document</a></p>
                                                <p>Status: {{ $employee->employeeDetail->medical_status }}</p>
                                                <button class="btn btn-success approve-document" data-document="medical_status" data-id="{{ $employee->employeeDetail->employee_id }}">Approve</button>
                                                <button class="btn btn-danger reject-document" data-document="medical_status" data-id="{{ $employee->employeeDetail->employee_id }}">Reject</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('assets/backend/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: true,
                // "order": [[0, 'desc']],
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });

        $(document).ready(function() {
    $('.approve-document, .reject-document').click(function() {
        const button = $(this);
        const action = button.hasClass('approve-document') ? 'approve' : 'reject';
        const document = button.data('document');
        const id = button.data('id');

        Swal.fire({
            title: `Are you sure you want to ${action} this document?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: `Yes, ${action} it!`,
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/employee-documents/${action}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        document: document,
                        id: id
                    },
                    success: function(response) {
                        Swal.fire(
                            'Success!',
                            `The document has been ${action}d.`,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(response) {
                        Swal.fire(
                            'Error!',
                            'There was an error processing your request.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
    </script>
@endpush
