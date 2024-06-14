@extends('layouts.app')

@push('style')
    <link href="{{ asset('assets/backend/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Inward</div>
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
                    <form action="{{ route('inventory.index') }}" method="get" id="searchform22">

                        <div class="row m-auto justify-content-center my-3">
    
                            <div class="col-sm-12 col-md-4">
    
    
                                {{-- <label for="date" class="form-label">Choose Date</label> --}}
    
                                {{-- <select name="date" id="date" class="form-select"
                                    data-placeholder="Choose Distributor">
                                   <option value="">All</option>
                                   @foreach ($date as $date )
                                            <option value="{{ $date }}"
                                                {{ $date == $search_feild['date'] ? 'selected' : '' }}>
                                                {{ $date }}</option>
                                        @endforeach
    
                                </select> --}}
                                <label class="form-label">Date Range</label>
                                <input name="date" id="date"  value="{{$search_feild['date']}}" type="text" class="form-control date-range" readonly/>
                            </div>
                            {{-- <div class="col-sm-12 col-md-4">
    
    
                                    <label for="status" class="form-label">Choose Vendor</label>
    
                                    <select name="vendorname" id="vendorname" class="form-select"
                                        data-placeholder="Choose Vendor">
                                        <option value="">All</option>
                                        @foreach($vendorsname as $vendor)
                                        <option value="{{$vendor}}"  {{ $vendor == $search_feild['vendorname'] ? 'selected' : '' }}>{{$vendor}}</option>
                                        @endforeach
                                    </select>
    
                                </div> --}}
                            {{-- <div class="mb-3">
                               
                            </div> --}}
                            {{-- <div class="col-sm-12 col-md-4">
    
    
                                <label for="status" class="form-label">Choose Shift</label>
    
                                <select name="shift_id" id="shift_id" class="form-select"
                                    data-placeholder="Choose Distributor">
                                    <option value="">All</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}"
                                                {{ $shift->id == $search_feild['shift_id'] ? 'selected' : '' }}>
                                                {{ $shift->name }}</option>
                                        @endforeach
    
                                </select>
    
                            </div> --}}
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
                        @if (ispermission('user management', 'create'))


                            <div class="ms-auto"><a href="{{ route('inventory.create') }}"
                                    class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>New Inward</a></div>
                        @endif

                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="example2">
                            <thead class="table-light">
                                <tr>
                                    <th>ID#</th>
                                    <th>Purchase No</th>
                                    <th>Vendor Name</th>
                                    <th>Product Bill</th>
                                    <th>Date</th>
                                    <th>products</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value )
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- <div>
                                                <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                            </div> --}}
                                            <div class="ms-2">
                                                <h6 class="mb-0 font-14">{{$count++}}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$value->purchase_no}}</td>
    {{--                            
                                    <td>{{$composition['product']}}</td>
                                                                  
                                    <td>{{$composition['quantity']}}</td> --}}
                                    
                                    <td>
    {{ucfirst($value->vendor)}}</td>
                                           @if($value->pdf)
                <td class="cursor-pointer">
                    <a href="{{ route('inventory.bill_get', $value->id) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 14.41l-1.41-1.41 1.41-1.41-1.41-1.41 1.41-1.41 1.41 1.41 1.41-1.41 1.41 1.41-1.41 1.41 1.41 1.41-1.41 1.41-1.41-1.41-1.41 1.41zM12 10.5c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5 3.5-1.57 3.5-3.5-1.57-3.5-3.5-3.5zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 12.5 12 12.5 13.5 13.17 13.5 14 12.83 15.5 12 15.5z"/>
                        </svg>View Bill
                    </a>
                </td>
            @else
                <td></td>
            @endif
    
                                    <td>{{$value->date}}</td>
                                    <td>
                                        <a href="{{route('inventory.show',$value->id)}}"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
      <path d="M12 4.5C7.5 4.5 3.6 7.1 1.6 11.5c2 4.4 5.9 7 10.4 7s8.4-2.6 10.4-7c-2-4.4-5.9-7-10.4-7zM12 17c-2.8 0-5.2-1.4-6.6-3.5 1.4-2.1 3.8-3.5 6.6-3.5s5.2 1.4 6.6 3.5c-1.4 2.1-3.8 3.5-6.6 3.5zm0-9c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4zm0 6.5c-1.4 0-2.5-1.1-2.5-2.5s1.1-2.5 2.5-2.5 2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5z"/>
    </svg>
                                        </a>                                 
                                    </td>
                                    <td>
                                        @if(ispermission('user management', 'show') && $value->req)
                                        @if($value->req != "accepted"&& $value->req != "rejected" && $value->req != "deleted"&& $value->req != "nodeletion" )
                                          <div class="d-inline-block ms-2">
                                            <button  onclick="requestApproval('{{ $value->id }}', '{{ $value->req }}')" class="btn cursor-pointer" style="background-color:yellow;color:blue;border:none;"><i class='bx bxs-check-circle'></i>
                                            </button>
                                             </div>
                                            @endif
                                            
                                            @endif
                                          <div class="d-inline-block ms-2">
                                           
                                            <a href="{{route('inventory.edit',$value->id)}}" class="btn cursor-pointer" style="background-color:lightgrey;color:white;border:none;"><i class='bx bxs-edit'></i></a>
                                            </div>
                                            <div class="d-inline-block ms-2">
                                            <button  onclick="Delete('{{ $value->id }}', '{{ $value->sku_label_and_quantity_count }}', '{{ $value->created_at }}','{{$value -> req}}')" class="btn cursor-pointer" style="background-color:red;color:white;border:none;"><i class='bx bxs-trash '></i>
                                            </button>
                                            </div>
    
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
        $(function() {
    $('input[name="date"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        },
        maxDate: moment()
    });

    $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
        searchformsubmit22();
    });

    $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        searchformsubmit22();
    });
});
    </script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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




        var input1 = document.getElementById('role_id');
        var input2 = document.getElementById('warehouse_id');
        var input3 = document.getElementById('city_id');
        input1.addEventListener('change', function() {

            input2.value = null;
            input3.value = null;
            searchformsubmit22()
        });
        input3.addEventListener('change', function() {

            input2.value = null;
            searchformsubmit22()
        });




        function Delete(id, otherId, date, req){
    
    Swal.fire({
        title: "Are you sure? This, consist of " + otherId + " products",
        text: "You won't be able to revert the deletion of these products!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to delete the resource
            $.ajax({
                url: '{{ route("inventory.destroy", [":id"]) }}'.replace(':id', id),
 // Assuming id holds the SKU ID
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function(response) {
                    console.log(response.message)
                    Swal.fire({
                        title: "Deleted!",
                        text: response.message,
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
    }
    
    
    
    
    );
    
}


    </script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

@endpush
