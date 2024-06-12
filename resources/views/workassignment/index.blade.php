@extends('layouts.app')

@push('style')
    <link href="{{ asset('assets/backend/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Work Assignment</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Client List</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            @if (\Session::has('success'))

                @include('includes.partial.success_alert')

            @endif
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        {{-- @if (ispermission('client management', 'create'))
                            <div class="ms-auto"><a href="{{ route('clients.create') }}"
                                    class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>New
                                    User</a></div>
                        @endif --}}

                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="example2">
                            <thead class="table-light">
                                <tr>
                                    <th>ID#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact No.</th>
                                    <th>Project Manager</th>
                                    <th>Total Shift</th>
                                    <th>Total Site</th>
                                    <th>Total Area</th>
                                    
                                    <th>Total Site Incharge</th>
                                    <th>Total Supervisor</th>
                                    @if (ispermission('work assignment', 'update')) 
                                    <th>Action</th>
                                    @endif
                                 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{-- <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div> --}}
                                                <div class="ms-2">
                                                    <h6 class="mb-0 font-14">{{ $count++ }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $client->name }} </td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->detail->mobile_no }}</td>
                                        <td>{{ $client->projectManager->name??'Not Assign' }}</td>
                                        {{-- <td>{{ $client->shifts_count }}</td>
                                        <td>{{ $client->sites_count }}</td> --}}
                                        <td>
                                        @foreach ($client->shifts as $shifts )
                                        
                                        <span class="badge rounded-pill bg-success"> {{$shifts->name}}</span>
                                        <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($client->shifts as $shifts )
                                        {{$shifts->sites->unique('id')->count()}}
                                       
                                        <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($client->shifts as $shifts )

                                        {{$shifts->areas->unique('id')->count()}}
                                       
                                        <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($client->shifts as $shifts )

                                        {{$shifts->users->where('role_id', 2)->unique('id')->count()}}
                                        
                                        <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($client->shifts as $shifts )

                                        {{$shifts->users->where('role_id', 3)->unique('id')->count()}}
                                        
                                        <br>
                                        @endforeach
                                    </td>
                                        {{-- @dd($client->shifts[0]->sites->unique('id')[0]->areas) --}}
                                        @if (ispermission('work assignment', 'update')) 
                                        <td>
                                            <a class="btn btn-inverse-primary" href="{{route('workassignment.show',$client->id)}}">Manage</a>
                                        </td>
                                         @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                // buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
