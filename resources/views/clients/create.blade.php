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
                            <h5 class="mb-0">Create New Client</h5>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card-body p-4">
                            <form class="row g-3" method="POST" action="{{ route('clients.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Legal Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" placeholder="Name" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="email" class="form-label">Username</label>
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('username') }}" placeholder="Username" id="username" required>
                                    <span id="username-error" class="text-danger"></span>
                                    <span id="username-loader" class="loader mt-1" style="display: none;"><i class="fas fa-spinner fa-spin"></i>Checking Usename Availability..</span>

                                    <span id="username-feedback"></span> <!-- Add this line -->
                                    @error('username')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" placeholder="Email" value="{{ old('email') }}"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="mobile" class="form-label">Mobile No.</label>
                                    <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
                                        name="mobile" id="mobile" placeholder="Mobile No."
                                        value="{{ old('mobile') }}" required pattern="[0-9]{10}">
                                    @error('mobile')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" id="address" placeholder="address" value="{{ old('address') }}"
                                        required >
                                    @error('address')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="state_id" class="form-label">State</label>
                                    <select name="state_id" id="state_id" class="form-select"
                                        data-placeholder="Choose State" onchange="get_district_on_state_id(this)" required>
                                        <option value="">Select</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">
                                                {{ $state->state_title }}</option>
                                        @endforeach
                                    </select>
                                    @error('state_id')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="district_id" class="form-label">District</label>
                                    <select name="district_id" id="district_id" class="form-select"
                                        data-placeholder="Choose State" onchange="get_city_on_district_id(this)" required>
                                        <option value="">Select</option>
                                    </select>
                                    @error('district_id')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="city_id" class="form-label">City</label>
                                    <select name="city_id" id="city_id" class="form-select"
                                        data-placeholder="Choose State" required>
                                        <option value="">Select</option>
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="mobile_no" placeholder="password"
                                        value="{{ old('password') }}" required>
                                    @error('password')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
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
    document.getElementById('username').addEventListener('input', function() {
        // Clear any previous timeout to avoid multiple requests
        clearTimeout(window.timeoutId);

        // Show the loader
        document.getElementById('username-loader').style.display = 'inline-block';

        // Clear previous error messages
        document.getElementById('username-error').textContent = '';

        // Set a timeout to check availability after 1 second of no input
        window.timeoutId = setTimeout(() => {
            fetch('{{ route('clients.checkUsername') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username: this.value })
            })
            .then(response => response.json())
            .then(data => {
                // Hide the loader
                document.getElementById('username-loader').style.display = 'none';

                // Get the username feedback element
                const usernameFeedback = document.getElementById('username-feedback');

                // Clear existing classes and content
                usernameFeedback.classList.remove('text-success', 'text-danger');
                usernameFeedback.innerHTML = '';

                if (data.exists) {
                    // Username is not available
                    usernameFeedback.classList.add('text-danger');
                    usernameFeedback.innerHTML = '<i class="bx bx-x"></i> Username not available';
                } else {
                    // Username is available
                    usernameFeedback.classList.add('text-success');
                    usernameFeedback.innerHTML = '<i class="bx bx-check"></i> Username available';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Hide the loader in case of error
                document.getElementById('username-loader').style.display = 'none';
            });
        }, 2000); // 1 second delay
    });
    document.getElementById('mobile').addEventListener('input', function() {
    // Remove any non-numeric characters
    this.value = this.value.replace(/\D/g, '');

    // Limit the input to 10 characters
    if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
    }
});
    </script>

    @endpush
