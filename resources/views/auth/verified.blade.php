@extends('template.auth-frame')

@section('content')
    <div class="card-body text-center">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('Your email has been verified.') }}
            </div>
        @endif
        {{ __('Your email has been verified.') }}.
    </div>
@endsection
