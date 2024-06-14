@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Inwards</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="row" style="height:auto;">
            <div class="col-xl-8 mx-auto">
                <div class="card">
                    <div class="card-header px-4 py-3">
                        <h5 class="mb-0">Edit Inward Creation</h5>
                    </div>
                    <div class="card-body p-4" style="height:auto;" >
                        <form class="row g-3" style="height:auto;" method="POST"
                        action="{{ route('inventory.update', $data->id) }}"



                        enctype="multipart/form-data">

                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                         
                               @if($toshow)
                              
                               @else
<div class="col-md-12">
                                <label for="suad" class="form-label">Request</label>
                                <input type="text" class="form-control @error('suad') is-invalid @enderror" name="suad" id="suad" placeholder="{{ $req == 'rejected' ? 'Previous request rejected, send again!' : ($req ? 'Request already sent!' : '') }}">
                                @error('suad')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                               @endif
                            <div class="col-md-12">
                                <label for="purchase_no" class="form-label">Purchase Number</label>
                                <input type="number" class="form-control @error('purchase_no') is-invalid @enderror" name="purchase_no" id="purchase_no" value="{{ isset($data) ? $data->purchase_no :$defaultPurchaseNo }}" {{ $toshow ? 'readonly' : 'disabled' }}>
                                @error('purchase_no')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="date"  class="form-label">Select Date:</label>
                                <input type="date" id="date" class="form-control @error('sku') is-invalid @enderror" value="{{ isset($data) ? $data->date:"" }}" name="date" {{ $toshow ? '' : 'disabled' }}>
                                @error('date')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="vendor_name" class="form-label">Vendor Name</label>
                                <input type="text" class="form-control @error('vendor_name') is-invalid @enderror" id="vendor_name" value="{{ isset($data) ? $data->vendor:"" }}" name="vendor_name"/>
                                @error('vendor_name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="image" class="form-label">Vendor file(pdf, jpg, jpeg, pdf):</label>
                                <div class="input-group">

                                    <input type="file" name="image" accept=".png, .jpg, .jpeg, .pdf"
                                        class="form-control @error('image') is-invalid @enderror" id="image"
                                        placeholder="Upload Sku image" {{ $toshow ? '' : 'disabled' }}>

                                </div>
                                @error('price')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12 d-none">
                                <label for="unit" class="form-label">SKU Unit</label>
                                <div class="input-group" role="group" aria-label="Unit Options">
                                    <input type="hidden" name="unit" id="selectedUnit" value='KG' >
                                    <button type="button" class="btn btn-outline-success unit-option {{ old('unit', isset($data) ? $data->unit : 'KG') == 'KG' ? 'active' : '' }}" data-value="KG">KG</button>
                                    <button type="button" class="btn btn-outline-success unit-option d-none {{ old('unit', isset($data) ? $data->unit : 'KG') == 'Count' ? 'active' : '' }}" data-value="Count">Count</button>
                                </div>
                                @error('unit')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div id="product-list" class="row mt-4" style="height:auto;">
                            @foreach($composition as $compositions)
                            <div class="row">
                            <div class="col-md-6">
                                    <label class="form-label" for="product">Products:</label>
                                    <select class="form-select @error('product') is-invalid @enderror" name="product[]"
                                        {{ $toshow ? 'required' : 'disabled' }} >
                                        @foreach ($skus as $sku)
                                        @if($sku->sku == $compositions["product"])
                                        <option value="{{$compositions["product"]}}" selected>{{$compositions["label_unit"]}}</option>
                                        @else
                                            <option value="{{ $sku->sku }}" >{{ $sku->label }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('product')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label" for="quantity">Quantity (in KG):</label>
                                    <input type="number"  min=1 name="quantity[]"
                                        class="form-control @error('quantity') is-invalid @enderror" value="{{$compositions["quantity"]}}" {{ $toshow ? 'required' : 'disabled' }}>
                                    @error('quantity')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <div class="col-md-3">
                                        <label class="form-label" for="price">Price (in ₹):</label>
                                            <input type="number" name="price[]" min=1
                                                class="form-control @error('price') is-invalid @enderror" value="{{$compositions["price"]}}" {{ $toshow ? 'required' : 'disabled' }}>
                                        @error('price')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div> --}}
                                <div class="col-md-1">
                                    <label class="form-label" for="dlt">Remove</label><br>
                                    <button type="button" onclick="removeProduct(this)" class="btn btn-danger" {{ $toshow ? 'required' : 'disabled' }}><i class='bx bxs-trash'></i></button>
                                </div>
                            </div>
                                @endforeach
                                </div>
                                <button type="button" class="btn btn-primary btn-sm" onclick="addProduct()" {{ $toshow ? 'required' : 'disabled' }}>Add More
                                    Product</button>



                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">
                                         @if($toshow)
                              Update
                               @else
                                        Request
                                        @endif
                                        </button>
                                        <a href="{{ route('inventory.index') }}" class="btn btn-secondary px-4">

                                         Cancel
                                        </a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->





    </div>
</div>
@endsection

