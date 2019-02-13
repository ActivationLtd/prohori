@extends('emails.templates.prohori-default')

@section('email-content-header')
Welcome to prohori
@endsection

@section('email-content')
<h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#fff; line-height:30px; margin:0px 0 25px 0; padding:0px; font-weight:normal; ">
    Hi {{ isset($user->name) ? ucwords($user->name) : "" }},
    <br />
	<br />
	Thanks for downloading prohori. One more step...
	<br />
	<br />
	Please verify your email address by <a href="{{$email_verification_url}}" target="_blank" style="color:#fff;">clicking the link</a>.
</h2>

@endsection