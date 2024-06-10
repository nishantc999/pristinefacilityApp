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
                            <h5 class="mb-0">Clients Shifts</h5>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table mb-0" id="example2">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID#</th>
                                            <th>Name</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>

                                            <th>Shift Hr.</th>
                                            <th>Days</th>
                                            @if (ispermission('shift management', 'update'))
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shifts as $shift)
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
                                                <td>{{ $shift->name }}</td>
                                                <td>{{ $shift->start_time->format('H:i:A') }}</td>
                                                <td>{{ $shift->end_time->format('H:i:A') }}</td>
                                                <td>{{ $shift->shift_hr }} Hr.</td>
                                                <td>
                                                    @foreach ($shift->weekday as $weekday)
                                                        <span
                                                            class="badge rounded-pill bg-success">{{ $weekday }}</span>
                                                    @endforeach
                                                </td>

                                                {{-- <td><button class="btn btn-info">View</button></td> --}}

                                                {{-- <td>{{$value->regular_price}}</td> --}}

                                                {{-- <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td> --}}
                                                @if (ispermission('shift management', 'update'))
                                                    <td>
                                                        <div class="d-flex order-actions">

                                                            <a href="{{ route('shiftmanagement.edit', $shift->id) }}"
                                                                class=""><i class='bx bxs-edit'></i></a>
                                                            {{-- <button  onclick="Delete({{ $value->id }})" class="btn btn-danger ms-3 rounded border-0" ><i class='bx bxs-trash '></i> --}}
                                                            </button>

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

                        <div class="card">
                            <div class="card-header px-4 py-3">
                                <h5 class="mb-0">Add New Shift</h5>
                            </div>
                            <div class="card-body p-4">
                                <form class="row " method="POST" action="{{ route('shift.store') }}"
                                    enctype="multipart/form-data">


                                    @csrf


                                    <div class="col-md-6">
                                        <label for="label" class="form-label">Shift name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            value="{{ old('name') }}" placeholder="Shift Name" required>
                                        @error('name')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="label" class="form-label">Description</label>
                                        <input type="text" name="description"
                                            class="form-control @error('description') is-invalid @enderror" id="description"
                                            value="{{ old('description') }}" placeholder="Shift description" required>
                                        @error('description')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label">Start Time</label>
                                            <input type="text"
                                                class="form-control time-picker flatpickr-input active @error('start_time') is-invalid @enderror"
                                                name="start_time" readonly="readonly">
                                        </div>
                                        @error('start_time')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label class="form-label">End Time</label>
                                            <input type="text"
                                                class="form-control time-picker flatpickr-input active @error('end_time') is-invalid @enderror"
                                                name="end_time" readonly="readonly">
                                        </div>
                                        @error('end_time')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="label" class="form-label">Shift Days</label>
                                        <div class="btn-group-toggle d-md-flex justify-content-between"
                                            data-toggle="buttons">
                                            <label class="btn btn-info">
                                                <input type="checkbox" name="weekday[]" value="Monday"> Monday
                                            </label><br>
                                            <label class="btn btn-info">
                                                <input type="checkbox" name="weekday[]" value="Tuesday"> Tuesday
                                            </label><br>
                                            <label class="btn btn-info">
                                                <input type="checkbox" name="weekday[]" value="Wednesday"> Wednesday
                                            </label><br>
                                            <label class="btn btn-info">
                                                <input type="checkbox" name="weekday[]" value="Thursday"> Thursday
                                            </label><br>
                                            <label class="btn btn-info">
                                                <input type="checkbox" name="weekday[]" value="Friday"> Friday
                                            </label><br>
                                            <label class="btn btn-info">
                                                <input type="checkbox" name="weekday[]" value="Saturday"> Saturday
                                            </label><br>
                                            <label class="btn btn-info">
                                                <input type="checkbox" name="weekday[]" value="Sunday"> Sunday
                                            </label><br>
                                        </div>
                                        @error('weekday')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="label" class="form-label">Shift Type</label>
                                        <div class="btn-group-toggle d-flex flex-wrap " data-toggle="buttons">
                                            <label class="btn btn-info mr-2 mb-2">
                                                <input type="radio" name="shift_hr" value="12"> 12 Hr.
                                            </label>
                                            <label class="btn btn-info mb-2">
                                                <input type="radio" name="shift_hr" value="8"> 8 Hr.
                                            </label>
                                        </div>
                                        @error('shift_hr')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="client_id" value="{{ $id }}" />
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
