<?php

namespace App\Http\Controllers\Admin\ControlPanel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Models as Models;
use App\Http\Controllers\FunctionsController as FunctionsController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PaginatorClass as PaginatorClass;

class ControlPanelController extends Controller
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
        $users_table_name = 'users';
        $settings_model = new Models('settings');
        $settings = $settings_model->get_all_rows();

        $settings_general = $this->get_specific_settings($settings, 'general');

        $settings_users = $this->get_specific_settings($settings, 'users');
        $limit = $this->get_users_per_page($settings_users);

        $page = 1;
        $links = 7;

        $query = "SELECT * FROM " . $users_table_name . " ORDER BY id DESC ";

        $paginator = new PaginatorClass($query);
        $page_url = '/get-users-pagination';
        $selected_users = $paginator->getData($limit, $page);
        $users_pagination_code = $paginator->createLinks($page_url, $links, 'users-pagination pagination pagination-sm');

        $users = array(
            'pagination' => $users_pagination_code,
            'selected_users' => $selected_users
        );

        $settings_level = $this->get_specific_settings($settings, 'levels');
        $levels = $this->get_levels();
        $settings_reports = $this->get_specific_settings($settings, 'reports');
        $settings_emails = $this->get_specific_settings($settings, 'emails');

        return view('admin/control-panel/control-panel', [ 'settings' => [
            ['general_settings' => $settings_general],
            ['users_settings' => $settings_users],
            ['levels_settings' => $settings_level],
            ['reports_settings' => $settings_reports],
            ['emails_settings' => $settings_emails],
            ['users' => $users],
            ['levels' => $levels]
        ]]);
    }

    /** Get total users would be shown in Control panel
     * @param $user_settings
     * @return int
     */
    private function get_users_per_page($user_settings){
        $users_per_page = isset($user_settings['users_per_page']['meta_value'])?$user_settings['users_per_page']['meta_value']:10;
        return $users_per_page;
    }

    /** Get all levels those are enabled
     * @return mixed
     */
    private function get_levels(){
        $models = new Models('levels');
        $select = array('name', 'id');
        $where = array(
            'enabled' => true
        );
        $levels = $models->get_specific_rows($select, $where);
        return $levels;
    }
}
