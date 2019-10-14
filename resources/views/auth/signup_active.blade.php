@extends('layouts.app')

@section('content')
    <div class="row align-items-md-center h-100-vh">
        <div class="col-lg-6 d-none d-lg-block">
            <img class="img-fluid" src="http://gramos.laborasyon.com/assets/media/svg/login.svg" alt="...">
        </div>
        <div class="col-lg-4 offset-lg-1">
            <div class="d-flex align-items-center m-b-20">
                <img src="assets/media/image/light-logo-2.png" class="m-r-15" width="40" alt="">
                <h3 class="m-0">Bullish ChatApp</h3>
            </div>
            @if(!$error)
                <p class="alert alert-warning">Your Account is already Activated. You can now use our Mobile Apps.</p>
            @else
                <p class="alert alert-success">Your Account is successfully confirmed & activated. Now you use our Mobile Apps.</p>
            @endif
        </div>
    </div>
@endsection
