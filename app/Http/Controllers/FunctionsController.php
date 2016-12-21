<?php

namespace App\Http\Controllers;


trait FunctionsController
{
    /** Get specific settings with comparing type
     *  $params $settings
     *  $return array | bool
     */
    public function get_specific_settings($settings, $type = null)
    {
        if ($type == null) {
            return false;
        }
        if ($settings != null && !empty($settings)) {
            $settings_specific = array(array());
            foreach ($settings as $setting) {
                $id = $setting->id;
                $meta_key = $setting->meta_key;
                $meta_value = $setting->meta_value;;
                if ($setting->type == $type) {
                    $settings_specific[$meta_key]['id'] = $id;
                    $settings_specific[$meta_key]['type'] = $type;
                    $settings_specific[$meta_key]['meta_key'] = $meta_key;
                    $settings_specific[$meta_key]['meta_value'] = $meta_value;
                }
            }
            return $this->check_array_empty($settings_specific);
        } else {
            return false;
        }
    }

    /** Check an array exists and empty
     * @param $array_data
     * @return array | bool
     */
    public function check_array_empty($array_data)
    {
        if ($array_data != null && !empty($array_data)) {
            return $array_data;
        } else {
            return false;
        }
    }

    /** Categorized all parameters
     * @param $parameters
     * @return mixed
     */
    public function function_get_categorized_parameters($parameters){
        foreach($parameters as $parameter){
            $data['category_id'] = $parameter->category_id;
            $data['parameter_id'] = $parameter->parameter_id;
            $data['parameter_name'] = $parameter->parameter_name;
            $data['parameter_field_type'] = $parameter->parameter_field_type;
            $new_params[$parameter->category_name][] = $data;
        }
        return $new_params;
    }

}
