<?php
use App\Task;

$tasks = Task::where('is_active', 1)->orderBy('created_at', 'asc')->get();
?>

<div class="col-md-12"><h4>Current tasks</h4></div>
<table class="table datatable-min">
    <thead>
    <tr>
        <th style="width: 30px;"></th>
        <th>Task</th>
        <th>Assignee</th>
        <th>Status</th>
        <th>Created</th>
    </tr>
    </thead>
    <tbody>
    <!--  loop through array for creating rows in a table -->
    @foreach($tasks as $task)
        <?php
        /** @var $task \App\Task */
        ?>
        <tr>
            <td>
            <span style="height: 40px; width: 40px; overflow: hidden; float: left">
                <img style="width: 100%" src="{{asset($task->assignee->profile_pic_url)}}" alt="#"/>
            </span>
            </td>
            <td>
                <b><a href="{{route('tasks.edit',$task->id)}}">{{ $task->tasktype->name }}</a></b>
            </td>
            <td>
                {{ $task->assignee->email }}
            </td>
            <td>
                <code>{{ $task->status }}</code>
            </td>
            <td>
                {{ $task->created_at }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
