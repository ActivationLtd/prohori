@extends('emails.templates.prohori-default')

@section('email-content-header')
    Prohori - <b>Alert</b> - Unresolved Tasks {{date("Y-m-d")}}
@endsection

@section('email-content')
    Dear All,<br>
    Unresolved Tasks list for Prohori<br/>
    <br/>
    <table border="1" cellspacing="0" cellpadding="2" style="text-align:left;">
        <thead>
        <tr>
            <th>S/L</th>
            <th width="300px">Task</th>
            <th>Assigned to</th>
            <th width="100px">Due date</th>
            <th width="60px">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php $row = 1; ?>
        @foreach($tasks as $task)
            <tr>
                <td>{{$row++}}</td>
                <td width="300px"><a
                            href="{{route('tasks.edit',$task->id)}}">{{$task->name}}</a></td>
                <td>{{$task->assignee->email}}</td>
                <td width="100px">{{$task->due_date}}</td>
                <td width="60px">{{$task->status}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br/><br/>
    Thanks You
@endsection