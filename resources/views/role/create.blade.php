@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->


            @if ($errors->any())
                @include('includes.partial.error_alert')
            @endif
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Role</div>
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
                            <h5 class="mb-0">Create New Role</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3" method="POST" action="{{ route('role.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" placeholder="Name" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>




                                <h5 class="mb-0 text-primary">Assign Permission</h5>



                                @foreach ($group_permissions as $key => $permissions)
                                    <h6 class="mb-0 text-primary">{{ $key }}</h6>
                                    <hr>
                                    @foreach ($permissions as $permission)
                                        <div class="col-12">
                                            <div class="row">

                                                <div class="form-check col-md-2">
                                                    <input class="form-check-input role"
                                                        name='permission{{ $permission->id }}' type="checkbox"
                                                        id="permission{{ $permission->id }}" value="1">
                                                    <label class="form-check-label"
                                                        for="permission{{ $permission->id }}">{{ $permission->feature_name }}</label>
                                                </div>

                                            </div>
                                        </div>
                                      
                                    @endforeach
                                @endforeach






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
