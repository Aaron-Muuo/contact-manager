@extends('layouts.auth')

@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Contact Manager App</b></a>
    </div>
    <!-- /.register-logo -->
    <div class="card">
        <div class="card-body register-card-body">
            <p class="register-box-msg">Create a new account 🎉</p>
            <form method="POST" action="{{ route('signup.create') }}">
                @csrf
                @method('POST')
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('name') border-danger @enderror" placeholder="Full Name" name="name" value="{{old('name')}}" />
                    <div class="input-group-text"><span class="bi bi-person"></span></div>
                </div>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') border-danger @enderror" placeholder="Email" name="email" value="{{old('email')}}"/>
                    <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                </div>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('phone') border-danger @enderror" placeholder="Phone" name="phone" value="{{old('phone')}}"/>
                    <div class="input-group-text"><span class="bi bi-phone"></span></div>
                </div>
                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password') border-danger @enderror" placeholder="Password" name="password" value="{{old('password')}}"/>
                    <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                </div>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password_confirmation') border-danger @enderror" placeholder="Confirm Password" name="password_confirmation" />
                    <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                </div>
                @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                <!--begin::Row-->
                <div class="row">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                            <label class="form-check-label" for="flexCheckDefault">
                                I agree to the <a href="#">terms and conditions</a> and <a href="#">privacy policy</a>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Create Account</button>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!--end::Row-->
            </form>
            <div class="social-auth-links text-center mb-3 d-grid gap-2">
                <p class="mb-0">- OR -</p>

                <a href="#" class="btn btn-danger">
                    <i class="bi bi-google me-2"></i> Sign in using Google
                </a>
            </div>
            <!-- /.social-auth-links -->
            <p class="mb-0 text-center">
                <a href="{{route('login')}}" class="text-center"> I already have an account </a>
            </p>
        </div>
        <!-- /.register-card-body -->
    </div>
</div>
<!-- /.register-box -->

@endsection
