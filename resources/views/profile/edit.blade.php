@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->


        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Profile</div>
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


        @if (\Session::has('success'))
        <div class="row position-alert">
            <div class="col-md-4 offset-md-8">
                <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-white"><i class='bx bxs-check-circle'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-white">Success Alerts</h6>
                            <div class="text-white">{!! \Session::get('success') !!}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>

          </div>


        @endif
          @if ($errors->any())
                @foreach ($errors->all() as $error)

                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-white">Danger Alerts</h6>
                            <div class="text-white">{{ $error }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>




                @endforeach
            @endif
        <!--end breadcrumb-->



              <!--form-->
<div class="container">
    <form class="row g-3" method="POST" action="{{route('profile.store')}}" enctype="multipart/form-data">
                @csrf
					<div class="main-body">
						<div class="row">

							<div class="col-lg-12">
								<div class="card">
									<div class="card-body">
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Full Name</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" name="name" value="{{$data->name}}">
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">User Name</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" value="{{$data->username}}" readonly>
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Profile Image</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="file" class="form-control" name="profile">
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Password</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" name="password">
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Confirm Password</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" name="c_password">
											</div>
										</div>

										<div class="row">
											<div class="col-sm-3"></div>
											<div class="col-sm-9 text-secondary">
												<input type="submit" class="btn btn-primary px-4" value="Save Changes">
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
					</form>
				</div>





    </div>
</div>


@endsection
