
text/x-generic index.blade.php ( HTML document, ASCII text, with very long lines )
@extends('layouts.app')

@push('style')
<link href="{{asset('assets/backend/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endpush
@section('content')


<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Dispatch</div>
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
        @elseif (\Session::has('failure'))
    @include('includes.partial.failure_alert')
        @elseif (\Session::has('error'))
        @include('includes.partial.error_alert')
        @endif
        <div class="card">
            <div class="card-body">
                <form action="{{ route('inventorydispatch.index') }}" method="get" id="searchform22">

                    <div class="row m-auto justify-content-center my-3">

                        <div class="col-sm-12 col-md-4">
                            <label class="form-label">Date Range</label>
                            <input name="sendingDate" id="sendingDate"  value="{{$search_feild['sendingDate']}}" type="text" class="form-control date-range" readonly/>
                        </div>
                        <div class="col-sm-12 col-md-4">


                            <label for="status" class="form-label">Choose Sender</label>

                            <select name="sendor" id="sendor" class="form-select"
                                data-placeholder="Choose Distributor">
                                <option value="">All</option>
                                    @foreach ($sendor as $sendor)
                                        <option value="{{ $sendor }}"
                                            {{ $sendor == $search_feild['sendor'] ? 'selected' : '' }}>
                                            {{ $sendor }}</option>
                                    @endforeach

                            </select>

                        </div>
                        <div class="col-sm-12 col-md-4">


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

                    <div class="ms-auto">
                        <a href="{{route('inventorydispatch.create')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Dispatch</a>
                    </div>


                </div>
                <div class="table-responsive">
                    <table class="table mb-0" id="example2">
                        <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>Dispatch Number</th>
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th>Sending Date</th>
                                <th>Receiving Date</th>
                                <th>Status</th>
                                <th>Products</th>
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
                                <td>{{$value->dispatchNumber}}</td>
                                <td>{{$value->sender}}</td>
                                <td>{{$value->receiver ?? "not  yet received"}}</td>
                                <td>{{$value->sendingDate}}</td>
                                <td>{{$value->receivingDate?? "not available"}}</td>
                                <td> @if($value->status == "rejected")
        <p class="status status-rejected">{{$value->status}}</p>
    @elseif($value->status == "received")
        <p class="status status-received">{{$value->status}}</p>
    @elseif($value->status == "dispatched")
        <p class="status status-dispatched">{{$value->status}}</p>
    @endif
                                    @if($value->status=="rejected")
                                    <i class="fas fa-reply cursor-pointer" onclick="Resend({{ $value->dispatchNumber }},{{$value->quantity}})">Resend</i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('inventorydispatch.show',$value->dispatchNumber)}}"> 
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
  <path d="M12 4.5C7.5 4.5 3.6 7.1 1.6 11.5c2 4.4 5.9 7 10.4 7s8.4-2.6 10.4-7c-2-4.4-5.9-7-10.4-7zM12 17c-2.8 0-5.2-1.4-6.6-3.5 1.4-2.1 3.8-3.5 6.6-3.5s5.2 1.4 6.6 3.5c-1.4 2.1-3.8 3.5-6.6 3.5zm0-9c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4zm0 6.5c-1.4 0-2.5-1.1-2.5-2.5s1.1-2.5 2.5-2.5 2.5 1.1 2.5 2.5-1.1 2.5-2.5 2.5z"/>
