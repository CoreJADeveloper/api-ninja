<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Models\Models as Models;

class GeneralController extends Controller
{
    /**
     * Create a new controller instance which redirect a user to loggin page when he/she is not authenticated
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save_general_settings(){
        $settings_type = 'general';
        $admin_email = Input::get('general-settings.admin_email', '');
        $this->process_settings_option($settings_type, 'admin_email', $admin_email);
        $default_session = Input::get('general-settings.default_session', 10);
        $this->process_settings_option($settings_type, 'default_session', $default_session);
        $custom_css = Input::get('general-settings.custom_css', -1);
        $this->process_settings_option($settings_type, 'custom_css', $custom_css);
        $default_level = Input::get('general-settings.default_level', 0);
        $this->process_settings_option($settings_type, 'default_level', $default_level);
        $disable_registration = Input::get('general-settings.disable_registration', 0);
        $this->process_settings_option($settings_type, 'disable_registration', $disable_registration);
        $disable_login = Input::get('general-settings.disable_login', 0);
        $this->process_settings_option($settings_type, 'disable_login', $disable_login);
        $enable_recaptcha = Input::get('general-settings.enable_recaptcha', 0);
        $this->process_settings_option($settings_type, 'enable_recaptcha', $enable_recaptcha);

        return Response::json([
            "success" => true,
            "message" => "User Setting Updated Successfully."
        ], 200);
    }

    /** Process a settings option
     * @params $key, $value
     */
    private function process_settings_option($type, $key, $value){
        $data = array(
            'type' => $type,
            'meta_key' => $key,
            'meta_value' => $value
        );
        $this->settings_option($data);
    }

    /** Manage Insert/Update a settings option to database according to its existance in database
     * @params $option
     */
    private function settings_option($option){
        $models = new Models('settings');
        $where = array(
            'type' => strval($option['type']),
            'meta_key' => strval($option['meta_key'])
        );
        $exists = $models->check_row_exists($where);
        if($exists){
            $this->update_settings($option);
        }else{
            $this->insert_settings($option);
        }
    }

    /** Insert a new settings to the database
     * @params $options
     */
    private function insert_settings($options){
        $models = new Models('settings');
        $value = array(
            'type' => $options['type'],
            'meta_key' => $options['meta_key'],
            'meta_value' => $options['meta_value']
        );
        $id = $models->insert($value);
    }

    /** Update a new settings to the database
     * @params $options
     */
    private function update_settings($options){
        $models = new Models('settings');
        $where = array(
            'type' => $options['type'],
            'meta_key' => $options['meta_key']
        );
        $value = array(
            'meta_value' => $options['meta_value']
        );
        $models->update($where, $value);
    }
}
