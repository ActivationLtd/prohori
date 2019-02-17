@extends('emails.templates.prohori-default')

@section('email-content-header')
Email updated
@endsection

@section('email-content')
<h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#fff; line-height:30px; margin:0px 0 25px 0; padding:0px; font-weight:normal; ">
    You updated your email to {{ isset($user->email) ? $user->email : "" }}.
    <br />
	<br />
	One more step... 
	<br />
	<br />
	Please verify your email address by <a href="{{$email_verification_url}}" target="_blank" style="color:#fff;">clicking the link</a>.
	<br />
	<br />
	If you did not make this change or you beleive an unauthorised person has accessed your account,please contact letshelp@prohori.com.
	<br />
	<br />
	The prohori Team
</h2>
@endsection