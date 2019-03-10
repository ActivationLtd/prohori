<hr/>
<?php
$no_purchases_recommends_last_ten_days = [];//define blank array
/* get all published brands order by name in ascending*/
$tasks = \App\Task::where('is_active',1)->orderBy('name','ASC')->get();
/* change no Recommendion Purchase Last Days  value from @var $days_before */
$days_before = 10;
$date = \Carbon\Carbon::today()->subDays($days_before);
foreach ($tasks as $task) {
            /* brand wise  array created for no recommendation or purchase in last X days */
            $no_purchases_recommends_last_ten_days[] = array(
                'task'                 => $task->name,
                'created_at'   => isset($task->created_at) ? date('Y-m-d H:i:s',strtotime($task->created_at)) : 'No Task Created',
                'last_update'         => isset($task->updated_at) ? date('Y-m-d H:i:s',strtotime($task->updated_at)) : 'No Task Updated',
            );

        }
?>
<div class="row">
    <div class="col-md-12">
        <h5>Tasks for last {{$days_before}} days</h5>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Task</th>
                <th scope="col">Created At</th>
                <th scope="col">Last Update</th>
            </tr>
            </thead>
            <tbody>
            <!--  loop through array for creating rows in a table -->
            @forelse($no_purchases_recommends_last_ten_days as $key => $no_p_r_l_ten_days)
            <tr>
                <th scope="row">{{ ++$key }}</th>
                <td>{{ $no_p_r_l_ten_days['task'] }}</td>
                <td>{{ $no_p_r_l_ten_days['created_at'] }}</td>
                <td>{{ $no_p_r_l_ten_days['last_update'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4"><center>No Data Found</center></td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>