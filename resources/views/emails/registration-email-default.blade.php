@extends('emails.templates.prohori-default')

@section('email-content-header')
    Default Registration email
@endsection

@section('email-content')
    <h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#000; line-height:30px; margin:0 0 25px 0; padding:0; font-weight:normal; ">
        Update contents here
        <a href="{{$email_verification_url}}">{{$email_verification_url}}</a>
    </h2>
@endsection