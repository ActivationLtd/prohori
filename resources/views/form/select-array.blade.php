<?php
/**
 * @var array $var A temporary variable, that is set only to render the view partial. Usually this view
 *                 file is included inside a form.
 * @var $errors    \Illuminate\Support\MessageBag
 */

/** Common view parameters for form elements */
$var['container_class'] = $var['container_class'] ?? '';
$var['name'] = $var['name'] ?? 'NO_NAME';
$var['params'] = $var['params'] ?? [];
$var['params']['class'] = (isset($var['params']['class'])) ? $var['params']['class'] . " form-control " : ' form-control ';
$var['value'] = $var['value'] ?? '';
$var['label'] = $var['label'] ?? '';
$var['label_class'] = $var['label_class'] ?? '';
$var['old_input'] = oldInputValue($var['name'], $var['value']);
if (!isset($var['editable'])) {
    $var['editable'] = (isset($element_editable) && $element_editable == false) ? false : true;
}
if ($var['editable'] == false) $var['params']['disabled'] = true;

/** Custom parameters */
$var['options'] = (isset($var['options'])) ? $var['options'] : [];
$var['multiple'] = (array_search('multiple', $var['params']) !== false) ? true : false; // multiple: Store a flag if multiple selection is provided $var['params']
$var['name_transformed'] = ($var['multiple']) ? $var['name'] . "[]" : $var['name'];  // Add [] after name if multiple selection
?>

{{-- HTML for the input/select block --}}
<div class="form-group {{$errors->first($var['name'], ' has-error')}} {{$var['container_class']}}">
    {{-- show label if label if available --}}
    @if(strlen(trim($var['label'])))
        <label id="label_{{$var['name']}}"
               class="control-label {{$var['label_class']}}"
               for="{{$var['name']}}">
            {{$var['label']}}
        </label>
    @endif

    {{ Form::select($var['name_transformed'], $var['options'], $var['old_input'], $var['params']) }}
    {!! $errors->first($var['name'], '<span class="help-block">:message</span>') !!}
</div>

<?php
#------------------------------------------------------------------
// Unset the local variable used in this view.
#------------------------------------------------------------------
unset($var);?>