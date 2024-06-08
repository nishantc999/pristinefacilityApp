@extends('layouts.app')

@push('style')
    <link href="{{ asset('assets/backend/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Clients</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">List</li>
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
                        @if (ispermission('client management', 'create'))
                            <div class="ms-auto"><a href="{{ route('clients.create') }}"
                                    class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>New
                                    User</a></div>
                        @endif

                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="example2">
                            <thead class="table-light">
                                <tr>
                                    <th>ID#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact No.</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>

                                    @if (ispermission('client management', 'update'))

                                        <th>Status</th>
                                    @endif
                                    <th>Actions</th>
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
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->mobile_no }}</td>
                                        <td>{{ $client->address }}</td>
                                        <td>{{ $client->city->name ?? '' }}</td>
                                        <td>{{ $client->state->state_title ??''}}</td>
                                        @if (ispermission('client management', 'update'))
                                            <td>
                                                <div class="form-check-primary form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        onclick="statuschange(this,'{{ route('user.status') }}')"
                                                        data-id="{{ $client->id }}"
                                                        @if ($client->status == 1) checked @endif>

                                                </div>
                                            </td>
                                        @endif
                                        <td>
                                            <div class="d-flex order-actions">
                                                @if (ispermission('client management', 'update'))
                                                    <a href="{{ route('clientmanagement.edit', $value->id) }}"
                                                        class=""><i class='bx bxs-edit'></i></a>
                                                @endif
                                                @if (ispermission('user management', 'delete'))
                                                    {{--  <a href="javascript:;" class="ms-3" onclick="Deletedata({{$value->id}},'{{route('usermanagement.destroy',$value->id)}}')"
                                        ><i class='bx bxs-trash text-danger'></i></a> --}}
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
                // buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
