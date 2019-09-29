@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $common->header }}</div>

                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        {{ $common->message }}
                    </div>
                    @if(isset($common->link))
                        <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
