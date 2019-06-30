<?php
/**
 * Created by PhpStorm.
 * User: Activation
 * Date: 6/13/2016
 * Time: 2:18 PM
 */
/**
 * Transforms the values of a cell. This is useful for creating links, changing colors etc.
 * @param        $column
 * @param        $row
 * @param        $value
 * @param string $module_name
 * @return string
 */
function transformRow($column, $row, $value, $module_name = '') {
    //linked to facility details page
    $new_value = $value;
    if (in_array($column, ['id', 'name'])) {
        if (isset($row->id)) {
            $new_value = "<a href='" . route($module_name . '.edit', $row->id) . "'>" . $value . "</a>";
        }
    } else if (in_array($column, ['client_obj', 'clientlocation_obj'])) {
        if (isset($row->id)) {
            $data = json_decode($value);
            $new_value = $data->name;
        }
    } else if (in_array($column, ['watchers'])) {
        $emails = null;
        //todo have to find a better solution
        // the value comes as an string "["2","4","5"]"
        if (isset($row->id)) {
            if ($value) {
                $users = arrayFromCsv($value);
                foreach ($users as $user) {
                    //removing [ from array
                    if (strpos($user, '[') !== false) {
                        $user_id = trim($user, '[');
                    } //removing ] from array
                    else if (strpos($user, ']') !== false) {
                        $user_id = trim($user, ']');
                    }
                    //removing ' " ' from array
                    $user_id=trim($user_id,'"');
                    //finding user
                    $user=App\User::find($user_id);
                    if(isset($user))
                    $emails = $emails . $user->email.',';
                }
            }
        }
        $new_value = $emails;
    }

    return $new_value;
}

?>