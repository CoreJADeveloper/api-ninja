<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Models\Models as Models;
use Illuminate\Support\Facades\Redirect;

class ParameterController extends Controller
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

    /** Show all/paginate parameters
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $models = new Models('categories');

        $select = array('id', 'name');
        $where = array(
            'disabled' => 0
        );

        $categories = $models->get_specific_rows($select, $where);

        $search = Input::get('search', '');

        if($search != ''){
            $parameters = DB::table('parameters')
                ->where('name', 'like', '%'.$search.'%')
                ->paginate(10);
            $request->session()->put('parameter-search', 'Search results for - "'.$search.'"');
        }else {
            $parameters = DB::table('parameters')->paginate(10);
        }

        $data['parameters'] = $parameters;
        $data['categories'] = $categories;
        return view('site/parameter/parameter', ['data' => $data]);
    }

    /** New parameter creating view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        $models = new Models('categories');

        $select = array('id', 'name');
        $where = array(
            'disabled' => 0
        );

        $categories = $models->get_specific_rows($select, $where);
        return view('site/parameter/add', ['categories' => $categories]);
    }

    public function parameter_filtering(Request $request){
        $models = new Models('categories');

        $select = array('id', 'name');
        $where = array(
            'disabled' => 0
        );

        $categories = $models->get_specific_rows($select, $where);

        $category_id = Input::get('filter-category');
        $filter_type = Input::get('filter-type');
        $enable_filtering = Input::get('enable-filtering', 0);

        if($filter_type == 'All'){
            $where = array(
                'category_id' => $category_id,
                'enable_filtering' => $enable_filtering
            );
        }else{
            $where = array(
                'category_id' => $category_id,
                'enable_filtering' => $enable_filtering,
                'field_type' => $filter_type
            );
        }

        $parameters = DB::table('parameters')
            ->where($where)
            ->paginate(10);

        $data['parameters'] = $parameters;
        $data['categories'] = $categories;

        $request->session()->put('parameter-filtering', 'Showing filtering results:');

        return view('site/parameter/parameter', ['data' => $data]);
    }

    public function redirect_parameter_filtering(){
        return Redirect::to('parameter/');
    }

    /** Save a new parameter to database
     * @param Request $request
     * @return mixed
     */
    public function submit_parameter(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:parameters'
        ]);

        $models = new Models('parameters');

        $data['name'] = Input::get('name');
        $data['category_id'] = Input::get('category', 0);
        $data['field_type'] = Input::get('field-type', 0);
        $data['enable_rating'] = Input::get('enable-rating', 0);
        $data['enable_filtering'] = Input::get('enable-filtering', 0);
        $data['mandatory'] = Input::get('mandatory', 0);
        $data['disabled'] = Input::get('disabled', 0);

        $models->insert($data);

        DB::table('categories')
            ->where(['id' => $data['category_id']])
            ->increment('parameters');

        $request->session()->put('parameter-add', 'Successfully saved parameter');

        return Redirect::to('parameter/add');
    }

    /** Check a parameter is editable
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit_parameter($id){
        $models = new Models('parameters');

        $select = '*';
        $where = array(
            'id' => $id,
            'mandatory' => 0
        );

        $parameter = $models->get_one_row($select, $where);

        $models = new Models('categories');

        $select = array('id', 'name');
        $where = array(
            'disabled' => 0
        );

        $categories = $models->get_specific_rows($select, $where);

        $data['parameter'] = $parameter;
        $data['categories'] = $categories;

        if(isset($parameter) && !empty($parameter)){
            return view('site/parameter/edit', ['data' => $data]);
        }else{
            return Redirect::to('parameter/');
        }
    }

    /** Update a parameter information
     * @param Request $request
     * @return mixed
     */
    public function update_parameter(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);

        $models = new Models('parameters');

        $id = Input::get('parameter-id');
        $previous_category_id = Input::get('previous-category-id');

        $data['name'] = Input::get('name');
        $data['category_id'] = Input::get('category', 0);
        $data['field_type'] = Input::get('field-type', 0);
        $data['enable_rating'] = Input::get('enable-rating', 0);
        $data['enable_filtering'] = Input::get('enable-filtering', 0);
        $data['mandatory'] = Input::get('mandatory', 0);
        $data['disabled'] = Input::get('disabled', 0);

        $where = array(
            'id' => $id
        );

        $models->update($where, $data);

//        DB::table('parameters')
//            ->where($where)
//            ->update($data);

        if($data['category_id'] != $previous_category_id){
            DB::table('categories')
                ->where(['id' => $data['category_id']])
                ->increment('parameters');
            DB::table('categories')
                ->where(['id' => $previous_category_id])
                ->decrement('parameters');
        }

        $request->session()->put('parameter-update', 'Successfully updated parameter');

        return Redirect::to('parameter/edit/'.$id);
    }

    /** Enable or disable a parameter
     * @param Request $request
     */
    public function enable_disable_parameter(Request $request){
        $models = new Models('parameters');

        $id = Input::get('parameter_id');
        $name = Input::get('parameter_name');
        $disabled = Input::get('disabled');

        $where = array(
            'id' => $id
        );

        $value = array(
            'disabled' => $disabled
        );

        $models->update($where, $value);

        if($disabled == 1){
            $message = <<<EOD
                    <div class="alert alert-warning">
                        Successfully disabled parameter - {$name}
                    </div>
EOD;
        }else{
            $message = <<<EOD
                    <div class="alert alert-success">
                        Successfully enabled parameter - {$name}
                    </div>
EOD;
        }
        die($message);
    }
}
