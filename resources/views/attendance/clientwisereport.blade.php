@extends('layouts.app')

@push('style')
    <link href="{{ asset('assets/backend/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Attendance</div>
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
            @elseif (\Session::has('error'))
                @include('includes.partial.single_error')
            @endif






            <!--filter-->





            <div class="card">
                <div class="card-body">
                    @include('attendance.navbar')
                    <form action="{{ route('employee.attendance.clientwise') }}" method="get" id="searchform22">

                        <div class="row m-auto justify-content-center my-3">
                            <div class="col-sm-12 col-md-3">

                                <label for="status" class="form-label">Choose Any Client</label>

                                <select name="client_id" id="client_id" class="form-select" onchange="searchformsubmit22()"
                                    data-placeholder="Choose Any Client">

                                    <option value="">Select</option>

                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ $search_feild['client_id'] == $client->id ? 'selected' : '' }}>
                                            {{ $client->name }}</option>
                                    @endforeach

                                </select>


                            </div>

                            <div class="col-sm-12 col-md-3">

                                <label for="status" class="form-label">Choose Any Shift</label>

                                <select name="shift_id" id="shift_id" class="form-select" onchange="searchformsubmit22()"
                                    data-placeholder="Choose Any Shift">

                                    <option value="">Select</option>

                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}"
                                            {{ $search_feild['shift_id'] == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->name }}</option>
                                    @endforeach

                                </select>


                            </div>


                            <div class="col-sm-12 col-md-3">
                                <label for="inputLastName1" class="form-label">Date Range</label>
                                <div id="reportrange" class="form-control">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>

                            </div>
                            <input type="hidden" name="date_range" autocomplete="off" class="form-control" readonly
                                value="{{ $currentMonthStart }}/{{ $currentMonthEnd }}">
                            {{-- <div class="col-sm-12 col-md-3">
    
                                        <label for="inputLastName1" class="form-label">Date Range</label>
                                        <input type="text" name="date_range" autocomplete="off" class="form-control" readonly
                                            value="{{ $currentMonthStart }}/{{ $currentMonthEnd }}">
    
                                    </div> --}}
                        </div>
                    </form>
                    {{-- </div>
    
        </div> --}}







                    <!--filter end-->




                    {{-- <div class="card">
            <div class="card-body"> --}}
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        {{-- <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div> --}}


                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="example2">
                            <thead class="table-light">
                                <tr>
                                    <th>ID#</th>
                                    <th>Name</th>
                                    <th>Emp. Code</th>



                                    <th>Email</th>
                                    <th>Mobile No.</th>
                                    <th>Total Days</th>
                                    <th>Total Attenadance</th>
                                    <th>View</th>


                              
                                </tr>
                            </thead>
                            <tbody>
                                @if($data)
                                @foreach ($data->employees as $value)
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
                                        <td>{{ $value->emp_code }}</td>


{{-- @dd($value) --}}


                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->mobile_no }}</td>
                                       
                                        <td>{{ $daydiffrence}}</td>
                                        <td>{{ $value->attendances_count }}</td>
                                        <td><a target="blank" href="{{ url('/employee-wise-attendance') . '?employee_id=' . $value->id . '&date_range=' . request()->query('date_range', '') }}"
                                                class="btn btn-primary btn-sm radius-30 px-4">View Attendances</a></td>


                                    </tr>
                                @endforeach
                                @endif
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
            function getUrlParameter(name) {
                name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
                var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
                var results = regex.exec(location.search);
                return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
            }
            var cityParam = getUrlParameter('client_id');

            // Set the empty table message based on the presence of the city parameter
            var emptyTableMessage = cityParam ? 'No data available' : 'Choose Any Client';
            var table = $('#example2').DataTable({
                lengthChange: true,
                lengthMenu: [10, 25, 50, 100, 200, 500],
                "language": {
                    "emptyTable": emptyTableMessage
                },
                // "order": [[0, 'desc']],
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });


        $('#client_id').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true
        });
        $('#shift_id').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true
        });





        // var input1 = document.getElementById('city_id');
        // var input2 = document.getElementById('warehouse_id');
        // var input3 = document.getElementById('user_id');
        // input1.addEventListener('change', function() {

        //     input2.value = null;
        //     input3.value = null;
        //     searchformsubmit22()
        // });

        $(function() {

            // var start = moment().subtract(29, 'days');
            // var end = moment();
            var currentMonthStart = "{{ $currentMonthStart }}";
            var currentMonthEnd = "{{ $currentMonthEnd }}";

            var start = moment(currentMonthStart);
            var end = moment(currentMonthEnd);

            function cb(start, end) {

                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('input[name="date_range"]').val(start.format('YYYY-MM-DD') + '/' + end.format('YYYY-MM-DD'));

            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                cb(picker.startDate, picker.endDate);
                setTimeout(() => {
                    searchformsubmit22();
                }, 900)
            });
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
            $('#reportrange span').html('');
            $('input[name="date_range"]').val('');
            setTimeout(() => {
                searchformsubmit22();
            }, 900)
        });

        $(function() {

            // $('input[name="date_range"]').daterangepicker({
            //     autoUpdateInput: false,
            //     locale: {
            //         cancelLabel: 'Clear'
            //     }
            // });

            // $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
            //     $(this).val(picker.startDate.format('YYYY-MM-DD') + '/' + picker.endDate.format('YYYY-MM-DD'));
            //     setTimeout(() => {
            //        searchformsubmit22();
            //     }, 900)
            // });

            // $('input[name="date_range"]').on('cancel.daterangepicker', function(ev, picker) {
            //     $(this).val('');
            //     setTimeout(() => {
            //         searchformsubmit22();
            //     }, 900)
            // });


        });
    </script>
@endpush
