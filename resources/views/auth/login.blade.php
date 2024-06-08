@extends('layouts.app')

@section('content')



<div class="section-authentication-cover">
    <div class="">
        <div class="row g-0">

            <div
                class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">

                <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
                    <div class="card-body">
                        <img src="{{asset('assets/backend/images/login-cover.svg')}}" 
                            width="900" alt="" />
                    </div>
                </div>

            </div>

            <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
                    <div class="card-body p-sm-5">
                        <div class="">
                            <div class="mb-3 text-center">
                                <img src="assets/backend/images/login-cover.svg" width="60" alt="">
                            </div>
                            <div class="text-center mb-4">
                                <h6 class="">{{ $title ?? '' }} {{ env('APP_NAME') }}</h6>
                                <hr>
                                <p class="mb-0">Please log in to your account</p>
                            </div>
                            <div class="form-body">


                                @isset($route)
                                    <form class="row g-3" method="POST" action="{{ $route }}">
                                    @else
                                        <form class="row g-3" method="POST" action="{{ route('login') }}">
                                        @endisset
                                        @csrf

                                        <div class="col-12">
                                            <label for="inputusernameAddress" class="form-label">Username</label>
                                            <input type="text" name="username"
                                                class="form-control @error('username') is-invalid @enderror"
                                                id="inputusernameAddress" placeholder="enter your Username">
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label for="inputChoosePassword" class="form-label">Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password"
                                                    class="form-control border-end-0 @error('password') is-invalid @enderror"
                                                    id="inputChoosePassword" name="password"
                                                    placeholder="Enter Password"> <a href="javascript:;"
                                                    class="input-group-text bg-transparent"><i
                                                        class="bx bx-hide"></i></a>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">Remember Me</label>

                                            </div> --}}

                                            @if (Route::has('password.request'))
                                            {{--<a href="{{ route('password.request') }}">
                                                {{ __('Forgot Password ?') }}
                                            </a>--}}
                                        @endif
                                        </div>
                                        {{-- <div class="col-md-6 text-end">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}">
                                                    {{ __('Forgot Password ?') }}
                                                </a>
                                            @endif

                                        </div> --}}
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary">Sign in</button>
                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="text-center ">
                                                <p class="mb-0">Don't have an account yet? <a
                                                        href="authentication-signup.html">Sign up here</a>
                                                </p>
                                            </div>
                                        </div> --}}
                                    </form>
                            </div>
                            {{-- <div class="login-separater text-center mb-5"> <span>OR SIGN IN WITH</span>
                                <hr>
                            </div>
                            <div class="list-inline contacts-social text-center">
                                <a href="javascript:;"
                                    class="list-inline-item bg-facebook text-white border-0 rounded-3"><i
                                        class="bx bxl-facebook"></i></a>
                                <a href="javascript:;"
                                    class="list-inline-item bg-twitter text-white border-0 rounded-3"><i
                                        class="bx bxl-twitter"></i></a>
                                <a href="javascript:;"
                                    class="list-inline-item bg-google text-white border-0 rounded-3"><i
                                        class="bx bxl-google"></i></a>
                                <a href="javascript:;"
                                    class="list-inline-item bg-linkedin text-white border-0 rounded-3"><i
                                        class="bx bxl-linkedin"></i></a>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end row-->
    </div>
</div>




























{{-- old  --}}




 
@endsection


