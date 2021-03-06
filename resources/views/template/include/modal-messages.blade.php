{{-- Message modal shows all ajax messages during model save/update etc. Messages are fetched from Session--}}
<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="msgModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Message</h4>
            </div>

            <div class="modal-body">
                <div id="msgSuccess" class="ajaxMsg callout callout-success"></div>
                <div id="msgError" class="ajaxMsg callout callout-danger"></div>
                <div id="msgMessage" class="ajaxMsg callout callout-warning"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>