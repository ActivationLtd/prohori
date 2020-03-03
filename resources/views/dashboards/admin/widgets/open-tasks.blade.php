<?php
use App\Task;

$tasks = Task::with(['assignee','clientlocation','tasktype'])->where('is_active', 1)
    ->orderBy('created_at', 'desc')
    ->whereIn('status', ['To do', 'In progress', 'Verify'])
    ->remember(cacheTime('medium'))->get();

$status_map=[
    'To do' => 'todo',
    'In progress'=>'inprogress',
    'Verify'=>'verify',
    'Done'=>'done',
    'Closed'=>'closed'
]
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
                <br>
                @if(isset($task->client->name))
                <b>{{ $task->client->name }}</b>
                @endif
                <br>
                @if(isset($task->clientlocation_name ))
                <b>{{ $task->clientlocation_name }}</b>
                @endif
            </td>
            <td>
                {{ $task->assignee->full_name }}
                <br>
                {{ $task->assignee->email }}
            </td>
            <td>
                <code class="status-{{$status_map[$task->status]}}"> {{ $task->status }}</code>
            </td>
            <td>
                {{ $task->created_at }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
