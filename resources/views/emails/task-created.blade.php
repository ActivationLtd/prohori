@extends('emails.templates.prohori-default')

@section('email-content-header')
    A new task- {{$task->name}} created
@endsection

@section('email-content')
    <h2 style="font-family:Arial, Helvetica, sans-serif;  font-size:20px; color:#000; line-height:30px; margin:0px 0 25px 0; padding:0px; font-weight:normal; ">
        Hi {{$task->assignee->name}}<br>
        A new task has been assigned to u -{{$task->name}} of the client - {{$task->client_name}}<br/><br/>
        Thanks
    </h2>
@endsection