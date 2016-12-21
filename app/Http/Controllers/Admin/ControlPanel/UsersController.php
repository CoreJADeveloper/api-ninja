<?php

namespace App\Http\Controllers\Admin\ControlPanel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Models as Models;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\PaginatorClass as PaginatorClass;

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

    /** Store a new user to database table
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'bail|required|unique:users|max:255',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6|confirmed'
        ]);

        $models = new Models('users');

        $data['name'] = Input::get('name');
        $data['email'] = Input::get('email');
        $data['password'] = Input::get('password');
        $data['level'] = Input::get('level');

        $models->insert($data);

        return Response::json([
            "success" => true,
            "csrf" => csrf_token(),
            "message" => "Added new user Successfully."
        ], 200);

    }

    /** Get AJAX submitted request to show users
     * @return mixed
     */
    public function show_users()
    {
        $table_name = "users";
        $page_url = '/get-users-pagination';
        $limit = $this->get_general_settings_option();
        $page = Input::get('page', 1);
        $links = Input::get('links', 7);
        $search = Input::get('search', '');

        if($search != ''){
            $query = $query = "SELECT * FROM " . $table_name . " WHERE name LIKE '%".$search."%' ORDER BY id DESC ";
        }else {
            $query = $query = "SELECT * FROM " . $table_name . " ORDER BY id DESC ";
        }

        $paginator = new PaginatorClass($query);
        $users = $paginator->getData($limit, $page);
        $users_pagination_code = $paginator->createLinks($page_url, $links, 'users-pagination pagination pagination-sm');

        if (empty($users)) {
            $code = <<<EOD
                    '<div class="alert alert-warning" role="alert">There is no role yet!</div>'
EOD;
            return Response::json([
                "success" => false,
                "code" => $code
            ], 200);
        } else {
            $header = $this->get_users_header($users_pagination_code);
            $content = $this->get_users_content($users);
            $footer = $this->get_users_footer($users_pagination_code);
            $code = $header.$content.$footer;
            return Response::json([
                "success" => true,
                "code" => $code
            ], 200);
        }
    }

    /** Get total users to show per page in Control panel
     * @return int
     */
    private function get_general_settings_option()
    {
        $settings = new Models('settings');
        $select = array('meta_value');
        $where = array(
            'type' => 'users',
            'meta_key' => 'users_per_page'
        );
        $users_settings = $settings->get_one_row($select, $where);
        $users_per_page = isset($users_settings->meta_value) ? $users_settings->meta_value : 10;
        return $users_per_page;
    }

    /** Get users page header
     * @param $pagination
     * @return string
     */
    private function get_users_header($pagination){
        $header = <<<EOH
                {$pagination}
                <table class="table table-striped" >
                <thead >
                <tr >
                    <th > Name</th >
                    <th > Email</th >
                    <th > Registered Date </th >
                    <th > Last login </th >
                    <th > Actions</th >
                </tr >
                </thead >
                <tbody >
EOH;
        return $header;
    }

    /** Get users page contents
     * @param $pagination
     * @return string
     */
    private function get_users_content($users){
        $content = '';
        foreach ($users->data as $user) {
            $content .= <<<EOC
                <tr>
                        <td>
                            {$user->name}
                        </td >
                        <td>
                            {$user->email}
                        </td>
                        <td>
                            {$user->created_at}
                        </td>
                        <td>
                            {$user->last_login}
                        </td >
                        <td>
                            <button class="btn btn-primary btn-xs fa-btn" ><i class="fa fa-check fa-btn" ></i > Edit</button >
                            <button class="btn btn-danger btn-xs" ><i class="fa fa-times fa-btn" ></i > Delete</button >
                        </td>
                    </tr>
EOC;
        }
        return $content;
    }

    /** Get users page footer
     * @param $pagination
     * @return string
     */
    private function get_users_footer($pagination){
        $footer = <<<EOF
                </tbody >
                </table >
                {$pagination}
EOF;
        return $footer;
    }
}
