@extends('emails.templates.prohori-default')

@section('email-content-header')
    Prohori - <b>Alert</b> - Unresolved Tasks
@endsection

@section('email-content')
    Dear All <br>
    Unresolved Tasks list for Prohori<br/>
    <table border="1" cellspacing="0" cellpadding="2" style="text-align:left;">
        <thead>
        <tr>
            <th>Sequnce</th>
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
                <td width="300px">{{$task->name}}</td>
                <td>{{$task->assignee->email}}</td>
                <td width="100px">{{$task->due_date}}</td>
                <td width="60px"><a
                            href="{{route('tasks.edit',$task->id)}}">{{$task->status}}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br/><br/>
    Thanks You
@endsection