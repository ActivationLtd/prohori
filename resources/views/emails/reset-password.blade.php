@extends('emails.templates.prohori-default')

@section('email-content-header')
Forgotten your Password?
@endsection

@section('email-content')
    <h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#000; line-height:30px; margin:0px 0 25px 0; padding:0px; font-weight:normal;">
    	<a href="{{$password_reset_url}}" target="_blank" style="color:#fff;">Click here</a> to reset your password and get back to prohori.
        <br />
        <br />
        The prohori Team.
    </h2>
@endsection