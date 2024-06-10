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
                                            <th>Site Name</th>
                                            <th>Shifts</th>
                                            <th>Assign Employee</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sites as $site)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $site->name }}</td>
                                            <td>
                                                @foreach ($site->shifts->unique('id') as $shift)
                                                    <span class="badge bg-primary">{{ $shift->name }}</span>
                                                @endforeach
                                            </td>
                                            <td><button class="btn btn-info" onclick="openAssignEmployeeModal({{ $site->id }})">Assign Employee</button></td>
                                            <td>
                                                <div class="form-check-primary form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        onclick="statuschange(this,'{{ route('checklist.status') }}')"
                                                        data-id="{{ $site->id }}"
                                                        @if ($site->status == 1) checked @endif>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript:;" class="ms-3"
                                                    onclick="editChecklist({{ $site->id }})"><i
                                                        class='bx bxs-edit'></i></a>
                                                <a href="javascript:;" class="ms-3"
                                                    onclick="Deletedata({{ $site->id }}, '{{ route('checklist.delete', $site->id) }}')"><i
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
                                    <h5 class="modal-title" id="addChecklistModalLabel">Add New Site/Line</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row" method="POST" action="{{ route('site.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="col-md-12 mb-2">
                                            <label for="name" class="form-label">Site/Line Name</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                value="{{ old('name') }}" placeholder="Site Name" required>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <label for="name" class="form-label mb-1">Select Shifts</label>
                                        @foreach ($shifts as $shift)
                                            <div class="col-md-12 ">

                                                <div class="form-check ">
                                                    <input class="form-check-input shift-checkbox " type="checkbox" name="shifts[]"
                                                        value="{{ $shift->id }}" id="shift_{{ $shift->id }}" onchange="toggleAreas(this)">
                                                    <label class="form-check-label" for="shift_{{ $shift->id }}">
                                                        {{ $shift->name }}
                                                    </label>

                                            </div>
                                            </div>

                                            <div class="col-md-12 shift-areas" id="shift_areas_{{ $shift->id }}" style="display:none;">
                                                <label class="form-label">Select Areas for {{ $shift->name }}</label>
                                                @foreach ($areas as $area)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="shift_{{ $shift->id }}_areas[]"
                                                            value="{{ $area->id }}" id="shift_{{ $shift->id }}_area_{{ $area->id }}">
                                                        <label class="form-check-label" for="shift_{{ $shift->id }}_area_{{ $area->id }}">
                                                            {{ $area->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr>
                                        @endforeach

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
<!-- Add this modal popup -->
<div class="modal fade" id="assignEmployeeModal" tabindex="-1" aria-labelledby="assignEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignEmployeeModalLabel">Assign Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignEmployeeForm">
                    <div class="mb-3">
                        <label for="multiple-select-field" class="form-label">Basic multiple select</label>
                        <select class="form-select" name="employees[]" id="multiple-select-field" data-placeholder="Choose anything" multiple>
                        {{-- <select multiple class="form-control" id="employeeSelect"> --}}
                            <!-- Options will be added dynamically using JavaScript -->
                        </select>
                    </div>
                    <input type="hidden" name="site_id" id="siteIdInput">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitAssignEmployeeForm()">Save changes</button>
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
            function toggleAreas(checkbox) {
                var shiftId = checkbox.value;
                var areasDiv = document.getElementById('shift_areas_' + shiftId);
                if (checkbox.checked) {
                    areasDiv.style.display = 'block';
                } else {
                    areasDiv.style.display = 'none';
                }
            }

            function editChecklist(id) {
                $.get('{{ route('checklist.edit', ':id') }}'.replace(':id', id), function(data) {
                    console.log(data);
                    if (data && data.variables) {
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
    function openAssignEmployeeModal(siteId) {
        // Set the site ID in the hidden input field
        document.getElementById('siteIdInput').value = siteId;

        // Fetch employees from the server and populate the multi-select input
        fetchEmployees();

        // Open the modal popup
        $('#assignEmployeeModal').modal('show');
    }

    async function fetchEmployees() {
        try {
            const response = await fetch('/employees/available');
            const data = await response.json();

            const employeeSelect = document.getElementById('multiple-select-field');
            employeeSelect.innerHTML = '';

            data.forEach(employee => {
                const option = document.createElement('option');
                option.value = employee.id;
                option.text = employee.name;
                employeeSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching employees:', error);
        }
    }

    function submitAssignEmployeeForm() {
    const form = document.getElementById('assignEmployeeForm');
    const formData = new FormData(form);

    // Retrieve selected employee IDs from the multiple select field
    const selectedEmployeeIds = Array.from(formData.getAll('multiple-select-field'));

    // Log the selected employee IDs to the console
    console.log('Selected Employee IDs:', selectedEmployeeIds);

    // Get the CSRF token value from the meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Append the CSRF token to the FormData object
    formData.append('_token', csrfToken);

    // Log the form data for debugging
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    fetch('/sites/assign-employees', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Assign employees success:', data);
        $('#assignEmployeeModal').modal('hide');
    })
    .catch(error => {
        console.error('Assign employees error:', error);
    });
}




</script>
    @endpush
