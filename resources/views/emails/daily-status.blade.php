
@extends('emails.templates.prohori-default')

@section('email-content-header')
    Prohori - <b>Alert</b> - Unresolved Tasks
@endsection

@section('email-content')
    Dear All <br>
    Unresolved Tasks list for Prohori<br/>
        <table class="table table-condensed border">
            <thead>
            <tr>
                <th>Sequnce</th>
                <th>Task</th>
                <th>Assigned to</th>
                <th>Due date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody id="sortable">
            <?php $row = 1; ?>
            @foreach($tasks as $task)
                <tr>
                    <td style="vertical-align: top; width: 20px;">
                        {{$row++}}
                    </td>
                    <td>{{$task->name}}</td>
                    <td>{{$task->assignee->email}}</td>
                    <td>{{$task->due_date}}</td>
                    <td><a href="{{route('tasks.edit',$task->id)}}">$task->status</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    <br/><br/>
    Thanks
@endsection