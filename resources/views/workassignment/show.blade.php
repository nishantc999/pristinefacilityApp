@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Manage Work</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Assignment</li>
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
            @if (\Session::has('success'))
                @include('includes.partial.success_alert')
            @endif
            <!--start stepper one-->


            <div id="stepper1" class="bs-stepper">

                <!--end stepper one-->


                <!--start stepper two-->
                <h6 class="text-uppercase">Client : {{$client->name}}</h6>
                <hr>
                <div id="stepper2" class="bs-stepper">
                    <div class="card">

                        <div class="card-header">
                            <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between"
                                role="tablist">
                                <div class="step" data-target="#test-nl-1">
                                    <div class="step-trigger" role="tab" id="stepper2trigger1"
                                        aria-controls="test-nl-1">
                                        <div class="bs-stepper-circle"><i class='bx bx-user fs-4'></i></div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">Project Manager</h5>
                                            {{-- <p class="mb-0 steper-sub-title">Enter Your Details</p> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-stepper-line"></div>
                                <div class="step" data-target="#test-nl-2">
                                    <div class="step-trigger" role="tab" id="stepper2trigger2"
                                        aria-controls="test-nl-2">
                                        <div class="bs-stepper-circle"><i class='bx bx-file fs-4'></i></div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">Site Incharge</h5>
                                            {{-- <p class="mb-0 steper-sub-title">Setup Account Details</p> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-stepper-line"></div>
                                <div class="step" data-target="#test-nl-3">
                                    <div class="step-trigger" role="tab" id="stepper2trigger3"
                                        aria-controls="test-nl-3">
                                        <div class="bs-stepper-circle"><i class='bx bxs-graduation fs-4'></i></div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">Supervisor</h5>
                                            {{-- <p class="mb-0 steper-sub-title">Education Details</p> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="bs-stepper-line"></div>
                                <div class="step" data-target="#test-nl-4">
                                    <div class="step-trigger" role="tab" id="stepper2trigger4"
                                        aria-controls="test-nl-4">
                                        <div class="bs-stepper-circle"><i class='bx bx-briefcase fs-4'></i></div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">Employee</h5>
                                            {{-- <p class="mb-0 steper-sub-title">Experience Details</p> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="bs-stepper-content">

                                <div id="test-nl-1" role="tabpanel" class="bs-stepper-pane"
                                    aria-labelledby="stepper2trigger1">
                                    <h5 class="mb-1">Project Manager Information</h5>
                                    <p class="mb-4"><strong>Project Manager Name:</strong>
                                        {{ $client->projectManager->name ?? 'Not Assign' }}
                                        @if (isset($client->projectManager->name))
                                            , Username: {{ $client->projectManager->username }}
                                        @endif

                                    </p>



                                    @if (isset($client->projectManager->name))
                                        <p>

                                        <form action="{{ route('client.removeProjectManager', $client->id) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Remove Project Manager</button>
                                        </form>
                                        </p>
                                    @else
                                        <form action="{{ route('client.addProjectManager', $client->id) }}" method="POST">

                                            @csrf


                                            {{-- <select name="user_id" id="user_id" class="form-select" required>
                                            <option value="">Select Project manager</option>
                                            @foreach (App\Models\User::where('role_id', 1)->where('occupied', 0)->orderBy('name')->get() as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select> --}}
                                            <div class="table-responsive">
                                                <table class="table mb-0" id="example2">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Select</th>

                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Username</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach (App\Models\User::where('role_id', 1)->where('occupied', 0)->orderBy('name')->get() as $user)
                                                            <tr>
                                                                <td>
                                                                    <div>
                                                                        <input class="form-check-input me-3" type="radio"
                                                                            name="user_id" value="{{ $user->id }}"
                                                                            aria-label="...">
                                                                    </div>
                                                                    {{-- <input type="radio" name="user_id"
                                                                        value="{{ $user->id }}"> --}}
                                                                </td>

                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->email }}</td>
                                                                <td>{{ $user->username }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>


                                            <button type="submit" class="btn btn-success">Add Project Manager</button>

                                        </form>
                                    @endif
                                    <form onSubmit="return false">
                                        {{-- <div class="row g-3">
                                            <div class="col-12 col-lg-6">
                                                <label for="FisrtName" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="FisrtName"
                                                    placeholder="First Name">
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="LastName" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="LastName"
                                                    placeholder="Last Name">
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="PhoneNumber" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" id="PhoneNumber"
                                                    placeholder="Phone Number">
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="InputEmail" class="form-label">E-mail Address</label>
                                                <input type="text" class="form-control" id="InputEmail"
                                                    placeholder="Enter Email Address">
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="InputCountry" class="form-label">Country</label>
                                                <select class="form-select" id="InputCountry"
                                                    aria-label="Default select example">
                                                    <option selected>---</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="InputLanguage" class="form-label">Language</label>
                                                <select class="form-select" id="InputLanguage"
                                                    aria-label="Default select example">
                                                    <option selected>---</option>
                                                    <option value="1">One</option>
                                                    <option value="2">Two</option>
                                                    <option value="3">Three</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <button class="btn btn-primary px-4" onclick="stepper2.next()">Next<i
                                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                                            </div>
                                        </div> --}}

                                        <!---end row-->

                                </div>

                                <div id="test-nl-2" role="tabpanel" class="bs-stepper-pane"
                                    aria-labelledby="stepper2trigger2">

                                    <h5 class="mb-1">Site Incharge</h5>
                                    {{-- <p class="mb-4">Enter Your Account Details.</p> --}}
{{-- for site incharge --}}

                                    @if ($client->shifts->isNotEmpty())
                                        <form id="shiftForm">
                                            @csrf

                                            <h6>Select Shift:</h6>

                                            <div class="card">
                                                <div class="card-body">

                                                    <div class="d-flex align-items-center gap-3">
                                                        @foreach ($client->shifts as $shift)
                                                            <div class="form-check form-check-success">
                                                                <input class="form-check-input shiftOption" type="radio"
                                                                    name="shift_id" value="{{ $shift->id }}"
                                                                    id="flexRadioSuccess{{ $shift->id }}">
                                                                <label class="form-check-label"
                                                                    for="flexRadioSuccess{{ $shift->id }}">
                                                                    {{ $shift->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>




                                            {{-- <ul>
                                                @foreach ($client->shifts as $shift)
                                                    <li>
                                                        <input type="radio" name="shift_id" value="{{ $shift->id }}" class="shiftOption">
                                                        {{ $shift->name }}
                                                    </li>
                                                @endforeach
                                            </ul> --}}
                                            <div id="siteSelection">
                                                <!-- Sites will be loaded here -->
                                            </div>
                                        </form>
                                    @endif

                                 
                                    <div id="assignedUserSelection" style="display: none;">
                                        <h5>Assigned Site Incharges:</h5>
                                        <form id="assignedUserForm">
                                            @csrf
                                            <div class="table-responsive">
                                            <table id="assignedUserTable" class="table table-striped table-bordered w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Select</th>

                                                        <th>Name</th>
                                                        <th>User Name</th>
                                                        <th>Email</th>

                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="assignedUserTableBody">
                                                    <!-- Assigned users will be loaded here -->
                                                </tbody>
                                            </table>
                                            </div>
                                            <button type="button" id="removeUsers" class="btn btn-danger">Remove
                                                Selected SI</button>
                                        </form>
                                        <div id="noAssignedUsersMessage" style="display: none;">
                                            <p>No assigned site incharges.</p>
                                        </div>
                                    </div>

                                    <div id="userSelection" style="display: none;">
                                        <h5>Add Site Incharge in Seleted site and shift:</h5>
                                        <form id="userForm">
                                            @csrf
                                            <div class="table-responsive">
                                            <table class="table table-striped table-bordered w-100" id="userTable">
                                                <thead>
                                                    <tr>
                                                        <th>Select</th>
                                                        <th>Name</th>
                                                        <th>User Name</th>
                                                        <th>Email</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="userTableBody">
                                                    <!-- Users will be loaded here -->
                                                </tbody>
                                            </table>
                                            </div>
                                            <button type="button" class="btn btn-success" id="addUser">Add</button>
                                        </form>
                                    </div>

                                    {{-- <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <label for="InputUsername" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="InputUsername"
                                                placeholder="jhon@123">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label for="InputEmail2" class="form-label">E-mail Address</label>
                                            <input type="text" class="form-control" id="InputEmail2"
                                                placeholder="example@xyz.com">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label for="InputPassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="InputPassword"
                                                value="12345678">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label for="InputConfirmPassword" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="InputConfirmPassword"
                                                value="12345678">
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center gap-3">
                                                <button class="btn btn-outline-secondary px-4"
                                                    onclick="stepper2.previous()"><i
                                                        class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                                <button class="btn btn-primary px-4" onclick="stepper2.next()">Next<i
                                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                                            </div>
                                        </div>
                                    </div> --}}

                                </div>
{{-- for supervisior --}}
                                <div id="test-nl-3" role="tabpanel" class="bs-stepper-pane"
                                    aria-labelledby="stepper2trigger3">
                                    <h5 class="mb-1">Supervisor</h5>
                                    {{-- <p class="mb-4">Inform companies about your education life</p> --}}

                                    @if ($client->shifts->isNotEmpty())
                                        <form id="shiftFormsupervisor">
                                            @csrf

                                            <h6>Select Shift:</h6>

                                            <div class="card">
                                                <div class="card-body">

                                                    <div class="d-flex align-items-center gap-3">
                                                        @foreach ($client->shifts as $shift)
                                                            <div class="form-check form-check-success">
                                                                <input class="form-check-input shiftOptionsupervisor" type="radio"
                                                                    name="shift_id" value="{{ $shift->id }}"
                                                                    id="flexRadioSuccess{{ $shift->id }}">
                                                                <label class="form-check-label"
                                                                    for="flexRadioSuccess{{ $shift->id }}">
                                                                    {{ $shift->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="siteSelectionsupervisor">
                                                <!-- Sites will be loaded here -->
                                            </div>
                                        </form>
                                    @endif
                                  

                                    <div id="assignedUserSelectionsupervisor" style="display: none;">
                                        <h5>Assigned Supervisor:</h5>
                                        <form id="assignedUserFormsupervisor">
                                            @csrf
                                            <div class="table-responsive">
                                            <table id="assignedUserTablesupervisor" class="table table-striped table-bordered w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Select</th>

                                                        <th>Name</th>
                                                        <th>User Name</th>
                                                        <th>Email</th>

                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="assignedUserTableBodysupervisor">
                                                    <!-- Assigned users will be loaded here -->
                                                </tbody>
                                            </table>
                                            </div>
                                            <button type="button" id="removeUserssupervisor" class="btn btn-danger">Remove
                                                Supervisor</button>
                                        </form>
                                        <div id="noAssignedUsersMessagesupervisor" style="display: none;">
                                            <p>No assigned supervisor.</p>
                                        </div>
                                    </div>

                                    <div id="userSelectionsupervisor" style="display: none;">
                                        <h5>Add Supervisor in Seleted site and shift:</h5>
                                        <form id="userFormsupervisor">
                                            @csrf
                                            <div class="table-responsive">
                                            <table class="table table-striped table-bordered w-100" id="avaliableSupervisiorTable">
                                                <thead>
                                                    <tr>
                                                        <th>Select</th>
                                                        <th>Name</th>
                                                        <th>User Name</th>
                                                        <th>Email</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="userTableBodysupervisor">
                                                    <!-- Users will be loaded here -->
                                                </tbody>
                                            </table>
                                            </div>
                                            <button type="button" class="btn btn-success" id="addUsersupervisor">Add</button>
                                        </form>
                                    </div>
                                    {{-- <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <label for="SchoolName" class="form-label">School Name</label>
                                            <input type="text" class="form-control" id="SchoolName"
                                                placeholder="School Name">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label for="BoardName" class="form-label">Board Name</label>
                                            <input type="text" class="form-control" id="BoardName"
                                                placeholder="Board Name">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label for="UniversityName" class="form-label">University Name</label>
                                            <input type="text" class="form-control" id="UniversityName"
                                                placeholder="University Name">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label for="InputCountry" class="form-label">Course Name</label>
                                            <select class="form-select" id="InputCountry"
                                                aria-label="Default select example">
                                                <option selected>---</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center gap-3">
                                                <button class="btn btn-outline-secondary px-4"
                                                    onclick="stepper2.previous()"><i
                                                        class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                                <button class="btn btn-primary px-4" onclick="stepper2.next()">Next<i
                                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                                            </div>
                                        </div>
                                    </div><!---end row--> --}}

                                </div>

                                <div id="test-nl-4" role="tabpanel" class="bs-stepper-pane"
                                    aria-labelledby="stepper2trigger4">
                                    <h5 class="mb-1">Employee</h5>
                                    {{-- <p class="mb-4">Inform companies about your education life</p> --}}

                                    @if ($client->shifts->isNotEmpty())
                                        <form id="shiftFormemployee">
                                            @csrf

                                            <h6>Select Shift:</h6>

                                            <div class="card">
                                                <div class="card-body">

                                                    <div class="d-flex align-items-center gap-3">
                                                        @foreach ($client->shifts as $shift)
                                                            <div class="form-check form-check-success">
                                                                <input class="form-check-input shiftOptionemployee" type="radio"
                                                                    name="shift_id" value="{{ $shift->id }}"
                                                                    id="flexRadioSuccess{{ $shift->id }}">
                                                                <label class="form-check-label"
                                                                    for="flexRadioSuccess{{ $shift->id }}">
                                                                    {{ $shift->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="siteSelectionemployee">
                                                <!-- Sites will be loaded here -->
                                            </div>
                                        </form>

                                        {{-- <div id="areaSelection" style="display: none;">
                                          
                                            <form id="areaForm">
                                                @csrf
                                                <div id="areaList">
                                                    <!-- Areas will be dynamically loaded here -->
                                                </div>
                                            </form>
                                        </div> --}}
                                        <div id="supervisorSelection" style="display: none;">
                                        
                                            <form id="supervisorForm">
                                                @csrf
                                                <div id="supervisorList">
                                                    <!-- Supervisors will be dynamically loaded here -->
                                                </div>
                                            </form>
                                        </div>
                                        <div id="assignedEmployees" style="display: none;">
                                            <h5>Assigned Employees:</h5>
                                            <form id="assignedEmployeesForm">
                                                @csrf
                                                <div class="table-responsive">
                                                <table class="table table-striped table-bordered w-100" id="assignedEmployeesTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Select</th>
                                                            <th>Employee Code</th>
                                                            <th>Employee Name</th>
                                                            <th>Email</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="assignedEmployeesBody">
                                                        <!-- Assigned employees will be dynamically loaded here -->
                                                    </tbody>
                                                </table>
                                                </div>
                                                <button type="button" id="removeSelectedEmployees" class="btn btn-danger">Remove Selected Employees</button>
                                            </form>
                                        </div>
                                
                                        <!-- Available Employees Table -->
                                        <div id="availableEmployees" style="display: none;">
                                            <h5>Add Employees in Seleted site, shift and Supervisior :</h5>
                                            <form id="availableEmployeesForm">
                                                @csrf
                                                <div class="table-responsive">
                                                <table class="table table-striped table-bordered w-100" id="availableEmployeesTable" >
                                                    <thead>
                                                        <tr>
                                                            <th>Select</th>
                                                            <th>Employee Code</th>
                                                            <th>Employee Name</th>
                                                            <th>Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="availableEmployeesBody">
                                                        <!-- Available employees will be dynamically loaded here -->
                                                    </tbody>
                                                </table>
                                                </div>
                                                <button type="button" id="addSelectedEmployees" class="btn btn-success">Add Employees</button>
                                            </form>
                                        </div>
                                
                                        <div id="noAssignedEmployeesMessage" style="display: none;">
                                            <p>No assigned employees.</p>
                                        </div>
                                        @endif
                                    {{-- <div class="row g-3">
                                      
                                        <div class="col-12">
                                            <div class="d-flex align-items-center gap-3">
                                                <button class="btn btn-primary px-4" onclick="stepper2.previous()"><i
                                                        class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                                <button class="btn btn-success px-4"
                                                    onclick="stepper2.next()">Submit</button>
                                            </div>
                                        </div>
                                    </div> --}}

                                </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!--end stepper two-->



                <!--end stepper three-->


            </div>
        </div>


    @endsection

    @push('script')
        <script src="{{ asset('assets/backend/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table1 = $('#example2').DataTable({
                    lengthChange: true,
                    // "order": [[0, 'desc']],
                    // buttons: ['copy', 'excel', 'pdf', 'print'] 
                });

                table1.buttons().container()
                    .appendTo('#example2_wrapper .col-md-6:eq(0)');
            });

      
            var availableEmployeesTable = $('#availableEmployeesTable').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });
        availableEmployeesTable.buttons().container()
        .appendTo('#availableEmployeesTable_wrapper .col-md-6:eq(0)');

        var assignedEmployeesTable = $('#assignedEmployeesTable').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });
        assignedEmployeesTable.buttons().container()
        .appendTo('#assignedEmployeesTable_wrapper .col-md-6:eq(0)');
        var assignedUserTable = $('#assignedUserTable').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });
        assignedUserTable.buttons().container()
        .appendTo('#assignedEmployeesTable_wrapper .col-md-6:eq(0)');
        var userTable = $('#userTable').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });
        userTable.buttons().container()
        .appendTo('#userTable_wrapper .col-md-6:eq(0)');
        var assignedUserTablesupervisor = $('#assignedUserTablesupervisor').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });
        assignedUserTablesupervisor.buttons().container()
        .appendTo('#assignedUserTablesupervisor_wrapper .col-md-6:eq(0)');
        var avaliableSupervisiorTable = $('#avaliableSupervisiorTable').DataTable({
            responsive: true,
            paging: true,
            searching: true
        });
        avaliableSupervisiorTable.buttons().container()
        .appendTo('#avaliableSupervisiorTable_wrapper .col-md-6:eq(0)');
        </script>
        <script>
            $(document).ready(function() {
                $('.shiftOption').change(function() {
                    var shiftId = $(this).val();
                    $.ajax({
                        type: 'GET',
                        url: '/client/{{ $client->id }}/shift/' + shiftId + '/sites',
                        success: function(response) {
                            var sites = response.sites;
                            // var siteSelectionHTML = '<h2>Select Site:</h2><ul>';
                            var siteSelectionHTML =
                                '<h6>Select Site:</h6><div class="card"><div class="card-body"><div class="d-flex align-items-center gap-3">';
                            $.each(sites, function(index, site) {
                                // siteSelectionHTML += '<li><input type="radio" name="site_id" value="' + site.id + '">' + site.name + '</li>';
                                siteSelectionHTML +=
                                    '<div class="form-check form-check-success"><input class="form-check-input" type="radio" name="site_id" value="' +
                                    site.id + '"><label class="form-check-label">' + site
                                    .name + '</label></div>';
                            });
                            // $.each(sites, function(index, site){
                            //     siteSelectionHTML += '<li><input type="radio" name="site_id" value="' + site.id + '">' + site.name + '</li>';
                            // });
                            siteSelectionHTML += '</div></div></div>';
                            // siteSelectionHTML += '</ul>';
                            $('#siteSelection').html(siteSelectionHTML);
                            $('#userSelection')
                        .hide(); // Hide user selection table when shift changes
                            $('#assignedUserSelection').hide();
                            $('#noAssignedUsersMessage').hide();
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });



                $('#siteSelection').on('change', 'input[type=radio][name=site_id]', function() {
                    var siteId = $(this).val();
                    var shiftId = $('input[name="shift_id"]:checked').val();
                    $('#noAssignedUsersMessage').hide();
                    $('#userSelection').show();
                    
                    $.ajax({
                        type: 'GET',
                        url: '/avaliable/si',
                        success: function(response) {
                            var users = response.users;
                         
                            // var userTableHTML = '';
                            // $.each(users, function(index, user) {
                            //     userTableHTML += '<tr>';
                            //     userTableHTML +=
                            //         '<td><input type="checkbox" name="user_id[]" value="' +
                            //         user.id + '"></td>';
                            //     userTableHTML += '<td>' + user.name + '</td>';
                            //     userTableHTML += '<td>' + user.username + '</td>';
                            //     userTableHTML += '<td>' + user.email + '</td>';

                            //     userTableHTML += '</tr>';
                            // });
                            // $('#userTableBody').html(userTableHTML);
                            // data table start
                            $('#userTableBody').empty();
                            userTable.clear();
                            $.each(users, function(index, user) {
                                userTable.row.add([
                            '<input type="checkbox" name="user_id[]" value="' + user.id + '">',
                            user.name,
                            user.username,
                            user.email
                        ]).draw(false);
                    });
                            // data table end
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });

                    $.ajax({
                        type: 'GET',
                        url: '/client/{{ $client->id }}/site/' + siteId + '/shift/' + shiftId +
                            '/assigned-users',
                        success: function(response) {
                            var assignedUsers = response.assignedUsers;
                            var assignedUserTableBody = $('#assignedUserTableBody');
                            assignedUserTableBody.empty();
                            assignedUserTable.clear(); // Clear existing table data
                            if (assignedUsers.length == 0) {
                                $('#noAssignedUsersMessage').show();
                                $('#assignedUserForm').hide();
                            }
                            // $.each(assignedUsers, function(index, user) {
                            //     assignedUserTableBody.append(
                            //         '<tr>' +
                            //         '<td><input type="checkbox" name="assigned_user_id[]" value="' +
                            //         user.id + '"></td>' +
                            //         '<td>' + user.name + '</td>' +
                            //         '<td>' + user.username + '</td>' +
                            //         '<td>' + user.email + '</td>' +
                            //         '<td><button type="button" class="btn btn-danger btn-sm removeUser" data-user-id="' +
                            //         user.id + '">Remove</button></td>' +
                            //         '</tr>'
                            //     );
                            // });
                            // start data table 
                            assignedUsers.forEach(function(user) {
                            assignedUserTable.row.add([
                                '<input type="checkbox" name="assigned_user_id[]" value="' + user.id + '">',
                                user.name,
                                user.username,
                                user.email,
                                '<button type="button" class="btn btn-danger btn-sm removeUser" data-user-id="' + user.id + '">Remove</button>'
                            ]).draw(false);
                        });
                            // start data table end 
                            if (assignedUsers.length > 0) {

                                $('#assignedUserForm').show();
                            }
                            $('#assignedUserSelection')
                        .show(); // Show assigned user table when both shift and site are selected
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                $('#addUser').click(function() {
                    var formData = $('#userForm').serialize();
                    var siteId = $('input[name="site_id"]:checked').val();
                    var shiftId = $('input[name="shift_id"]:checked').val();
                    var selectedUsers = $('input[name="user_id[]"]:checked');
                    if (selectedUsers.length === 0) {
                        alert('Please select users to add.');
                        return; // Stop execution if no user is selected
                    }
                    $.ajax({
                        type: 'POST',
                        url: '/client/{{ $client->id }}/site/' + siteId + '/shift/' + shiftId +
                            '/add-users',
                        data: formData,
                        success: function(response) {
                            // alert(response.message);
                            // You can handle success behavior here, like refreshing the page or showing a success message
                            $('#siteSelection input[type=radio][name=site_id]:checked').trigger(
                                'change');
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });



                $('#assignedUserTable').on('click', '.removeUser', function() {
                    var userId = $(this).data('user-id');
                    var siteId = $('input[name="site_id"]:checked').val();
                    var shiftId = $('input[name="shift_id"]:checked').val();

                    $.ajax({
                        type: 'POST',
                        url: '/client/{{ $client->id }}/site/' + siteId + '/shift/' + shiftId +
                            '/remove-user',
                        data: {
                            _token: '{{ csrf_token() }}',
                            user_id: userId
                        },
                        success: function(response) {
                            // alert(response.message);
                            // Reload assigned users after removing
                            $('#siteSelection input[type=radio][name=site_id]:checked').trigger(
                                'change');
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                $('#removeUsers').click(function() {
                    var formData = $('#assignedUserForm').serialize();
                    var siteId = $('input[name="site_id"]:checked').val();
                    var shiftId = $('input[name="shift_id"]:checked').val();
                    var selectedUsers = $('input[name="assigned_user_id[]"]:checked');
                    if (selectedUsers.length === 0) {
                        alert('Please select users to remove.');
                        return; // Stop execution if no user is selected
                    }
                    $.ajax({
                        type: 'POST',
                        url: '/client/{{ $client->id }}/site/' + siteId + '/shift/' + shiftId +
                            '/remove-users',
                        data: formData,
                        success: function(response) {
                            // alert(response.message);
                            // Reload assigned users after removing
                            $('#siteSelection input[type=radio][name=site_id]:checked').trigger(
                                'change');
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });


            });
        </script>
        <script>

            // for supervisior 
            $(document).ready(function() {
                $('.shiftOptionsupervisor').change(function() {
                    var shiftId = $(this).val();
                    $.ajax({
                        type: 'GET',
                        url: '/client/{{ $client->id }}/shift/' + shiftId + '/sites',
                        success: function(response) {
                            var sites = response.sites;
                            // var siteSelectionHTML = '<h2>Select Site:</h2><ul>';
                            var siteSelectionHTML =
                                '<h6>Select Site:</h6><div class="card"><div class="card-body"><div class="d-flex align-items-center gap-3">';
                            $.each(sites, function(index, site) {
                                // siteSelectionHTML += '<li><input type="radio" name="site_id" value="' + site.id + '">' + site.name + '</li>';
                                siteSelectionHTML +=
                                    '<div class="form-check form-check-success"><input class="form-check-input" type="radio" name="site_id" value="' +
                                    site.id + '"><label class="form-check-label">' + site
                                    .name + '</label></div>';
                            });
                            // $.each(sites, function(index, site){
                            //     siteSelectionHTML += '<li><input type="radio" name="site_id" value="' + site.id + '">' + site.name + '</li>';
                            // });
                            siteSelectionHTML += '</div></div></div>';
                            // siteSelectionHTML += '</ul>';
                            $('#siteSelectionsupervisor').html(siteSelectionHTML);
                            $('#userSelectionsupervisor')
                        .hide(); // Hide user selection table when shift changes
                            $('#assignedUserSelectionsupervisor').hide();
                            $('#noAssignedUsersMessagesupervisor').hide();
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });



                $('#siteSelectionsupervisor').on('change', 'input[type=radio][name=site_id]', function() {
                    var siteId = $(this).val();
                    var shiftId = $('#shiftFormsupervisor input[name="shift_id"]:checked').val();
                    $('#noAssignedUsersMessagesupervisor').hide();
                    $('#userSelectionsupervisor').show();
                   
                  
                    $.ajax({
                        type: 'GET',
                        url: '/avaliable/supervisior',
                        success: function(response) {
                            var users = response.users;
                            $('#userTableBodysupervisor').empty();
                            avaliableSupervisiorTable.clear();
                            var userTableHTML = '';
                            // $.each(users, function(index, user) {
                            //     userTableHTML += '<tr>';
                            //     userTableHTML +=
                            //         '<td><input type="checkbox" name="user_id[]" value="' +
                            //         user.id + '"></td>';
                            //     userTableHTML += '<td>' + user.name + '</td>';
                            //     userTableHTML += '<td>' + user.username + '</td>';
                            //     userTableHTML += '<td>' + user.email + '</td>';

                            //     userTableHTML += '</tr>';
                            // });
                            // $('#userTableBodysupervisor').html(userTableHTML);
                            $.each(users, function(index, user) {
                                avaliableSupervisiorTable.row.add([
                            '<input type="checkbox" name="user_id[]" value="' + user.id + '">',
                            user.name,
                            user.username,
                            user.email
                        ]).draw(false);
                    });
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });

                    $.ajax({
                        type: 'GET',
                        url: '/client/{{ $client->id }}/site/' + siteId + '/shift/' + shiftId +
                            '/assigned-supervisor',
                        success: function(response) {
                            var assignedUsers = response.assignedUsers;
                            var assignedUserTableBody = $('#assignedUserTableBodysupervisor');
                            assignedUserTableBody.empty(); // Clear existing table data
                            assignedUserTablesupervisor.clear(); // Clear existing table data
                            if (assignedUsers.length == 0) {
                                $('#noAssignedUsersMessagesupervisor').show();
                                $('#assignedUserFormsupervisor').hide();
                            }
                            // $.each(assignedUsers, function(index, user) {
                            //     assignedUserTableBody.append(
                            //         '<tr>' +
                            //         '<td><input type="checkbox" name="assigned_user_id[]" value="' +
                            //         user.id + '"></td>' +
                            //         '<td>' + user.name + '</td>' +
                            //         '<td>' + user.username + '</td>' +
                            //         '<td>' + user.email + '</td>' +
                            //         '<td><button type="button" class="btn btn-danger btn-sm removeUsersupervisor" data-user-id="' +
                            //         user.id + '">Remove</button></td>' +
                            //         '</tr>'
                            //     );
                            // });
                            $.each(assignedUsers, function(index, user) {
                                assignedUserTablesupervisor.row.add([
                                '<input type="checkbox" name="assigned_user_id[]" value="' + user.id + '">',
                                user.name,
                                user.username,
                                user.email,
                                '<button type="button" class="btn btn-danger btn-sm removeUsersupervisor" data-user-id="' + user.id + '">Remove</button>'
                            ]).draw(false);
                        });
                            if (assignedUsers.length > 0) {

                                $('#assignedUserFormsupervisor').show();
                            }
                            $('#assignedUserSelectionsupervisor')
                        .show(); // Show assigned user table when both shift and site are selected
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                $('#addUsersupervisor').click(function() {
                    var formData = $('#userFormsupervisor').serialize();
                    var siteId = $('#shiftFormsupervisor input[name="site_id"]:checked').val();
                    var shiftId = $('#shiftFormsupervisor input[name="shift_id"]:checked').val();
                    var selectedUsers = $('#userTableBodysupervisor input[name="user_id[]"]:checked');
                    if (selectedUsers.length === 0) {
                        alert('Please select users to add.');
                        return; // Stop execution if no user is selected
                    }
                    $.ajax({
                        type: 'POST',
                        url: '/client/{{ $client->id }}/site/' + siteId + '/shift/' + shiftId +
                            '/add-users',
                        data: formData,
                        success: function(response) {
                            // alert(response.message);
                            // You can handle success behavior here, like refreshing the page or showing a success message
                            $('#shiftFormsupervisor input[type=radio][name=site_id]:checked').trigger(
                                'change');
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });



                $('#assignedUserTablesupervisor').on('click', '.removeUsersupervisor', function() {
                    var userId = $(this).data('user-id');
                    var siteId = $('#shiftFormsupervisor input[name="site_id"]:checked').val();
                    var shiftId = $('#shiftFormsupervisor input[name="shift_id"]:checked').val();

                    $.ajax({
                        type: 'POST',
                        url: '/client/{{ $client->id }}/site/' + siteId + '/shift/' + shiftId +
                            '/remove-user',
                        data: {
                            _token: '{{ csrf_token() }}',
                            user_id: userId
                        },
                        success: function(response) {
                            // alert(response.message);
                            // Reload assigned users after removing
                            $('#shiftFormsupervisor input[type=radio][name=site_id]:checked').trigger(
                                'change');
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                $('#removeUserssupervisor').click(function() {
                    var formData = $('#assignedUserFormsupervisor').serialize();
                    var siteId = $('#shiftFormsupervisor input[name="site_id"]:checked').val();
                    var shiftId = $('#shiftFormsupervisor input[name="shift_id"]:checked').val();
                    var selectedUsers = $('#assignedUserTableBodysupervisor input[name="assigned_user_id[]"]:checked');
                    if (selectedUsers.length === 0) {
                        alert('Please select users to remove.');
                        return; // Stop execution if no user is selected
                    }
                    $.ajax({
                        type: 'POST',
                        url: '/client/{{ $client->id }}/site/' + siteId + '/shift/' + shiftId +
                            '/remove-users',
                        data: formData,
                        success: function(response) {
                            // alert(response.message);
                            // Reload assigned users after removing
                            $('#shiftFormsupervisor input[type=radio][name=site_id]:checked').trigger(
                                'change');
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });


            });


            // employee


// get site on change shift
            $(document).ready(function() {
                $('.shiftOptionemployee').change(function() {
                    var shiftId = $(this).val();
                   
                    $.ajax({
                        type: 'GET',
                        url: '/client/{{ $client->id }}/shift/' + shiftId + '/sites/blade',
                        success: function(response) {
                            $('#siteSelectionemployee').html(response);
                            // siteSelectionHTML += '</ul>';
                            // $('#siteSelectionsupervisor').html(siteSelectionHTML);
                       
                            $('#noAssignedEmployeesMessage').hide();
                           
                            $('#siteSelectionemployee').show();
                            $('#supervisorSelection').hide();
                        $('#assignedEmployees').hide();
                        $('#availableEmployees').hide();
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });

                
                });


// get supervisior on change site
             
                $('#shiftFormemployee').on('change', 'input[type="radio"][name="site_id"]', function() {
                var siteId = $(this).val();
                var shiftId = $('#shiftFormemployee input[name="shift_id"]:checked').val();
              
                var clientId = {{ $client->id }};
                $('#noAssignedUsersMessageemployeer').hide();
                $('#userSelectionemployee').hide();
                $.ajax({

                    url: '/get-supervisors/{{ $client->id }}/' + shiftId + '/' + siteId,
                    type: 'GET',
                    success: function(response) {
                        $('#supervisorList').empty();
                        // response.areas.forEach(function(area) {
                        //     $('#supervisorList').append(
                        //         '<li><input type="radio" class="areaOption" name="area_id" value="' + area.id + '"> ' + area.name + '</li>'
                        //     );
                        // });
                        $('#supervisorList').html(response);
                        $('#supervisorSelection').show();
                        $('#assignedEmployees').hide();
                        $('#availableEmployees').hide();
                    }
                });
            });
             
            $('#supervisorForm').on('change', 'input[type="radio"][name="supervisor_id"]', function() {
                
                var supervisorId = $(this).val();
                var clientId = {{ $client->id }};
                var shiftId = $('#shiftFormemployee input[name="shift_id"]:checked').val();
                var siteId = $('#shiftFormemployee input[name="site_id"]:checked').val();

                // Fetch assigned employees
                $.ajax({
                    url: '/get-assigned-employees/' + clientId + '/' + shiftId + '/' + siteId + '/' + supervisorId,
                    type: 'GET',
                    success: function(response) {
                        
                        $('#assignedEmployeesBody').empty();
                        assignedEmployeesTable.clear();
                        if (response.employees.length > 0) {
                            // response.employees.forEach(function(employee) {
                            //     $('#assignedEmployeesBody').append(
                            //         '<tr><td><input type="checkbox" name="employee_ids[]" value="' + employee.id + '"></td><td>' + employee.emp_code + '</td><td>' + employee.name + '</td><td>' + employee.email + '</td><td><button type="button" class="btn btn-danger removeEmployee" data-id="' + employee.id + '">Remove</button></td></tr>'
                            //     );
                            // });
                            
                            response.employees.forEach(function(employee) {
                                assignedEmployeesTable.row.add([
                                '<input type="checkbox" name="employee_ids[]" value="' + employee.id + '">',
                                employee.emp_code,
                                employee.name,
                                employee.email,
                                '<button type="button" class="btn btn-danger removeEmployee" data-id="' + employee.id + '">Remove</button>'
                            ]).draw(false);
                        });
                            $('#assignedEmployees').show();
                            $('#noAssignedEmployeesMessage').hide();
                        } else {
                            $('#assignedEmployees').hide();
                            $('#noAssignedEmployeesMessage').show();
                        }
                    }
                });


           
      
                // Fetch available employees
                $.ajax({
                    url: '/get-available-employees',
                    type: 'GET',
                    success: function(response) {
                        $('#availableEmployeesBody').empty();
                        // response.employees.forEach(function(employee) {
                        //     $('#availableEmployeesBody').append(
                        //         '<tr><td><input type="checkbox" name="available_employee_ids[]" value="' + employee.id + '"></td><td>' + employee.emp_code + '</td><td>' + employee.name + '</td><td>' + employee.email + '</td></tr>'
                        //     );
                        // });
                        $('#availableEmployees').show();
                        // data table 
           
    
                 availableEmployeesTable.clear();
                response.employees.forEach(function(employee) {
                        availableEmployeesTable.row.add([
                            '<input type="checkbox" name="available_employee_ids[]" value="' + employee.id + '">',
                            employee.emp_code,
                            employee.name,
                            employee.email
                        ]).draw(false);
                    });
                     // data table end
                    }
                });
            });

            // Add selected employees
            $('#addSelectedEmployees').click(function() {
                var supervisorId = $('input[name="supervisor_id"]:checked').val();
                var shiftId = $('#shiftFormemployee input[name="shift_id"]:checked').val();
                var siteId = $('#shiftFormemployee input[name="site_id"]:checked').val();
                var clientId = {{ $client->id }};
                var selectedEmployees = $('input[name="available_employee_ids[]"]:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedEmployees.length === 0) {
                    alert('Please select at least one employee to add.');
                    return;
                }

                $.ajax({
                    url: '/assign-employees',
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        supervisor_id: supervisorId,
                        employee_ids: selectedEmployees,
                        shiftId: shiftId,
                        siteId: siteId,
                        clientId: clientId,
                    },
                    success: function(response) {
                        if (response.success) {
                            // Refetch assigned employees
                            $('input[type="radio"][name="supervisor_id"]:checked').trigger('change');
                        }
                    }
                });
            });

            // Remove selected employees
            $('#removeSelectedEmployees').click(function() {
                var selectedEmployees = $('input[name="employee_ids[]"]:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedEmployees.length === 0) {
                    alert('Please select at least one employee to remove.');
                    return;
                }

                $.ajax({
                    url: '/remove-employees',
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        employee_ids: selectedEmployees
                    },
                    success: function(response) {
                        if (response.success) {
                            // Refetch assigned employees
                            $('input[type="radio"][name="supervisor_id"]:checked').trigger('change');
                        }
                    }
                });
            });

            // Remove individual employee
            $('#assignedEmployeesBody').on('click', '.removeEmployee', function() {
                var employeeId = $(this).data('id');

                $.ajax({
                    url: '/remove-employees',
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        employee_ids: [employeeId]
                    },
                    success: function(response) {
                        if (response.success) {
                            // Refetch assigned employees
                            $('input[type="radio"][name="supervisor_id"]:checked').trigger('change');
                        }
                    }
                });
            });



        });

        </script>
    @endpush
