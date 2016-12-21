<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Levels as Levels;
use App\Models\Models as Models;
use App\Http\Controllers\FunctionsController as FunctionsController;

class SettingsController extends Controller
{
    use FunctionsController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $settings_model = new Models('settings');
        $settings = $settings_model->get_all_rows();
        $levels_model = new Levels();
        $level_columns = array('id', 'name', 'enabled');
        $levels = $levels_model->get_levels_columns($level_columns);
        $settings_general = $this->get_specific_settings($settings, 'general');
        $settings_general = $this->add_new_settings_option('general', 'default_level', $settings_general);
        $settings_users = $this->get_specific_settings($settings, 'users');
        $settings_level = $this->get_specific_settings($settings, 'levels');
        $settings_reports = $this->get_specific_settings($settings, 'reports');
        $settings_emails = $this->get_specific_settings($settings, 'emails');

        return view('admin/settings/settings', [ 'settings' => [
            ['general' => $settings_general],
            ['users' => $settings_users],
            ['levels' => $settings_level],
            ['reports' => $settings_reports],
            ['emails' => $settings_emails],
            ['levels_information' => $levels]
        ]]);
    }

    /** Check if new registered user level is stored in database
     * @param $type
     * @param $meta_key
     * @param $settings
     * @return array
     */
    private function add_new_settings_option($type, $meta_key, $settings){
        if(array_key_exists($meta_key, $settings)){
//            $settings_model = new Models('settings');
//            $select = 'meta_value';
//            $where = array(
//                'type' => $type,
//                'meta_key' => $meta_key
//            );
//            $level = $this->get_specific_level($settings_model, $select, $where);
//            $level_id = $level->meta_value;
//            $select = 'name';
//            $where = array(
//                'id' => $level_id
//            );
//            $level_model = $this->get_level_name($select, $where);
//            $level_name = $level_model->name;
//            $settings[$meta_key]['default_level_name'] = $level_name;
            return $settings;
        }else{
            $select = 'id, name';
            $user_level = $this->get_subscriber_level_info($select);
            $meta_value = $user_level->id;
            $default_level_name = $user_level->name;
            $id = $this->insert_settings_option($type, $meta_key, $meta_value);
            $new_option = $this->customize_new_settings_option($id, $type, $meta_key, $meta_value, $default_level_name);
            $settings = array_merge($new_option, $settings);
            return $settings;
        }

    }

    /** Get a specific level name
     * @param $settings_model
     * @param $select
     * @param $where
     * @return mixed
     */
    private function get_level_name($select, $where){
        $model = new Models('levels');
        $level = $model->get_one_row($select, $where);
        return $level;
    }

    /** Get a level information
     * @param $settings_model
     * @param $select
     * @param $where
     * @return mixed
     */
    private function get_specific_level($settings_model, $select, $where){
        $level = $settings_model->get_one_row($select, $where);
        return $level;
    }

    /** Customize a settings option with new field
     * @param $id
     * @param $type
     * @param $meta_key
     * @param $meta_value
     * @param $default_level_name
     * @return mixed
     */
    private function customize_new_settings_option($id, $type, $meta_key, $meta_value, $default_level_name){
        $new_option[$meta_key] = array(
            'id' => $id,
            'type' => $type,
            'meta_key' => $meta_key,
            'meta_value' => $meta_value,
//            'default_level_name' => $default_level_name
        );
        return $new_option;
    }

    /** Insert a settings option to Settings database table
     * @param $type
     * @param $meta_key
     * @param $meta_value
     * @return int
     */
    private function insert_settings_option($type, $meta_key, $meta_value){
        $settings_model = new Models('settings');
        $data = array(
            'type' => $type,
            'meta_key' => $meta_key,
            'meta_value' => $meta_value
        );
        $id = $settings_model->insert_with_id($data);
        return intval($id);
    }

    /** Get subscriber level information
     * @param $select
     * @return mixed
     */
    private function get_subscriber_level_info($select){
        $levels_model = new Models('levels');
        $where = array(
            'manage_control_panel' => 0,
            'manage_categories' => 0,
            'manage_parameters' => 0,
            'manage_objects' => 0,
            'manage_collections' => 0,
            'manage_categories_collections' => 0,
            'default' => 1
        );
        $user_level = $levels_model->get_one_row($select, $where);
        return $user_level;
    }

}
