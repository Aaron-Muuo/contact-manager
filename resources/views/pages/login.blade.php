@extends('layouts.auth')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Contact Manager App</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to your account</p>
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                @method('POST')
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('username') border-danger @enderror" placeholder="@username" name="username" value="{{old('username')}}"/>
                    <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                </div>
                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password') border-danger @enderror" placeholder="Password" name="password" value="{{old('password')}}"/>
                    <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                </div>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                <!--begin::Row-->
                <div class="row">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="remember" />
                            <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                        </div>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-1"><a href="#">Forgot password</a></p>
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!--end::Row-->
            </form>
            <div class="social-auth-links text-center mb-3 d-grid gap-2">
                <p class="mb-0">- OR -</p>

                <a href="#" class="btn btn-danger">
                    <i class="bi bi-google me-2"></i> Sign in using Google+
                </a>
            </div>
            <!-- /.social-auth-links -->

            <p class="mb-0 text-center">
                <a href="/signup" class="text-center"> Register a new membership </a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

@endsection
