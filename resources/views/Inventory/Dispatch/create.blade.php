@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Dispatch Management</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create New Dispatch</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Add New Dispatch</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3" method="POST" action="{{ route('inventorydispatch.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="col-md-12">
                                    <label for="sku" class="form-label">Dispatch Number</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              {{-- <span class="input-group-text"><b>DN-</b></span> --}}
                                            </div>
                                            <input type="number" class="form-control @error('sku') is-invalid @enderror" name="dispatchNumber" id="sku" value="{{ $defaultdispatchNumber }}" readonly>
                                          </div>
                                        </div>
                                      </div>
                                      
                                    @error('sku')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <label class="form-label" for="client">Clients:</label>
                                        <select class="form-select @error('client') is-invalid @enderror" id="client" name="client_id" onchange="shiftfetch(this.value)"
                                            required >
                                            <option value="">Select Clients</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}" >{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('client')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                <div id="Shifts" class="row mt-4">
                                    <div class="col-md-12">
                                        <label class="form-label" for="Shift">Shifts:</label>
                                        <select class="form-select @error('Shift') is-invalid @enderror" id="Shift" name="shift_id" onchange="userfetch(this.value)"
                                            required >
                                            <option value="">Select Shifts</option>
                                            {{-- @foreach ($clients as $client)
                                                <option value="{{ $client->id }}" >{{ $client->name }}</option>
                                            @endforeach --}}
                                        </select>
                                        @error('Shift')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                <div id="Users" class="row mt-4">
                                    <div class="col-md-12">
                                        <label class="form-label" for="User">Receiver:</label>
                                        <select class="form-select @error('User') is-invalid @enderror" id="User" name="user_id" onchange=""
                                            required >
                                            <option value="">Select Receiver</option>
                                            {{-- @foreach ($clients as $client)
                                                <option value="{{ $client->id }}" >{{ $client->name }}</option>
                                            @endforeach --}}
                                        </select>
                                        @error('User')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                <div class="col-md-12 d-none">
                                    <label for="Sendor" class="form-label ">Sendor</label>
                                    <input type="text" name="Sendor"
                                        class="form-control @error('label') is-invalid @enderror" id="Sendor"
                                        value="{{$userName}}" readonly>
                                    @error('Sendor')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12 d-none">
                                    <label for="unit" class="form-label">SKU Unit</label>
                                    <div class="input-group" role="group" aria-label="Unit Options">
                                        <input type="hidden" name="unit" id="selectedUnit"
                                            value="KG">
                                        <button type="button"
                                            class="btn btn-outline-success unit-option active"
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
                                        <label class="form-label" for="quantity">Quantity (in KG):</label>
                                            <input type="number" name="quantity[]"  min=1
                                                class="form-control @error('quantity') is-invalid @enderror" required>
                                        @error('quantity')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm mb-2" onclick="addProduct()">Add More
                                    Product</button>


                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">
                                                Dispatch
                                        </button>
                                        <a href="{{ route('inventorydispatch.index') }}" class="btn btn-secondary px-4">

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
        function shiftfetch(client){
            // alert(client);
            $('#Shift').empty();
            $.ajax({
                url: '{{ route("Dispatch.getshift", [":id"]) }}'.replace(':id', client),
 // Assuming id holds the SKU ID
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function(response) {
                     var shifts = response.message;
                     var defaultoption = $('<option></option>')
            .val("")    // Set the value to the shift's id
            .text("Select Shift"); 
            $('#Shift').append(defaultoption);
                     shifts.forEach(function(shift) {
        // Create an option element
       
        var option = $('<option></option>')
            .val(shift.id)    // Set the value to the shift's id
            .text(shift.name); // Set the text to the shift's name
        // Append the option element to the select element
     
        $('#Shift').append(option);
    });
                    // console.log(response.message)
                    // Reload the page after successful deletion
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr.responseText);
                }
            });
        }
        function userfetch(client){
            $('#User').empty();
            var client_id = $("#client").val();
            var shift_id = client;
            var clientshift = [client_id,shift_id];
            // alert(clientshift);
            $.ajax({
                url: '{{ route("Dispatch.getuser", [":id"]) }}'.replace(':id', clientshift),
 // Assuming id holds the SKU ID
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                success: function(response) {
                    // console.log(response.message);
                    console.log(response);
                     var users = response.message;
                     var defaultoption = $('<option></option>')
            .val("")    // Set the value to the shift's id
            .text("Select Receiver"); 
            $('#User').append(defaultoption);
                     users.forEach(function(user) {
        // Create an option element
        var option = $('<option></option>')
            .val(user.id)    // Set the value to the shift's id
            .text(user.name + "("+user.role_id+ ")"); // Set the text to the shift's name
        // Append the option element to the select element
        $('#User').append(option);
    });
                    // console.log(response.message)
                    // Reload the page after successful deletion
                },
                error: function(xhr) {
                    // Handle error
                    console.log(xhr.responseText);
                }
            });
        }
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
        if (previousSelect && previousSelect.value === '') {
            Swal.fire({
        title: "Unable to add new field!!!",
        text: "please, enter the value of previous composition field",
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
                    <option value="">Select Product</option>
                    @foreach ($skus as $sku)
                        <option value="{{ $sku->sku }}">{{ $sku->label }}</option> 
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label" for="quantity">Quantity (in KG):</label>
                <input type="number"  min=1 name="quantity[]" class="form-control" required>
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