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
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
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
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Create New Inward</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3" method="POST" action="{{ route('inventory.store') }}"
                            enctype="multipart/form-data">
                            @csrf
<div class="col-md-12">
                            <label for="purchase_no" class="form-label">Purchase Number</label>
                            <input type="number" class="form-control @error('purchase_no') is-invalid @enderror" name="purchase_no" id="purchase_no" value="{{ isset($data) ? $data->sku :"$defaultPurchaseNo" }}" readonly>
                            @error('purchase_no')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                            <div class="col-md-12">
                                <label for="date"  class="form-label">Select Date:</label>
                                {{-- <input type="date" id="date" class="form-control @error('sku') is-invalid @enderror" name="date"> --}}
                                <input type="text" id="date" class="form-control @error('sku') is-invalid @enderror date-format" name="date"/>
                                @error('date')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="vendor_name" class="form-label">Vendor Name</label>
                                <input type="text" class="form-control @error('vendor_name') is-invalid @enderror" id="vendor_name" name="vendor_name"/>
                                @error('vendor_name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>
                            {{-- <div class="col-md-12">
                                <label for="vendor_name" class="form-label">Vendor Name</label>
                                <select class="form-select @error('vendor_name') is-invalid @enderror" id="vendor_name" name="vendor_name"
                                        required >
                                        <option value="">Select Vendor</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" >{{ $vendor->legalname }}</option>
                                        @endforeach
                                    </select>
                                @error('vendor_name')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}
                            <div class="col-md-12">
                                <label for="image" class="form-label">Vendor file(pdf, jpg, jpeg, pdf):</label>
                                <div class="input-group">

                                    <input type="file" name="image" accept=".png, .jpg, .jpeg, .pdf"
                                        class="form-control @error('image') is-invalid @enderror" id="image"
                                        placeholder="Upload Sku image">

                                </div>
                                @error('image')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12 d-none">
                                <label for="unit" class="form-label">SKU Unit</label>
                                <div class="input-group" role="group" aria-label="Unit Options">
                                    <input type="hidden" name="unit" id="selectedUnit"
                                        value="{{ old('unit', isset($data) ? $data->unit : 'KG') }}">
                                    <button type="button"
                                        class="btn btn-outline-success unit-option {{ old('unit', isset($data) ? $data->unit : 'KG') == 'KG' ? 'active' : '' }}"
                                        data-value="KG">KG</button>
                                    <button type="button"
                                        class="btn btn-outline-success unit-option d-none {{ old('unit', isset($data) ? $data->unit : 'KG') == 'C' ? 'active' : '' }}"
                                        data-value="Count">Count</button>
                                </div>
                                @error('unit')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div id="product-list" class="row mt-4">
                                <div class="col-md-6">
                                    <label class="form-label" for="product">Products:</label>
                                    <select class="form-select @error('product') is-invalid @enderror" name="product[]"
                                        required >
                                        <option value="">Select Product</option>
                                        @foreach ($skus as $sku)
                                            <option value="{{ $sku->sku }}" >{{ $sku->label }}</option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="quantity">Quantity (in KG/Unit):</label>
                                        <input type="number" name="quantity[]" min=1
                                            class="form-control @error('quantity') is-invalid @enderror" required>
                                    @error('quantity')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <div class="col-md-4">
                                    <label class="form-label" for="price">Price (in ₹):</label>
                                        <input type="number" name="price[]" min=1
                                            class="form-control @error('price') is-invalid @enderror" required>
                                    @error('price')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div> --}}
                            </div>
                            <button type="button" class="btn btn-primary btn-sm mb-2" onclick="addProduct()">Add More
                                Products</button>


                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">

                                        @if (isset($edit))
                                            Update
                                        @else
                                            Submit
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let unitOptions = document.querySelectorAll('.unit-option');

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
<script>
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
</script>
<script>
    $(document).ready(function() {

        $(".date-format").flatpickr({
        altInput: true,
        altFormat: "Y-m-d",
        dateFormat: "Y-m-d",
        maxDate: new Date().toISOString().split("T")[0] // Get today's date in "YYYY-MM-DD" format
    });
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

function setTheWeight(e) {
id=e.value;
var previousSelect = $('#product-list select[name="product[]"]');
previousSelect.on("change", function() {
var label = previousSelect.prev();

    var boldTag = label.find('b');
        boldTag.text("New Inner Text");
});
}
function addProduct() {
    // Check if previous select is blank
    var previousSelect = document.querySelector('#product-list select[name="product[]"]:last-of-type');
    var previousQuantity = document.querySelector('#product-list input[name="quantity[]"]:last-of-type');
    // var previousPrice = document.querySelector('#product-list input[name="price[]"]:last-of-type');
    if (previousSelect && previousSelect.value === '') {
        Swal.fire({
    title: "Unable to add new field!!!",
    text: "please, enter the value of previous product field",
    icon: "warning",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "Ok"
})
        return; // If previous select is blank, return without adding new row
    }else if(previousQuantity && previousQuantity.value === ''){
        Swal.fire({
    title: "Unable to add new field!!!",
    text: "please, enter the value of previous quantity field",
    icon: "warning",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "Ok"
})
        return;
    }
    // Check if max rows limit reached
    var productList = document.querySelectorAll('#product-list .row').length;
    if (productList >= <?php echo count($skus)-1; ?>) {
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
            <label class="form-label" for="quantity"  min=1>Quantity (in KG/Unit):</label>
            <input type="number" name="quantity[]" class="form-control" required>
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
