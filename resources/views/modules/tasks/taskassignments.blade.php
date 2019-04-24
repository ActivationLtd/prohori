<div class="clearfix"></div>
<table class="table">
    <thead>
    <tr>
        <th>Assigned To</th>
        <th>Assigned By</th>
        <th>Duration</th>
        <th></th>
    </tr>
    </thead>
    @foreach($task->assignments()->orderBy('created_at','ASC')->get() as $assignment)
        <?php
        /** @var $subtask \App\Task */
        ?>
        <tbody>
        <tr>
            <td>{{$assignment->assignee->email}}</td>
            <td>{{$assignment->assigner->email}}</td>
            <td>{{$assignment->assigned_for_days}}</td>
            <td><a href="{{route('assignments.edit',$assignment->id)}}">View</a></td>
        </tr>
        </tbody>
    @endforeach
</table>