@push('script')
{{-- this is working for the product kg/unit --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let unitOptions = document.querySelectorAll('.unit-option');

            // changing the value of the input to pass kg/unit to back
            unitOptions.forEach(function(option) {
                option.addEventListener('click', function() {
                    let selectedUnit = option.getAttribute('data-value');
                    document.getElementById('selectedUnit').value = selectedUnit;

                    // Remove 'active' class from all buttons
                    unitOptions.forEach(function(btn) {
                        btn.classList.remove('active');
                    });

                    // Add 'active' class to the clicked button
                    option.classList.add('active');

//unknown
                    // packet size
                    if (selectedUnit == 'KG') {
                        // Add 'required' attribute
                        $('#packet_size').prop('required', false);
                        $('#packet_div').hide();
                    }
                });
            });
        });
    </script>
    {{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const cityOptions = document.querySelectorAll('.city-option');

        cityOptions.forEach(function(option) {
            option.addEventListener('click', function() {
                this.classList.toggle('active');
            });
        });
    });
</script> --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cityButtons = document.querySelectorAll('.city-option');
            const selectedCitiesInput = document.getElementById('selectedCities');

            cityButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    this.classList.toggle('active');
                    updateSelectedCities();
                });
            });

            function updateSelectedCities() {
                const selectedCities = Array.from(cityButtons)
                    .filter(button => button.classList.contains('active'))
                    .map(button => button.dataset.value);

                selectedCitiesInput.value = JSON.stringify(selectedCities);
            }

            document.getElementById('cityForm').addEventListener('submit', function() {
                updateSelectedCities();
            });
        });
    </script> --}}
    {{-- unknonwn --}}
    <script>
        $(document).ready(function() {
            $('#selectedUnit').on('change', function() {
                // Check if input value is not empty
                if ($(this).val() == 'KG') {
                    // Add 'required' attribute
                    $('#packet_size').prop('required', true);
                    $('#packet_div').show();
                } else {
                    $('#packet_size').prop('required', false);
                    $('#packet_div').hide();
                }
            });
        });
    </script>

   <script>
    // adding new row
    function addProduct() {

        // Check if previous select is blank
        var previousSelect = document.querySelector('#product-list select[name="product[]"]:last-of-type');
        var previousQuantity = document.querySelector('#product-list input[name="quantity[]"]:last-of-type');
        //    var previousPrice = document.querySelector('#product-list input[name="price[]"]:last-of-type');
        if (previousSelect && previousSelect.value == '') {
            Swal.fire({
        title: "Unable to add new field!!!",
        text: "please, enter the value of previous product field",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Ok"
    })
            return; // If previous select is blank, return without adding new row
        }else if(previousQuantity && previousQuantity.value == ''){
            Swal.fire({
        title: "Unable to add new field!!!",
        text: "please, enter the value of previous quantity field",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Ok"
    })
            return;
        }
    //     else if(previousPrice && previousPrice.value === ''){
    //         Swal.fire({
    //     title: "Unable to add new field!!!",
    //     text: "please, enter the value of previous price field",
    //     icon: "warning",
    //     confirmButtonColor: "#3085d6",
    //     confirmButtonText: "Ok"
    // })
    //         return;
    //     }
        
        // Check if max rows limit reached
        var productList = document.querySelectorAll('#product-list .row').length;
        if (productList >= <?php echo count($skus); ?>) {
            return; // If max rows limit reached, return without adding new row
        }

        var productList = document.getElementById('product-list');
        var productDiv = document.createElement('div');
        productDiv.classList.add('row');
        productDiv.innerHTML = `
            <div class="col-md-6">
                <label class="form-label" for="product">Composition:</label>
                <select name="product[]" class="form-select @error('product') is-invalid @enderror" required onchange="updateOptions(this)">
                    <option value="">Select Composition</option>
                    @foreach ($skus as $sku)
                        <option value="{{ $sku->sku }}">{{ $sku->label }}</option> 
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label" for="quantity">Quantity (in KG):</label>
                <input type="number" name="quantity[]"  min=1 class="form-control" required>
            </div>
            <div class="col-md-1">
                <label class="form-label" for="dlt">Remove</label><br>
                <button type="button" onclick="removeProduct(this)" class="btn btn-danger"><i class='bx bxs-trash'></i></button>
            </div>
        `;
        productList.appendChild(productDiv);
        updateOptions(productDiv.querySelector('select[name="product[]"]'));
        
        // Bind event listener for remove button
        var removeButtons = document.querySelectorAll('.btn-danger');
        removeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                removeProduct(button);
            });
        });
    }

    function removeProduct(button) {
        var productDiv = button.closest('.row');
        productDiv.parentNode.removeChild(productDiv);
    }

    function updateOptions(select) {
        var options = select.querySelectorAll('option');
        var selectedProducts = new Set();
        var allSelects = document.querySelectorAll('select[name="product[]"]');

        allSelects.forEach(function(element) {
            var selectedValue = element.value;
            if (selectedValue && element !== select) {
                selectedProducts.add(selectedValue);
            }
        });

        options.forEach(function(option) {
            if (selectedProducts.has(option.value)) {
                option.disabled = true;
            } else {
                option.disabled = false;
            }
        });
    }
</script>

@endpush
