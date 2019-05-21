<?php
/** @var \App\Task $task */
$subtasks = $task->subtasks()->orderBy('seq', 'ASC')->get();

?>

<div class="clearfix"></div>
<span class="btn btn-success btn-xs" id="paragraphSeqUpdateMsg" style="display: none"></span>
@if(count($subtasks))
    <form method="POST" action="{{route('subtasks.save-sequence')}}" name="subtaskSeqUpdate">
        <input name="redirect_common" type="hidden" value="json"/>
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        <table class="table table-condensed">
            <thead>
            <tr>
                <th>Sequnce</th>
                <th>Task</th>
                <th>Assigned to</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody id="sortable">
            <?php $row = 1; ?>
            @foreach($subtasks as $subtask)
                <tr>
                    <td style="vertical-align: top; width: 20px;">
                        {{$row++}}.<input name="seq[]" type="hidden" value="{{$subtask->id}}"/>
                    </td>
                    <td>{{$subtask->name}}</td>
                    <td>{{$subtask->assignee->email}}</td>
                    <td><a href="{{route('tasks.edit',$subtask->id)}}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
@endif
@if(!in_array($task->status,['Closed','Done']))
    <a class="btn pull-left  btn-default"
       href="{{route('tasks.create')}}?parent_id={{$task->id}}&redirect_success={{URL::full()}}">Create</a>
@endif
@section('js')
    @parent
    <script>
        enableAjaxQuestionSort();

        /**
         *  enable event handling for sortable items. An ajax post is triggered.
         */
        function enableAjaxQuestionSort() {
            $("#sortable").sortable({
                update: function (event, ui) {
                    $.ajax({
                        datatype: 'json',
                        method: "POST",
                        url: $('form[name=subtaskSeqUpdate]').attr('action'),
                        data: $('form[name=subtaskSeqUpdate]').serialize()
                    }).done(function (ret) {
                        ret = parseJson(ret);
                        if (ret.status == 'success') {
                            $('#paragraphSeqUpdateMsg').html(ret.message).show().fadeOut(2000);
                            //alert('sequence is updated')
                        }
                    });
                }
            });
        }

<<<<<<< HEAD
@if(!in_array($task->status,['Closed','Done']))
    <a class="btn pull-left  btn-default" href="{{route('tasks.create')}}?parent_id={{$task->id}}&redirect_success={{URL::full()}}">Create</a>
@endif
=======
        //$("#sortable").sortable();
    </script>
@stop
>>>>>>> master
