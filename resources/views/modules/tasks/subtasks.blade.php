<div class="clearfix"></div>
<table class="table">
    <thead>
    <tr>
        <th>Task</th>
        <th>Assigned to</th>
        <th>Edit</th>
    </tr>
    </thead>
    @foreach($task->subtTasks()->orderBy('seq','ASC')->get() as $subtask)
        <?php
        /** @var $subtask \App\Task */
        ?>
        <tbody>
        <tr>
            <td>{{$subtask->name}}</td>
            <td>{{$subtask->assignee->email}}</td>
            <td><a href="{{route('tasks.edit',$subtask->id)}}">Edit</a></td>
        </tr>
        </tbody>
    @endforeach
</table>

<a class="btn pull-left  btn-default"
   href="{{route('tasks.create')}}?parent_id={{$task->id}}&redirect_success={{URL::full()}}">Create
    new</a>