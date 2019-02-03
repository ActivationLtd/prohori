<?php
/**
 * @var array $var A temporary variable, that is set only to render the view partial. Usually this view
 *                 file is included inside a form.
 * @var $errors    \Illuminate\Support\MessageBag
 * @var Illuminate\Database\Query\Builder $query
 */

/** Common view parameters for form elements For details of the fields see app/views/spyr/form/input-text.blade.php */
$var['container_class'] = (isset($var['container_class'])) ? $var['container_class'] : 'col-sm-3';
$var['name'] = (isset($var['name'])) ? $var['name'] : 'NO_NAME';
$var['params'] = (isset($var['params'])) ? $var['params'] : [];
$var['params']['class'] = (isset($var['params']['class'])) ? $var['params']['class'] . " form-control " : ' form-control ';
$var['value'] = (isset($var['value'])) ? $var['value'] : '';
$var['label'] = (isset($var['label'])) ? $var['label'] : '';
$var['label_class'] = (isset($var['label_class'])) ? $var['label_class'] : '';
$var['blank_select'] = (isset($var['blank_select'])) ? $var['blank_select'] : 'Select';
$var['old_input'] = oldInputValue($var['name'], $var['value']);
$var['cache_time'] = (isset($var['cache_time'])) ? $var['cache_time'] : 'short';

if (!isset($var['editable'])) {
    $var['editable'] = (isset($element_editable) && $element_editable == false) ? false : true;
}
if ($var['editable'] == false) $var['params']['disabled'] = true;

/** Custom parameters */
$var['multiple'] = (array_search('multiple', $var['params']) !== false) ? true : false; // multiple: Store a flag if multiple selection is provided $var['params']

/** Query construction */
$query = (!isset($var['query'])) ? DB::table($var['table']) : $var['query'];
$var['name_field'] = (isset($var['name_field'])) ? $var['name_field'] : 'name'; // name_field: Column of the table that will be shown as the readable name of the option for user. Usually this field is a text field. i.e. name, name_ext. Default is 'name'.
$var['value_field'] = (isset($var['value_field'])) ? $var['value_field'] : 'id'; // value_field: Column of the table that will be used for the value that will be actually posted. Usually this field is an id field. Default is 'id'.

$query = $query->select([$var['name_field'], $var['value_field']])->whereNull('deleted_at')->where('is_active', 1);

if (userTenantId() && tableHasColumn($var['table'], tenantIdField())) {
    $query = $query->where(tenantIdField(), userTenantId());
}
// Get the name value pair
$pairs = cachedResult($query, cacheTime($var['cache_time']));

/** Prepare options */
$options = [];
if (!$var['multiple'])
    $options = ['' => $var['blank_select']];

$selections = [];
if (count($pairs)) {
    $v = $var['value_field'];
    $n = $var['name_field'];

    foreach ($pairs as $pair) {
        $options[$pair->$v] = $pair->$n;

        if (is_array($var['old_input'])) {
            if (in_array($pair->$v, $var['old_input'])) {
                $selections[$pair->$v] = $pair->$n;
            }
        } else {
            if ($pair->$v == $var['old_input']) {
                $selections[$pair->$v] = $pair->$n;
            }
        }

    }

}


?>

{{-- HTML for the input/select block --}}
<div class="form-group {{$errors->first($var['name'], ' has-error')}} {{$var['container_class']}}">
    @if(strlen(trim($var['label'])))
        <label id="label_{{$var['name']}}" class="control-label {{$var['label_class']}}"
               for="{{$var['name']}}">{{$var['label']}}
        </label>
    @endif
    <?php $var['select_name'] = ($var['multiple']) ? $var['name'] . "[]" : $var['name']; ?>
    {{ Form::select($var['select_name'], $options, $var['old_input'], $var['params']) }}
    {!! $errors->first($var['name'], '<span class="help-block">:message</span>')  !!}

</div>

{{-- Unset the local variable used in this view. --}}
<?php unset($var, $pairs, $options, $query, $selections) ?>