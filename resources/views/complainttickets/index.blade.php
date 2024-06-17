@extends('layouts.app')

@push('style')
    <link href="{{ asset('assets/backend/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Complaint Tickets</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List</li>
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



            <!--filter-->






            <div class="card">
                <div class="card-body">
                    <form action="{{ route('complaint.index') }}" method="get" id="searchform22">

                        <div class="row m-auto justify-content-center my-3">

                            <div class="col-sm-12 col-md-4">


                                <label for="status" class="form-label">Choose Client</label>

                                <select name="client_id" id="client_id" class="form-select"
                                    data-placeholder="Choose Client">
                                  <option value="">All</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $client->id == $search_feild['client_id'] ? 'selected' : '' }}>
                                                {{ $client->name }}</option>
                                        @endforeach

                                </select>

                            </div>
                            {{-- 
                            <div class="col-sm-12 col-md-4">

                                <label for="status" class="form-label">Choose Any City</label>

                                <select name="city_id" id="city_id" class="form-select"
                                    data-placeholder="Choose Any City">

                                    <option value="">All</option>

                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ $search_feild['city_id'] == $city->id ? 'selected' : '' }}>
                                            {{ $city->city_name }}</option>
                                    @endforeach

                                </select>


                            </div>





                            <div class="col-sm-12 col-md-4">

                                <label for="status" class="form-label">Choose Warehouse</label>

                                <select name="warehouse_id" id="warehouse_id" class="form-select"
                                    onchange="searchformsubmit22()">


                                    <option value="">All</option>

                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}"
                                            {{ $search_feild['warehouse_id'] == $warehouse->id ? 'selected' : '' }}>
                                            {{ $warehouse->name }}</option>
                                    @endforeach

                                </select>


                            </div>
                            --}}
                        </div>
                    </form>
                </div>

            </div>




   
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        {{-- <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div> --}}
                        {{-- @if (ispermission('user management', 'create'))


                            <div class="ms-auto"><a href="{{ route('usermanagement.create') }}"
                                    class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>New
                                    User</a></div>
                        @endif --}}

                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="example2">
                            <thead class="table-light">
                                <tr>
                                    <th>ID#</th>
                                    {{-- <th>User Type</th> --}}
                                    {{-- <th>Employee ID</th> --}}
                                    {{-- <th>User ID</th> --}}
                                    <th>Client</th>
                                    <th>Complainer</th>
                                    {{-- <th>Closer ID</th> --}}
                                    <th>Shift</th>
                                    <th>Site</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $ticket)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                         
                                                <div class="ms-2">
                                                    <h6 class="mb-0 font-14">{{ $count++ }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                     
                                        {{-- <td>{{ $ticket->user_type }}</td> --}}
                                        {{-- <td>{{ $ticket->employee_id }}</td> --}}
                                        {{-- <td>{{ $ticket->user_id }}</td> --}}
                                        <td><a href="{{route('complaint.show',$ticket->id)}}">{{ $ticket->client->name??'' }}</a></td>
                                       
                                        <td>{{ $ticket->complainer->name ??''}}</td>
                                        <td>{{ $ticket->shift->name??'' }}</td>
                                        <td>{{ $ticket->site->name??'' }}</td>
                                        
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ $ticket->ticket_status }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                     



                                       


                                        <td>
                                            <div class="d-flex order-actions">
                                                {{-- @if (ispermission('user management', 'update'))
                                                    <a href="{{ route('usermanagement.edit', $value->id) }}"
                                                        class=""><i class='bx bxs-edit'></i></a>
                                                @endif --}}
                                                @if (ispermission('user management', 'delete'))
                                                     <a href="javascript:;" class="ms-3" onclick="Deletedata({{$ticket->id}},'{{route('complaint.destroy',$ticket->id)}}')"
                                        ><i class='bx bxs-trash text-danger'></i></a>
                                                @endif
                                            </div>
                                        </td>
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
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });




        // var input1 = document.getElementById('client_id');
        // var input2 = document.getElementById('warehouse_id');
        // var input3 = document.getElementById('city_id');
        // input1.addEventListener('change', function() {

        //     input2.value = null;
        //     input3.value = null;
        //     searchformsubmit22()
        // });
        // input3.addEventListener('change', function() {

        //     input2.value = null;
        //     searchformsubmit22()
        // });
        $( '#client_id' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        allowClear: true
    } );
    </script>

{{-- <script type="text/javascript">
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('usermanagement.index') }}',
                data: function(d) {
                    d.client_id = $('#client_id').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'role.name', name: 'role.name' },
            { data: 'username', name: 'username' },
            { data: 'email', name: 'email' },
            { data: 'mobile_no', name: 'mobile_no' },
            { data: 'city', name: 'city' },
            { data: 'state', name: 'state' },
            { data: 'view', name: 'view', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            ]
        });
    
        $('#client_id').change(function() {
            table.draw();
        });
    });
    </script> --}}
@endpush
