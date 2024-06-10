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
                                        <img src="{{asset('assets/images/profile/'.$user->profile)}}" alt="user profile"
                                            class="rounded-circle p-1 bg-primary" width="110">
                                        <div class="mt-3">
                                            <h4>{{ $user->name }}</h4>
                                            <p class="text-secondary mb-1">Role: {{ $user->role->name }}</p>
                                            {{-- <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p> --}}
                                            @if (ispermission('user management', 'update'))
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{ route('usermanagement.edit', $user->id) }}"
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
                                            <span class="text-secondary">{{ $user->username }}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Email</h6>
                                            <span class="text-secondary">{{$user->email}}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Mobile No.</h6>
                                            <span class="text-secondary">{{$user->userDetail->mobile_no}}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">City</h6>
                                            <span class="text-secondary">{{$user->userDetail->city->name}}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">District</h6>
                                            <span class="text-secondary">{{$user->userDetail->district->district_title}}</span>
                                        </li>
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">State</h6>
                                            <span class="text-secondary">{{$user->userDetail->state->state_title}}</span>
                                        </li>
                                 
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            {{-- <div class="card">
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
                            </div> --}}

                            @if($user->role->role_type==2)
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="d-flex align-items-center mb-3">No. of {{$user->role->childRole->name??''}} Under :{{$user->name}}</h5>
                                            <div class="table-responsive">
                                                <table class="table mb-0" id="example2">
                                                    <thead class="table-light">
                                                        <tr>
                                                            {{-- <th>ID#</th> --}}
                                                            <th>Name</th>
                                                      
                                                            <th>Role</th>
                                                            <th>Username</th>
                                                           
                                                            <th>Email</th>
                                                            <th>Contact No.</th>
                                                            
                                                            <th>City</th>
                                                            <th>State</th>
                                                            <th>Profile</th>
                        
                                                         
                                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($user->relatedUsers as $value)
                                                            <tr>
                                                                {{-- <td>
                                                                    <div class="d-flex align-items-center">
                                                              
                                                                        <div class="ms-2">
                                                                            <h6 class="mb-0 font-14">{{ $count++ }}</h6>
                                                                        </div>
                                                                    </div>
                                                                </td> --}}
                                                                <td>{{ $value->name }}</td>
                        
                        
                                                              
                                                                <td>{{ $value->role->name ??''}}</td>
                                                               
                                                                <td>{{ $value->username }}</td>
                                                                <td>{{ $value->email }}</td>
                                                                <td>{{ $value->userDetail->mobile_no??'' }}</td>
                                                                
                                                                <td>{{ $value->userDetail->city->name ?? '' }}</td>
                                                                <td>{{ $value->userDetail->state->state_title??'' }}</td>
                                                                <td><a href="{{route('usermanagement.show',$value->id)}}" class="btn btn-primary btn-sm radius-30 px-4">View</a></td>
                                                           
            
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                       
                                       
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                           
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
    </script>
@endpush
