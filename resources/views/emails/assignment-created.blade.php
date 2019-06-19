@extends('emails.templates.prohori-default')

@section('email-content-header')
    A Task for - <b>{{$assignment->task->tasktype_name}}</b> has been assigned.
@endsection

@section('email-content')
    <p>
        Hello {{$assignment->assignee->name}},</p>
    <p>
        A new task - {{$assignment->task->name}} for the client - {{$assignment->task->client_name}} has been assigned to
        {{$assignment->task->assignee->name}}.
        <br>
        The task location is {{$assignment->task->clientlocation_name}} and it is due in {{$assignment->task->due_date}}.
        <br>
        <a href="{{route('tasks.edit',$assignment->task->id)}}">Click</a> here for further details .
    </p>
@endsection