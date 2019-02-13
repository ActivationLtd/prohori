@extends('emails.templates.prohori-default')

@section('email-content-header')
    Welcome to prohori
@endsection

@section('email-content')
    <h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#fff; line-height:30px; margin:0px 0 25px 0; padding:0px; font-weight:normal; ">
        Hi {{ isset($user->name) ? ucfirst($user->name) : "" }}, <br/><br/>
        Thanks for downloading prohori.
    </h2>
@endsection