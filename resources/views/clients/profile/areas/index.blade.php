@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-12 col-lg-3">
                    @include('clients.sidebar')
                </div>
                <div class="col-12 col-lg-9">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Clients Areas</h5>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#addAreaModal">Add New Area</button>
                            <div class="table-responsive">
                                <table class="table mb-0" id="example2">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID#</th>
                                            <th>Name</th>
                                            <td>Status</th>
                                            <td>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($areas as $area)
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
                                                <td>{{ $area->name }}</td>
                                                <td>
                                                    <div class="form-check-primary form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            onclick="statuschange(this,'{{ route('area.status') }}')"
                                                            data-id="{{ $area->id }}"
                                                            @if ($area->status == 1) checked @endif>

                                                    </div>
                                                </td>
                                                <td><a href="javascript:;" class="ms-3" onclick="Deletedata({{$area->id}},'{{route('area.delete',$area->id)}}')" ><i class='bx bxs-trash text-danger'></i></a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>

                        {{-- <div class="card">
                            <div class="card-header px-4 py-3">
                                <h5 class="mb-0">Add New Shift</h5>
                            </div>
                            <div class="card-body p-4">
                                <form class="row " method="POST" action="{{ route('area.store') }}"
                                    enctype="multipart/form-data">


                                    @csrf


                                    <div class="col-md-6">
                                        <label for="label" class="form-label">Area Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            value="{{ old('name') }}" placeholder="Shift Name" required>
                                        @error('name')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="client_id" value="{{ $id }}" />
                                    <div class="col-md-12 mt-3">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div> --}}
                        <div class="modal fade" id="addAreaModal" tabindex="-1" aria-labelledby="addAreaModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAreaModalLabel">Add New Area</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add your form here -->
                                        <form class="row" method="POST" action="{{ route('area.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Area Name</label>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                                    id="name" value="{{ old('name') }}" placeholder="Area Name" required>
                                                @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <input type="hidden" name="client_id" value="{{ $id }}" />
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
        <script src="{{ asset('assets/backend/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/backend/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table = $('#example2').DataTable({
                    lengthChange: false,
                    searching: false,
                    "order": [
                        [0, 'desc']
                    ],
                    // buttons: [ 'copy', 'excel', 'pdf', 'print']
                });

                table.buttons().container()
                    .appendTo('#example2_wrapper .col-md-6:eq(0)');
            });

            function Delete(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete the resource
                        $.ajax({
                            url: '{{ route('sku.destroy', ':id') }}'.replace(':id',
                            id), // Assuming id holds the SKU ID
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your file has been deleted.",
                                    icon: "success"
                                });
                                // Reload the page after successful deletion
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            },
                            error: function(xhr) {
                                // Handle error
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            }
        </script>
        <script>
            $(".time-picker").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
            });
        </script>
    @endpush
