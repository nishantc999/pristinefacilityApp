@extends('layouts.app')

@push('style')
    <link href="{{ asset('assets/backend/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Roles</div>
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
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        {{-- <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div> --}}
                    @if (ispermission('role management','create'))
                        <div class="ms-auto"><a href="{{ route('role.create') }}"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>New
                                Role</a></div>
                                @endif

                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="example2">
                            <thead class="table-light">
                                <tr>
                                    <th>ID#</th>
                                    <th>Name</th>
                                    <th>Permissions</th>




                                    @if (ispermission('role management','update'))

                                    <th>Status</th>
                                    @endif
                                    @if (ispermission('role management','update')|| ispermission('role management','delete'))

                                    <th>Actions</th>
                                    @endif

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
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
                                        <td>{{ $value->name }}</td>
                                        <td>
                                            <table >
                                                <tbody>
                                                    @if ($value->permission !== null)
                                                    @foreach ($value->permission as $key => $permissions)
                                                    <tr>
                                                        <th>-> {{ $key }}</th>
                                                    </tr>


                                                        @foreach ($permissions as $single)
                                                        <tr>
                                                            <td>{{ $single }}</td>
                                                        </tr>

                                                        @endforeach
                                                    @endforeach
                                                        @endif
                                                </tbody>
                                            </table>

                                        </td>
                                        @if (ispermission('role management','update'))

                                        <td>
                                            <div class="form-check-primary form-check form-switch">
                                                <input class="form-check-input" type="checkbox" onclick="statuschange(this,'{{route('role.status')}}')" data-id="{{$value->id}}" @if($value->status==1)checked  @endif>

                                            </div>
                                        </td>
                                        @endif


                                        {{-- <td>{{$value->regular_price}}</td> --}}

                                        {{-- <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td> --}}

                                        @if (ispermission('role management','update')|| ispermission('role management','delete'))
                                        <td>
                                            <div class="d-flex order-actions">
                                                @if (ispermission('role management','update'))
                                                <a href="{{ route('role.edit', $value->id) }}" class=""><i class='bx bxs-edit'></i></a>
                                            @endif
                                            @if (ispermission('role management','delete'))

                                            <a href="javascript:;" class="ms-3" onclick="Deletedata({{$value->id}},'{{route('role.destroy',$value->id)}}')" ><i class='bx bxs-trash text-danger'></i></a>
                                            @endif
                                            </div>
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
                "order": [
                    [0, 'desc']
                ],
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
