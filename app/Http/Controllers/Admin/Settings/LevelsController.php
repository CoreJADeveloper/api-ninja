<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Models as Models;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class LevelsController extends Controller
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

    /** Save level settings
     * @return JSON
     */
    public function save_level_settings(){
        $settings_type = 'levels';
        $redirect_url = Input::get('level-settings.redirect_url', url('/'));
        $this->process_settings_option($settings_type, 'redirect_url', $redirect_url);
        $search_character = Input::get('level-settings.search_characters', 3);
        $this->process_settings_option($settings_type, 'search_characters', $search_character);
        $levels_per_page = Input::get('level-settings.levels_per_page', 10);
        $this->process_settings_option($settings_type, 'levels_per_page', $levels_per_page);
        $total_levels = Input::get('level-settings.total_levels', -1);
        $this->process_settings_option($settings_type, 'total_levels', $total_levels);
        $disabled_levels = Input::get('chosen_disabled_levels', 0);
        $this->process_all_level_enabled();
        $this->process_level_option($disabled_levels);
        $disable_search = Input::get('level-settings.disable_search', 0);
        $this->process_settings_option($settings_type, 'disable_search', $disable_search);
        $disable_new_level = Input::get('level-settings.disable_new_level', 0);
        $this->process_settings_option($settings_type, 'disable_new_level', $disable_new_level);
        $admin_permission = Input::get('level-settings.admin_permission', 0);
        $this->process_settings_option($settings_type, 'admin_permission', $admin_permission);

        return Response::json([
            "success" => true,
            "message" => "Level Setting Updated Successfully."
        ], 200);
    }

    /** Update all levels to enabled
     *
     */
    private function process_all_level_enabled(){
        $models = new Models('levels');
        $where = array(
            'enabled' => 0
        );
        $value = array(
            'enabled' => 1
        );
        $models->update($where, $value);
    }

    /** Process a settings option
     * @params $key, $value
     */
    private function process_level_option($level_ids){
        foreach($level_ids as $id) {
            $data = array(
                'id' => $id,
                'enabled' => 0
            );
            $this->update_level($data);
        }
    }

    /** Update a new level to the database
     * @params $options
     */
    private function update_level($options){
        $models = new Models('levels');
        $where = array(
            'id' => $options['id']
        );
        $value = array(
            'enabled' => $options['enabled']
        );
        $models->update($where, $value);
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
