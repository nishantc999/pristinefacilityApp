@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Client Management</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Create New Client Step 2</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3" method="POST" action="{{ route('clientmanagement.store_step2') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <div id="sitesContainer">
                                    <div class="site">
                                        <label for="siteName">Site:</label>
                                        <input type="text" name="sites[0][name]" id="siteName"
                                            placeholder="Enter Site Name">
                                        <label for="shifts">Shifts:</label>
                                        <select name="sites[0][shifts][]" multiple class="shiftSelect">
                                            <option value="">Add Shift</option>
                                            @foreach ($shifts as $shift)
                                                <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="areas">
                                            <div class="area">
                                                <label for="areaName">Area:</label>
                                                <input type="text" name="sites[0][areas][0][name]"
                                                    placeholder="Enter Area Name">
                                            </div>
                                        </div>
                                        <button type="button" class="addArea">Add Another Area</button>
                                    </div>
                                </div>
                                <button type="button" id="addSite">Add Another Site</button>




                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Submit</button>

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
        document.getElementById('addSite').addEventListener('click', function() {
            var siteIndex = document.querySelectorAll('.site').length;
            var sitesContainer = document.getElementById('sitesContainer');
            var siteDiv = document.createElement('div');
            siteDiv.classList.add('site');

            var siteLabel = document.createElement('label');
            siteLabel.innerText = 'Site:';
            var siteInput = document.createElement('input');
            siteInput.type = 'text';
            siteInput.name = `sites[${siteIndex}][name]`;
            siteInput.placeholder = 'Enter Site Name';

            var shiftLabel = document.createElement('label');
            shiftLabel.innerText = 'Shifts:';
            var shiftSelect = document.createElement('select');
            shiftSelect.name = `sites[${siteIndex}][shifts][]`;
            shiftSelect.multiple = true;
            shiftSelect.classList.add('shiftSelect');

            @foreach ($shifts as $shift)
                var option = document.createElement('option');
                option.value = '{{ $shift->id }}';
                option.text = '{{ $shift->name }}';
                shiftSelect.appendChild(option);
            @endforeach

            var areasDiv = document.createElement('div');
            areasDiv.classList.add('areas');

            var areaDiv = document.createElement('div');
            areaDiv.classList.add('area');

            var areaLabel = document.createElement('label');
            areaLabel.innerText = 'Area:';
            var areaInput = document.createElement('input');
            var areaIndex = 0;
            areaInput.type = 'text';
            areaInput.name = `sites[${siteIndex}][areas][${areaIndex}][name]`;
            areaInput.placeholder = 'Enter Area Name';

            areaDiv.appendChild(areaLabel);
            areaDiv.appendChild(areaInput);

            areasDiv.appendChild(areaDiv);

            var addAreaBtn = document.createElement('button');
            addAreaBtn.type = 'button';
            addAreaBtn.classList.add('addArea');
            addAreaBtn.innerText = 'Add Another Area';

            siteDiv.appendChild(siteLabel);
            siteDiv.appendChild(siteInput);
            siteDiv.appendChild(shiftLabel);
            siteDiv.appendChild(shiftSelect);
            siteDiv.appendChild(areasDiv);
            siteDiv.appendChild(addAreaBtn);

            sitesContainer.appendChild(siteDiv);
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('addArea')) {
                var siteDiv = event.target.closest('.site');
                var siteIndex = [...document.querySelectorAll('.site')].indexOf(siteDiv);
                var areasDiv = siteDiv.querySelector('.areas');
                var areaIndex = areasDiv.querySelectorAll('.area').length;

                var areaDiv = document.createElement('div');
                areaDiv.classList.add('area');

                var areaLabel = document.createElement('label');
                areaLabel.innerText = 'Area:';
                var areaInput = document.createElement('input');
                areaInput.type = 'text';
                areaInput.name = `sites[${siteIndex}][areas][${areaIndex}][name]`;
                areaInput.placeholder = 'Enter Area Name';

                areaDiv.appendChild(areaLabel);
                areaDiv.appendChild(areaInput);

                areasDiv.appendChild(areaDiv);
            }
        });
    </script>
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



                });
            });
        });
    </script>
    <script>
        document.getElementById('mobile').addEventListener('keypress', function(event) {
            // Get the input value
            let inputValue = event.target.value;

            // Ensure it's a number key and not a special key like backspace or delete
            if (!isNaN(Number(event.key))) {
                // If input length is already 10 and user tries to add more digits, prevent that
                if (inputValue.length >= 10) {
                    event.preventDefault();
                }

            } else {
                // Prevent non-numeric input
                event.preventDefault();
            }
        });

        document.getElementById('mobile').addEventListener('input', function(event) {
            let inputValue = event.target.value;
            let validationMessage = document.getElementById('validationMessage');

            if (inputValue.length != 10) {
                validationMessage.textContent = ''; // Clear previous validation message
            } else {
                validationMessage.textContent = 'Please enter exactly 10 digits.';
            }
        });
    </script>
@endpush
