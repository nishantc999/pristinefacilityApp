
text/x-generic Inventory.blade.php ( HTML document, ASCII text )
@extends('layouts.app')

@push('style')
<link href="{{asset('assets/backend/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
@endpush
@section('content')


<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{$inventoryname}}</div>
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
        @include('includes.partial.error_alert')
        @endif
        @if($inventoryname=="User Inventory")
        <div class="card">
            <div class="card-body">
                <form action="{{ route('inventorymeasureuser') }}" method="get" id="searchform22">

                    <div class="row m-auto justify-content-center my-3">
                        <div class="col-sm-12 col-md-4">


                            <label for="client" class="form-label">Choose Client</label>

                            <select name="client" id="client" class="form-select"
                                data-placeholder="Choose Client">
                                <option value="">None selected</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client ->id}}"
                                            {{ $client ->id == $search_feild['client'] ? 'selected' : '' }}>
                                            {{ $client->name}}</option>
                                    @endforeach

                            </select>

                        </div>
                        <div class="col-sm-12 col-md-4">


                            <label for="shift" class="form-label">Choose Shift</label>

                            <select name="shift" id="shift" class="form-select"
                                data-placeholder="Choose Shift">
                                <option value="">None selected</option>
                                @foreach ($shift as $shift)
                                        <option value="{{ $shift ->id}}"
                                            {{ $shift ->id == $search_feild['shift'] ? 'selected' : '' }}>
                                            {{ $shift->name}}</option>
                                    @endforeach

                            </select>

                        </div>
                        <div class="col-sm-12 col-md-4">


                            <label for="status" class="form-label">Choose Receiver</label>

                            <select name="receiver" id="sendor" class="form-select"
                                data-placeholder="Choose Receiver" >
                                <option value="">None selected</option>
                                @if($sendor)
                                    @foreach ($sendor as $sendor)
                                        <option value="{{ $sendor ->id}}"
                                            {{ $sendor ->id == $search_feild['receiver'] ? 'selected' : '' }}>
                                            {{ $sendor -> name}}</option>
                                    @endforeach
                                    @endif

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
        @endif
            <div class="card-body" style=" padding: 20px; justify-content: center; align-items: center;" >
     <div class="container m-4" style="">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xxl-3">
                       
                        <?php $hasInventory = false; ?>
                    @foreach ($data as $value)
                    @if($inventoryname=="User Inventory")
                        @if($value["sku_quantity"])
                        @if($shift != null && $search_feild['client'] != null && $search_feild['shift'])
                         <?php $hasInventory = true; ?>
        <div class="card" style="display: flex; flex-direction: row; align-items: center; margin-right:1vw;">
            <img src="{{ asset('assets/images/' . $value["image"]) }}" alt="Card image" style="height:7vw; width:7vw; margin:0.5vw; object-fit: cover; ">
            <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h4 class="mb-0 text-secondary" style="font-size:0.9git vw;"><b>{{$value["label"]}}</b></h4>
                                                   <h4 class="mb-0 text-danger" style="font-size:0.9git vw;">SKU: <b>{{ $value["sku_label"] ?? $value["product"] }}
                                                </b></h4>
                                            <h4 class="my-1" id="totalItems">Avl Qty: <b>{{$value["sku_quantity"]}} 
                                                @if($inventoryname == "Final Inventory")
                                                Unit
                                                @else
                                                KG
                                            @endif</b></h4>
                                        </div>
                                  
                                        
                                    </div>
                                </div>
        </div>
          @endif
          @else
<div class="d-flex justify-content-center align-items-center" style="height: 70vh; width:80vw; background-size: cover; background-position: center;">
    <p style=" font-size: 2em;">None selected</p>
     <img src="{{ asset('assets/images/inventory.png') }}" alt="Card image" style="height:7vw; width:7vw; margin:0.5vw; object-fit: cover; ">
</div>
@endif
          @else
                        @if($value->sku_quantity)
                         <?php $hasInventory = true; ?>
        <div class="card" style="display: flex; flex-direction: row; align-items: center; margin-right:1vw;">
            <img src="{{ asset('assets/images/' . $value->image) }}" alt="Card image" style="height:7vw; width:7vw; margin:0.5vw; object-fit: cover; ">
            <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h4 class="mb-0 text-secondary" style="font-size:0.9git vw;"><b>{{$value->label}}</b></h4>
                                                   <h4 class="mb-0 text-danger" style="font-size:0.9git vw;">SKU: <b>{{$value->sku_label}}</b></h4>
                                            <h4 class="my-1" style="font-size:0.9git vw;" id="totalItems">@if($value->BatchNumber)Batch: <br/><b>{{$value->BatchNumber}}</b>@endif</h4>
                                            <h4 class="my-1" id="totalItems">Avl Qty: <b>{{$value->sku_quantity}} 
                                                @if($inventoryname == "Final Inventory")
                                                Unit
                                                @else
                                                KG
                                            @endif</b></h4>
                                        </div>
                                  
                                        
                                    </div>
                                </div>
        </div>
          @endif
          @endif
                        @endforeach
                     @if (!$hasInventory)
    <div class="d-flex justify-content-center align-items-center" style="height: 70vh; width:80vw; background-size: cover; background-position: center;">
        <p style=" font-size: 2em;">No inventory</p>
         <img src="{{ asset('assets/images/inventory.png') }}" alt="Card image" style="height:7vw; width:7vw; margin:0.5vw; object-fit: cover; ">
    </div>
@endif


    </div></div>

                

</div>

@endsection
@push('script')
<script src="{{asset('assets/backend/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/backend/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>

<script>
    var input1 = document.getElementById('sendor');
       
       input1.addEventListener('change', function() {

          
           searchformsubmit22()
       });
    var input1 = document.getElementById('shift');
       
       input1.addEventListener('change', function() {

          
           searchformsubmit22()
       });
    var input1 = document.getElementById('client');
       
       input1.addEventListener('change', function() {

          
           searchformsubmit22()
       });
    $(document).ready(function() {
        var table = $('#example2').DataTable( {
            lengthChange: true,
            "order": [[0, 'desc']],
            buttons: [ 'copy', 'excel', 'pdf', 'print']
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