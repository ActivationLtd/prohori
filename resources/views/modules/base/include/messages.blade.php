<?php
/**
 * @var $mod Module
 * @var $var array
 */
$rand = randomString();

/** View parameters */
$var['module_id'] = $var['module_id'] ?? $mod->id;
$var['module_name'] = $var['module_name'] ?? $mod->name;
$var['element_id'] = $var['element_id'] ?? null;
$var['element_uuid'] = $var['element_uuid'] ?? null;
$var['type'] = $var['type'] ?? null;
$var['limit'] = $var['limit'] ?? 999;
$var['container_class'] = $var['container_class'] ?? ''; // container_class: main wrapper div class.
/** Internal variables */
$var['tenant_id'] = tenantUser() ? userTenantId() : null;
$var['message_container_id'] = "message_container_" . $rand;

/** Parameter value overrides */

// If an $element is present (normally during edit) in the context then set tenant_id and element
// fields based on that element.
if ((isset($element) && isset($$element))) {
    $var['element_id'] = $var['element_id'] ? $var['element_id'] : $$element->id;
    $var['element_uuid'] = $var['element_uuid'] ? $var['element_uuid'] : $$element->uuid;
    // If still there is no tenant_id resolved from user, attempt to resolve from $element.
    $var['tenant_id'] = (!$var['tenant_id'] && isset($$element->tenant_id)) ? $$element->tenant_id : $var['tenant_id'];

} else {
    // During creation when element is not ready but $uuid is generated.
    $var['element_uuid'] = (!$var['element_uuid'] && isset($uuid)) ? $uuid : $var['element_uuid'];
}

?>

{{-- message div + form --}}
<div class="{{$var['container_class']}}">
    @if(hasModulePermission($mod->name,'create') || hasModulePermission($mod->name,'edit'))
        {{-- A form where values are stored that are later posted with attached file --}}
        {{-- initmessageer gets these values and post to uplaod route  --}}
        <div id="{{$var['message_container_id']}}" class="messages_container">
            <form method="post" action="{{route('messages.store')}}">
                {{csrf_field()}}
                {{--<input type="hidden" name="ret" value="json"/>--}}
                <input type="hidden" name="tenant_id" value="{{$var['tenant_id']}}"/>
                <input type="hidden" name="module_id" value="{{$var['module_id']}}"/>
                <input type="hidden" name="element_id" value="{{$var['element_id']}}"/>
                <input type="hidden" name="element_uuid" value="{{$var['element_uuid']}}"/>
                <input type="hidden" name="redirect_success" value="{{URL::full()}}"/>
                    <textarea class="form-control col-md-6" name="body"></textarea>
                <button type="submit" class="btn btn-default">Post</button>
            </form>
        </div>
    @endif

    {{-- message list --}}
    @if($var['module_id'] && $var['element_id'])
        <?php
        $q = \App\Message::where('module_id', $var['module_id'])
            ->where('element_id', $var['element_id'])->whereNull('deleted_at');
        $q = $q->orderBy('created_at', 'DESC');
        $messages = $q->offset(0)->take($var['limit'])->get();
        ?>
        <div class="clearfix">
            {{-- message list --}}
            @if(count($messages))
                @include('modules.base.include.messages-list-default',$messages)
            @endif
        </div>
    @endif
</div>

{{-- js --}}
@section('js')
    @parent
@endsection

<?php unset($var, $q, $messages); ?>


