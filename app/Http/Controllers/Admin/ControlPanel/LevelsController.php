<?php

namespace App\Http\Controllers\Admin\ControlPanel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PaginatorClass;
use App\Models\ControlPanel as ControlPanel;
use App\Models\Levels;
use App\Models\Models as Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

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

    /** Callback method for jQuery post and display all user roles
     *
     */
    public function index()
    {
        $table_name = "levels";

        $where = array(
            'type' => 'levels',
            'meta_key' => 'levels_per_page'
        );
        $select = 'meta_value';
        $settings = $this->get_levels_limits_per_page($select, $where);
        $limit = $settings->meta_value;
        $page = Input::get('page', 1);
        $links = Input::get('links', 7);
        $search = Input::get('search', '');

        if($search != ''){
            $query = $query = "SELECT * FROM " . $table_name . " WHERE name LIKE '%".$search."%' ORDER BY id DESC ";
        }else {
            $query = $query = "SELECT * FROM " . $table_name . " ORDER BY id DESC ";
        }

        $paginator = new PaginatorClass($query);

        $levels = $paginator->getData($limit, $page);

        if (empty($levels)) {
            $code = <<<EOD
                    '<div class="alert alert-warning" role="alert">There is no role yet!</div>'
EOD;
            $data['message'] = false;
            $data['code'] = $code;
            echo json_encode($data);
            die();
        } else {
//            $total = ($limit * $page) - 1;
            $rows = $this->get_all_rows($levels);
            $code = $this->display_all_rows($rows, $links, $paginator);
            $data['message'] = true;
            $data['code'] = $code;
            echo json_encode($data);
            die();
        }
    }

    /** Get total levels limit in perpage
     *
     */
    private function get_levels_limits_per_page($select, $where){
        $models = new Models('settings');
        $settings = $models->get_one_row($select, $where);
        return $settings;
    }

    /** Get all user role rows
     * @param $roles
     * @return String
     */
    private function get_all_rows($roles)
    {
        $rows = '';
        foreach ($roles->data as $key => $role) {
            $rows .= <<<EOF
                    <tr>
                    <td class="text-center">{$role->name}</td>
                    <td class="text-center">{$this->get_level_identifier($role->manage_control_panel)}</td>
                    <td class="text-center">{$this->get_level_identifier($role->manage_categories)}</td>
                    <td class="text-center">{$this->get_level_identifier($role->manage_parameters)}</td>
                    <td class="text-center">{$this->get_level_identifier($role->manage_objects)}</td>
                    <td class="text-center">{$this->get_level_identifier($role->manage_collections)}</td>
                    <td class="text-center">{$this->get_level_identifier($role->manage_categories_collections)}</td>
                    <td class="text-center">{$role->active_users}</td>
                    <td class="text-center">{$role->redirect}</td>
                    </tr>
EOF;
        }
        return $rows;
    }

    /** Display all rows of user levels
     * @params String
     * @return String
     */
    private function display_all_rows($rows, $links, $paginator)
    {
        $page_url = '/get-pagination';
        $pagination_code = $paginator->createLinks($page_url, $links, 'user-levels pagination pagination-sm');
        $code = <<<EOD
                <div class="alert alert-info" role="alert">
                <span class="roles-help-message"><b>Yes:</b> <i data-toggle="tooltip" data-placement="right" title="User can manage and see the selected option" class="fa fa-question-circle question-sign"></i><span>
                <span class="roles-help-message"><b>No:</b> <i data-toggle="tooltip" data-placement="right" title="User can't manage but see the selected option" class="fa fa-question-circle question-sign"></i><span>
                </div>
                {$pagination_code}
                <table class="table table-bordered">
                <thead>
                <tr>
                <td class="text-center"><b>Level</b></td>
                <td class="text-center"><b>Manage Control Panel</b></td>
                <td class="text-center"><b>Manage Categories</b></td>
                <td class="text-center"><b>Manage Parameters</b></td>
                <td class="text-center"><b>Manage Objects</b></td>
                <td class="text-center"><b>Manage Collections</b></td>
                <td class="text-center"><b>Manage Categories Collections</b></td>
                <td class="text-center"><b>Active Users</b</td>
                <td class="text-center"><b>Redirect</b></td>
                </tr>
                </thead>
                <tbody>
                {$rows}
                </tbody>
                </table>
                {$pagination_code}
EOD;
        return $code;
    }

    /** Convert user capability to Yes/No
     * @param $identifier
     * @return string
     */
    private function get_level_identifier($identifier)
    {
        if ($identifier == 1) {
            return "Yes";
        } else {
            return "No";
        }
    }

    /**
     * Store a new user level
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|unique:levels|max:255'
        ]);

        $levels = new Levels();
        $current_user_id = Auth::user()->id;
        $insert_value = array();
        $option = Input::get('form-role.option');
        if($option == 'new') {
            $insert_value['name'] = Input::get('name');
            $insert_value['created_by'] = $current_user_id;
            $insert_value['manage_control_panel'] = Input::get('form-role.control-panel', 0);
            $insert_value['manage_categories'] = Input::get('form-role.categories', 0);
            $insert_value['manage_parameters'] = Input::get('form-role.parameters', 0);
            $insert_value['manage_objects'] = Input::get('form-role.objects', 0);
            $insert_value['manage_collections'] = Input::get('form-role.collections', 0);
            $insert_value['manage_categories_collections'] = Input::get('form-role.categories-collections', 0);
            $insert_value['redirect'] = Input::get('form-role.redirect', 0);
            $insert_value['default'] = false;
            $id = $levels->insert($insert_value);
        }
        $csrf_token = csrf_token();
        $data['message'] = 'success';
        $data['csrf'] = $csrf_token;
        echo json_encode($data);
        die();
    }
}
