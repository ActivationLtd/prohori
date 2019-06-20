@extends('emails.templates.prohori-default')

@section('email-content-header')
    A Task for - <a href="{{route('tasks.edit',$task->id)}}"><b>{{$task->tasktype_name}}</b></a> Created
@endsection

@section('email-content')
    <p>
        Hello {{$task->assignee->name}},</p>
    <p>
        A new task - {{$task->name}} for the client - {{$task->client_name}} has been created and assigned to
        {{$task->assignee->name}}.
        <br>
    </p>
    <br>
    <table border="1" cellspacing="0" cellpadding="2" style="text-align:left;">
        <tr>
            <td width="150px" >Task Name</td>
            <td width="150px">Client Name</td>
            <td width="100px">Client Location</td>
            <td>Priority</td>
            <td width="100px">Due date</td>
            <td width="60px">Status</td>
            <td width="100px">Assigned to</td>
        </tr>
        <tr>
            <td width="150px" style="text-align:center;"><a href="{{route('tasks.edit',$task->id)}}">{{$task->name}}</a>
            </td>
            <td width="150px" >{{$task->client_name}}</td>
            <td width="100px">{{$task->clientlocation_name}}</td>
            <td >{{$task->priority_name}}</td>
            <td width="100px">{{$task->due_date}}</td>
            <td width="60px" >{{$task->status}}</td>
            <td width="100px">{{$task->assignee->name}}</td>
        </tr>
    </table>
    <br>
    <a href="{{route('tasks.edit',$task->id)}}">Click</a> here for further details .

@endsection