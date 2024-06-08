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
                    <div class="card-body">
                        <h3>Clients Shifts</h3>
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
                                    @foreach ($shifts as $shift )
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
                                        <td>{{$shift->name}}</td>
                                        <td>{{$shift->start_time->format('H:i:A')}}</td>
                                        <td>{{$shift->end_time->format('H:i:A')}}</td>
                                        <td>{{$shift->shift_hr}} Hr.</td>
                                        <td>@foreach ($shift->weekday as $weekday)
                                            <span class="badge rounded-pill bg-success">{{$weekday}}</span>
                                        @endforeach</td>

                                        {{-- <td><button class="btn btn-info">View</button></td> --}}

                                        {{-- <td>{{$value->regular_price}}</td> --}}

                                        {{-- <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td> --}}
                                        @if (ispermission('shift management', 'update'))
                                        <td>
                                            <div class="d-flex order-actions">

                                                <a href="{{route('shiftmanagement.edit',$shift->id)}}" class=""><i class='bx bxs-edit'></i></a>
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
            lengthChange: false,
            searching: false,
            "order": [[0, 'desc']],
            // buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );

        table.buttons().container()
            .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
    } );

    function Delete(id){
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
                url: '{{ route("sku.destroy", ":id") }}'.replace(':id', id), // Assuming id holds the SKU ID
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
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
@endpush
