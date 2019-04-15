<?php
use App\Task;

$tasks = Task::where('is_active', 1)->orderBy('created_at', 'desc')->get();
?>

<div class="col-md-12"><h4>Current tasks</h4></div>
<table class="table shadow datatable-min">
    <thead>
    <tr>
        <th style="width: 30px;"></th>
        <th>Task</th>
        <th>Assignee</th>
        <th>Status</th>
        <th>Time</th>
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
            <span style="height: 40px; overflow: hidden">
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
                {{ $task->created_at->diffForHumans() }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
 