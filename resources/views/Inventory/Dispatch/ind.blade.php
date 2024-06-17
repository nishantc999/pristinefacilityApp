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
                        <li class="breadcrumb-item active" aria-current="page">Products List</li>
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
        @include('includes.partial.error_alert')
        @endif
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    {{-- <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div> --}}

                    <div class="ms-auto">
                        <a href="{{route('inventorydispatch.index')}}" class="btn btn-danger radius-30 mt-2 mt-lg-0"><i class="bx bx-x"></i>Close</a>
                    </div>


                </div>
                <div class="table-responsive">
                    <table class="table mb-0" id="example2">
                        <thead class="table-light">
                            <tr>
                                <th>ID#</th>
                                <th>SKU Number</th>
                                <th>Product</th>
                                <th>Quantity (in KG)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($composition as $item)
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
                                <td>{{$item['product']}}</td>
                                <td> {{$item['label_unit']}}</td>
                                <td>{{$item['quantity']}}</td>
                                
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
            "order": [[0, 'desc']],
            // buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );

        // table.buttons().container()
        //     .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
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