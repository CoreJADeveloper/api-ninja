<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Models as Models;
use Illuminate\Support\Facades\Response;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Save user settings
     * @return JSON
     */
    public function save_user_settings(){
        $settings_type = 'users';
//        $settings = Input::get('user-settings', array());
//        foreach($settings as $key => $setting){
//            $this->process_settings_option($settings_type, $key, $setting);
//        }
        $search_character = Input::get('user-settings.search_characters', 3);
        $this->process_settings_option($settings_type, 'search_characters', $search_character);
        $users_per_page = Input::get('user-settings.users_per_page', 10);
        $this->process_settings_option($settings_type, 'users_per_page', $users_per_page);
        $total_users = Input::get('user-settings.total_users', -1);
        $this->process_settings_option($settings_type, 'total_users', $total_users);
        $disable_search = Input::get('user-settings.disable_search', 0);
        $this->process_settings_option($settings_type, 'disable_search', $disable_search);
        $disable_new_user = Input::get('user-settings.disable_new_user', 0);
        $this->process_settings_option($settings_type, 'disable_new_user', $disable_new_user);
        $admin_permission = Input::get('user-settings.admin_permission', 0);
        $this->process_settings_option($settings_type, 'admin_permission', $admin_permission);
        $email_activation = Input::get('user-settings.email_activation', 0);
        $this->process_settings_option($settings_type, 'email_activation', $email_activation);
        $send_email = Input::get('user-settings.send_email', 0);
        $this->process_settings_option($settings_type, 'send_email', $send_email);

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
            $this->update_settings($models, $option);
        }else{
            $this->insert_settings($models, $option);
        }
    }

    /** Insert a new settings to the database
     * @params $options
     */
    private function insert_settings($models, $options){
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
    private function update_settings($models, $options){
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
