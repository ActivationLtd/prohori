@extends('emails.templates.letsbab-default')

@section('email-content-header')
    Welcome to LetsBab
@endsection

@section('email-content')
    <h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#fff; line-height:30px; margin:0px 0 25px 0; padding:0px; font-weight:normal; ">
        Hi {{ isset($user->name) ? ucfirst($user->name) : "" }}, <br/><br/>
        Thanks for downloading LetsBab. Why not use the app to recommend gifts for
        the holiday season?

        <span style="margin:0 0 25px 0;">Follow the 5 steps to get started.</span>
    </h2>

    <img src="https://s3.us-east-2.amazonaws.com/letsbab/cdn/images/mobiles.png"
         alt=""
         style="width:100%; border:none;">
@endsection