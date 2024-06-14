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
                            <h5 class="mb-0">Clients Checklists</h5>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#addChecklistModal">Add New Checklist</button>
                            <div class="table-responsive">
                                <table class="table mb-0" id="example2">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID#</th>
                                            <th>Name</th>
                                            <th>Site</th>
                                            <th>Shift</th>
                                            <th>Area</th>
                                            <th>QR Code</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($checklists as $checklist)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $checklist->name }}</td>
                                                <td>{{ $checklist->site->name ?? 'N/A' }}</td>
                                                <td><span
                                                    class="badge rounded-pill bg-info">{{ $checklist->shift->name ?? 'N/A' }}</span></td>
                                                <td>{{ $checklist->area->name ?? 'N/A' }}</td>
                                                <td><a href="{{ route('checklist.qr-code', $checklist->id) }}" target="_blank"><i class='bx bx-qr-scan' ></i>QR Code </a></td>
                                                <td>
                                                    <div class="form-check-primary form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            onclick="statuschange(this,'{{ route('checklist.status') }}')"
                                                            data-id="{{ $checklist->id }}"
                                                            @if ($checklist->status == 1) checked @endif>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" class="ms-3"
                                                        onclick="editChecklist({{ $checklist->id }})"><i
                                                            class='bx bxs-edit'></i></a>
                                                    <a href="javascript:;" class="ms-3"
                                                        onclick="Deletedata({{ $checklist->id }}, '{{ route('checklist.delete', $checklist->id) }}')"><i
                                                            class='bx bxs-trash text-danger'></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="addChecklistModal" tabindex="-1" aria-labelledby="addChecklistModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addChecklistModalLabel">Add New Checklist</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row" method="POST" action="{{ route('checklist.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="col-md-12 mb-2">
                                            <label for="name" class="form-label">Checklist Name</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                value="{{ old('name') }}" placeholder="Checklist Name" required>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Select Shifts</label>
                                            <div class="form-check">
                                                @foreach ($shifts as $shift)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="shifts[]"
                                                            value="{{ $shift->id }}" id="shift_{{ $shift->id }}">
                                                        <label class="form-check-label" for="shift_{{ $shift->id }}">
                                                            {{ $shift->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('shifts')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="area_id" class="form-label">Select Area</label>
                                            <select name="area_id"
                                                class="form-select @error('area_id') is-invalid @enderror" required>
                                                <option value="" disabled selected>Select an Area</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('area_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">Select Variables</label>
                                            <div class="form-check">
                                                @foreach ($variables as $variable)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="variables[]"
                                                            value="{{ $variable->id }}" id="variable_{{ $variable->id }}">
                                                        <label class="form-check-label" for="variable_{{ $variable->id }}">
                                                            {{ $variable->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('variables')
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

                    <div class="modal fade" id="editChecklistModal" tabindex="-1"
                        aria-labelledby="editChecklistModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editChecklistModalLabel">Edit Checklist</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row" method="POST" action="{{ route('checklist.update') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="col-md-12 mt-3">
                                            <label for="edit_name" class="form-label">Checklist Name</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" id="edit_name"
                                                value="{{ old('name') }}" placeholder="Checklist Name" required>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label for="edit_area_id" class="form-label">Select Area</label>
                                            <select name="area_id"
                                                class="form-select @error('area_id') is-invalid @enderror"
                                                id="edit_area_id" required>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('area_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">Select Variables</label>
                                            <div class="form-check">
                                                @foreach ($variables as $variable)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="variables[]" value="{{ $variable->id }}"
                                                            id="edit_variable_{{ $variable->id }}">
                                                        <label class="form-check-label"
                                                            for="edit_variable_{{ $variable->id }}">
                                                            {{ $variable->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('variables')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="client_id" value="{{ $id }}" />
                                        <input type="hidden" name="checklist_id" id="checklist_id"  />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
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
                });

                table.buttons().container()
                    .appendTo('#example2_wrapper .col-md-6:eq(0)');
            });

            function editChecklist(id) {
    $.get('{{ route('checklist.edit', ':id') }}'.replace(':id', id), function(data) {
        console.log(data);
        if (data  && data.variables) {
            console.log(data);
            $('#checklist_id').val(data.id);
            $('#edit_name').val(data.name);
            $('#edit_area_id').val(data.area_id);
            $("input[type='checkbox']").prop('checked', false);

            data.variables.forEach(function(variable) {
                $("#edit_variable_" + variable).prop('checked', true);
            });
            $('#editChecklistModal').modal('show');
        } else {
            console.error('Invalid data received from server:', data);
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error('AJAX request failed:', textStatus, errorThrown);
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
