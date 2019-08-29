@extends('layouts.app')

@section('content')
    <div class="row align-items-md-center h-100-vh">
        <div class="col-lg-6 d-none d-lg-block">
            <img class="img-fluid" src="http://gramos.laborasyon.com/assets/media/svg/login.svg" alt="...">
        </div>
        <div class="col-lg-4 offset-lg-1">
            <div class="d-flex align-items-center m-b-20">
                <img src="assets/media/image/light-logo-2.png" class="m-r-15" width="40" alt="">
                <h3 class="m-0">Bullish Admin</h3>
            </div>
            <p>Sign in to continue.</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group mb-4">
                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="exampleInputPassword1" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block btn-uppercase mb-4">Sign In</button>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">Keep me signed in</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-link text-black">Forgot password?</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
