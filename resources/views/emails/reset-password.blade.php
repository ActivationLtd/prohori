@extends('emails.templates.letsbab-default')

@section('email-content-header')
Forgotten your Password?
@endsection

@section('email-content')
    <h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#fff; line-height:30px; margin:0px 0 25px 0; padding:0px; font-weight:normal;">
    	<a href="{{$password_reset_url}}" target="_blank" style="color:#fff;">Click here</a> to reset your password and get back to LetsBab.
        <br />
        <br />
        The LetsBab Team.
    </h2>
@endsection