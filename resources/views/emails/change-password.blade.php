@extends('emails.templates.letsbab-default')

@section('email-content-header')
Your password has been reset.
@endsection

@section('email-content')
    <h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#fff; line-height:30px; margin:0px 0 25px 0; padding:0px; font-weight:normal;">
    	Dear {{ isset($user->name) ? ucwords($user->name) : "" }},
        <br />
        <br />
        Your LetsBab password has been successfully reset.	
        <br />
        <br />
        If you did not make this change or you beleive an unauthorised person has accessed your account, go to <a href="{{ App\Setting::read('unauth-reset-pass-url')}}" target="_blank" style="color:#fff;">{{ App\Setting::read('unauth-reset-pass-url') }}</a> to reset your password without delay.If you need additional help,please contact letshelp@letsbab.com.
        <br />
        <br />
        LetsBab Community 
    </h2>
@endsection