</svg>
                                    </a>                                 
                                </td>
                                {{-- <td><button class="btn btn-info">View</button></td> --}}

                                {{-- <td>{{$value->regular_price}}</td> --}}

                                {{-- <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td> --}}
                                <td>
                                    @if(ispermission('user management', 'show') && $value->req)
                                    @if($value->req != "accepted"&& $value->req != "rejected" && $value->req != "deleted"&& $value->req != "nodeletion")
                                     <div class="d-inline-block ms-2">
                                        <button  onclick="requestApproval('{{ $value->id }}', '{{ $value->req }}')" class="btn cursor-pointer" style="background-color:yellow;color:blue;border:none;" ><i class='bx bxs-check-circle'></i>
                                        </button>
                                        </div>
                                        @endif
                                        
                                        @endif
                                    @if($value->status=="received")
                                    @else
                                     <div class="d-inline-block ms-2">
                                        <a href="{{route('inventorydispatch.edit',$value->dispatchNumber)}}" class="btn cursor-pointer" style="background-color:lightgrey;color:white;border:none;"><i class='bx bxs-edit' style="padding:1vw;"></i></a>
                                        </div>
                                    <div class="d-inline-block ms-2">     
                                        <button  onclick="Delete('{{ $value->dispatchNumber }}','{{$value->quantity}}', '{{ $value->created_at }}','{{$value -> req}}')" class="btn cursor-pointer" style="background-color:red;color:white;border:none;"><i class='bx bxs-trash ' style="padding:1vw;"></i>
                                        </button>
                                  
                                    </div>
                                    
                                    @endif
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
<script src="{{asset('assets/backend/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable( {
            lengthChange: true,
            "order": [[1, 'desc']],
            // buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );

        table.buttons().container()
            .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
    } );
 function Delete(id, quantity, date, req){
      var alertDate = new Date(date);
// Get the current date
var currentDate = new Date();

// Compare the dates
    
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!" + (quantity ? " This contains inventory " + quantity + "these will get deleted permanently.": ""),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to delete the resource
            $.ajax({
                url: '{{ route("inventorydispatch.destroy", [":id"]) }}'.replace(':id', id),
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
//     function Delete(id, quantity){
//     Swal.fire({
//         title: "Are you sure?",
//         text: "You won't be able to revert this!" + (quantity ? " This contains inventory " + quantity + "these will get deleted permanently.": ""),
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Yes, delete it!"
//     }).then((result) => {
//         if (result.isConfirmed) {
//             // Send AJAX request to delete the resource
//             var url = '/RWDispatch/' + id; // Assuming the route is '/sku/{id}' for deletion
//             $.ajax({
//                 url: url,
//                 type: 'DELETE',
//                 data: {_token: '{{ csrf_token() }}'}, // Pass CSRF token directly here
//                 success: function(response) {
//                     Swal.fire({
//                         title: "Deleted!",
//                         text: response.message,
//                         icon: "success"
//                     });
//                     // Reload the page after successful deletion
//                     setTimeout(function() {
//                         location.reload();
//                     }, 2000);
//                 },
//                 error: function(xhr) {
//                     // Handle error
//                     console.log(xhr.responseText);
//                 }
//             });
//         }
//     });
// }
//  function requestApproval(id, otherId){
//     Swal.fire({
//         title: "Are you sure to accept this request?",
//         text: otherId,
//         icon: "warning",
//         showCancelButton: true,
//           showDenyButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         denyButtonColor: "#f39c12",
//         confirmButtonText: "Yes, accept it!",
//          denyButtonText: "Reject"
//     }).then((result) => {
        
//         if (result.isDenied) {
//              if(otherId == "delete"){
//                  $.ajax({
//                 url: '{{ route("inventorydispatch.update", [":id"]) }}'.replace(':id', id) + '?text=' + encodeURIComponent("nodeletion"),
//  // Assuming id holds the SKU ID
//                 type: 'PATCH',
//                 data: {_token: '{{ csrf_token() }}'},
//                 success: function(response) {
//                     Swal.fire({
//                         title: "Updated!",
//                         text: response.message,
//                         icon: "success"
//                     });
//                     // Reload the page after successful deletion
//                     setTimeout(function() {
//                         location.reload();
//                     }, 2000);
//                 },
//                 error: function(xhr) {
//                     // Handle error
//                     console.log(xhr.responseText);
//                 }
//             });
//              }
//              else{
//          $.ajax({
//                 url: '{{ route("inventorydispatch.update", [":id"]) }}'.replace(':id', id) + '?text=' + encodeURIComponent("rejected"),
//  // Assuming id holds the SKU ID
//                 type: 'PATCH',
//                 data: {_token: '{{ csrf_token() }}'},
//                 success: function(response) {
//                     Swal.fire({
//                         title: "Updated!",
//                         text: response.message,
//                         icon: "success"
//                     });
//                     // Reload the page after successful deletion
//                     setTimeout(function() {
//                         location.reload();
//                     }, 2000);
//                 },
//                 error: function(xhr) {
//                     // Handle error
//                     console.log(xhr.responseText);
//                 }
//             });}
//     } 
//        else if (result.isConfirmed) {
//            if(otherId == "delete"){
//              $.ajax({
//                 url: '{{ route("inventorydispatch.update", [":id"]) }}'.replace(':id', id) + '?text=' + encodeURIComponent("deleted"),
//  // Assuming id holds the SKU ID
//                 type: 'PATCH',
//                 data: {_token: '{{ csrf_token() }}'},
//                 success: function(response) {
//                     Swal.fire({
//                         title: "Updated!",
//                         text: response.message,
//                         icon: "success"
//                     });
//                     // Reload the page after successful deletion
//                     setTimeout(function() {
//                         location.reload();
//                     }, 2000);
//                 },
//                 error: function(xhr) {
//                     // Handle error
//                     console.log(xhr.responseText);
//                 }
//             });
//         }
//         else{
//             // Send AJAX request to delete the resource
//             $.ajax({
//                 url: '{{ route("inventorydispatch.update", [":id"]) }}'.replace(':id', id) + '?text=' + encodeURIComponent("accepted"),
//  // Assuming id holds the SKU ID
//                 type: 'PATCH',
//                 data: {_token: '{{ csrf_token() }}'},
//                 success: function(response) {
//                     Swal.fire({
//                         title: "Updated!",
//                         text: response.message,
//                         icon: "success"
//                     });
//                     // Reload the page after successful deletion
//                     setTimeout(function() {
//                         location.reload();
//                     }, 2000);
//                 },
//                 error: function(xhr) {
//                     // Handle error
//                     console.log(xhr.responseText);
//                 }
//             });}
//         }
//     });
// }
    function Resend(id, quantity){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!" + (quantity ? " This contains inventory " + quantity + "these will get deleted permanently.": ""),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, resend it!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to delete the resource
            var url = '/inventorydispatch/resend/' + id; // Assuming the route is '/sku/{id}' for deletion
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'}, // Pass CSRF token directly here
                success: function(response) {
                    Swal.fire({
                        title: "Dispatched!",
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
    });
}




$(function() {
    $('input[name="sendingDate"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        },
        maxDate: moment()
    });

    $('input[name="sendingDate"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
        searchformsubmit22();
    });

    $('input[name="sendingDate"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        searchformsubmit22();
    });
});
var input1 = document.getElementById('sendor');
       
       input1.addEventListener('change', function() {

          
           searchformsubmit22()
       });
    var input1 = document.getElementById('shift_id');
       
       input1.addEventListener('change', function() {

          
           searchformsubmit22()
       });
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
        .status {
            border-radius: 0.25rem; /* Ensures the same rounded corners */
            padding: 0.25vw;
            color: white;
            text-align: center; /* Centers the text */
        }

        .status-rejected {
            background-color: red;
        }

        .status-received {
            background-color: green;
        }

        .status-dispatched {
            background-color: yellow;
            color: black; /* Adjust text color for readability */
        }

        /* Responsive width */
        @media (max-width: 600px) {
            .status {
                width: 15vw; /* Wider width for smaller screens */
            }
        }

        @media (min-width: 601px) and (max-width: 1024px) {
            .status {
                width: 8vw; /* Medium width for tablets */
            }
        }

        @media (min-width: 1025px) {
            .status {
                width: 5vw; /* Narrow width for larger screens */
            }
        }
    </style>
@endpush