<?php
/** @var \App\Task $task */
//$subtasks = $task->subtasks()->orderBy('seq', 'ASC')->get();

?>
<h5>Add Assigned Location</h5>
<div class="clearfix"></div>
<form name="assignedlocationform" id="assignedlocationform" method="post"
      action="{{route('assignedlocations.store')}}">
    @csrf
    <input type="hidden" name="user_id" value="{{$user->id}}"/>
    <input type="hidden" name="is_active" value="1"/>
    <input type="hidden" name="ret" value="json"/>
    {{--client_id--}}
    @include('form.select-model', ['var'=>['name'=>'client_id','label'=>Lang::get('messages.Client'),'query'=> new \App\Client,'container_class'=>'col-md-4']])
    {{-- clientlocation_id --}}
    @include('form.select-model', ['var'=>['name'=>'clientlocation_id','label'=>Lang::get('messages.Location'),'query'=> new \App\Clientlocation,'container_class'=>'col-md-4']])
    <div class="clearfix"></div>
    @include('form.input-text',['var'=>['name'=>'from','label'=>'From', 'container_class'=>'col-sm-4','params'=>['id'=>'from']]])
    @include('form.input-text',['var'=>['name'=>'till','label'=>'Till', 'container_class'=>'col-sm-4','params'=>['id'=>'till']]])
    <div class="clearfix"></div>
    <button id="assignedlocationformSubmitBtn" class="btn btn-default" type="submit"><i class="fa fa-plus"></i>
        Add
    </button>
</form>
<div class="clearfix"></div>
<div id="add-assigned-location-vue">
    <table class="table table-condensed no-border" style="margin-bottom:0px;">
        <tbody v-if="assignedLocations.length > 0">
        <tr v-for="assignedLocation in assignedLocations">
            <td>
                <a :href="makeFileEditUrl(assignedLocation.id)">@{{ assignedLocation.name }}</a>

            </td>
            <td>
                @if(user()->isSuperUser())
                    <button name="genericDeleteBtn" type="button" class="btn btn-danger btn-xs flat"
                            data-toggle="modal" data-target="#deleteModal"
                            :data-route="makeDeleteUrl(assignedLocation.id)"
                            data-redirect_success='{{URL::full()}}' data-redirect_fail="">
                        Remove
                    </button>
                @endif
            </td>
        </tr>
        </tbody>
        <tbody v-else>
        <tr>
            <td colspan="7">No entry found</td>
        </tr>
        </tbody>
    </table>
</div>