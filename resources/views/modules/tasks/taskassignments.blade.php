<div class="clearfix"></div>
<table class="table">
    <thead>
    <tr>
        <th>Assignments</th>
        <th>Assigned to</th>
        <th>Assigned By</th>
        <th>Assigned For Days</th>
        <th>Go to assignment</th>
    </tr>
    </thead>
    @foreach($task->assignments()->orderBy('created_at','ASC')->get() as $assignment)
        <?php
        /** @var $subtask \App\Task */
        ?>
        <tbody>
        <tr>
            <td>{{$assignment->name}}</td>
            <td>{{$assignment->assignee->email}}</td>
            <td>{{$assignment->assigner->email}}</td>
            <td>{{$assignment->assigned_for_days}}</td>
            <td><a href="{{route('assignments.edit',$assignment->id)}}">Edit</a></td>
        </tr>
        </tbody>
    @endforeach
</table>
