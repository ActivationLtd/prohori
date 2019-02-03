@extends('emails.templates.letsbab-default')

@section('email-content-header')
    Reset password
@endsection

@section('email-content')
    <h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#fff; line-height:30px; margin:0px 0 25px 0; padding:0px; font-weight:normal; ">
        Verify email

        <a href="{{$email_verification_url}}">{{$email_verification_url}}</a>
    </h2>
@endsection