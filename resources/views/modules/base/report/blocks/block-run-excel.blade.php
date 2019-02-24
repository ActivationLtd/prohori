<div class="btn-group pull-left ">
    <button type="submit" name="submit" class="btn btn-success" value="Run">Run report</button>
    @if(Request::has('submit'))
        <a target="_blank" class="btn btn-default" type="button" href="<?php echo URL::full()?>&ret=excel"
           title="Export to Excel"><i class="fa fa-file-text" title="Export to Excel"></i></a>
        <a target="_blank" class="btn btn-default" href="<?php echo URL::full()?>&view=print">
            <i class="fa fa-print"
               title="Print"></i></a>
        @if(Request::has('submit') && hasPermission('reports.create'))
            <?php
            // $report_save_url = route('reports.create');
            $report_save_url = route('reports.create');
            $report_save_url .= "?title=" . Request::get('report_name');
            //         $report_save_url .= "&code=" . Route::getCurrentRoute()->getParameter('code');
            $report_save_url .= "&module_id=" . $mod->id;
            ?>
            <?php
            $generic_url = str_replace(route('home'), '', URL::full());
            $report_save_url .= "&parameters=" . urlencode($generic_url);
            ?>
            <a target="_blank" class="btn btn-default" href="{{$report_save_url}}"><i class="fa fa-save"
                                                                                      title="Save Report"></i>

            </a>

            <h4>{{Request::get('report_name')}}</h4>

        @endif
    @endif
</div>