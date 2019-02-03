<div class="btn-group pull-left ">
    <button type="submit" name="submit" class="btn btn-success" value="Run">Run report</button>
    @if(Request::has('submit'))
        <a target="_blank" class="btn btn-default" type="button" href="<?php echo URL::full()?>&ret=excel"
           title="Export to Excel"><i class="fa fa-file-text"
                                      title="Export to Excel"></i></a>
        <a target="_blank" class="btn btn-default" href="<?php echo URL::full()?>&view=print"><i class="fa fa-print"
                                                                                                 title="Print"></i></a>
    @endif
</div>