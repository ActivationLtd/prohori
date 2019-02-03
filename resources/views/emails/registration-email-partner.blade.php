@extends('emails.templates.letsbab-default')

@section('email-content-header')
    Partner Registration email
@endsection

@section('email-content')
    <h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#fff; line-height:30px; margin:0 0 25px 0; padding:0; font-weight:normal; ">
        Update contents here
        <a href="{{$email_verification_url}}">{{$email_verification_url}}</a>
    </h2>
@endsection