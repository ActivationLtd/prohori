<?php
$tasks = \App\Task::where('is_active', 1)->where('assigned_to',user()->id)->orWhere('created_by',user()->id)->orderBy('created_at', 'desc')->get();
?>

<b>Currently assigned</b>
<table class="table shadow">
    <tbody>
    <!--  loop through array for creating rows in a table -->
    @foreach($tasks as $task)
        <?php
        /** @var $task \App\Task */
        ?>
        <tr>
            <td style="width: 50px;">
            <span style="height: 50px; overflow: hidden">
                <img style="width: 100%" src="{{asset($task->assignee->profile_pic_url)}}"/>
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
