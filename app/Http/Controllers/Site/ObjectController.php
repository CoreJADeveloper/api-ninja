<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\FunctionsController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Models as Models;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

class ObjectController extends Controller
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

    /** Show all/paginate objects
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $models = new Models('parameters');

        $select = array('id', 'name', 'category_id');
        $where = array(
            'disabled' => 0
        );

        $parameters = $models->get_specific_rows($select, $where);

        $search = Input::get('search', '');

        if ($search != '') {
            $objects = DB::table('objects')
                ->where('name', 'like', '%' . $search . '%')
                ->paginate(10);
            $request->session()->put('object-search', 'Search results for - "' . $search . '"');
        } else {
            $objects = DB::table('objects')->paginate(10);
        }

        $data['objects'] = $objects;
        $data['parameters'] = $parameters;
        return view('site/object/object', ['data' => $data]);
    }

    /** New object creating view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $models = new Models('categories');

        $select = array('categories.id as category_id', 'categories.name as category_name', 'parameters.id as parameter_id', 'parameters.name as parameter_name', 'parameters.field_type as parameter_field_type');
        $where = array(
            'categories.disabled' => 0,
            'parameters.disabled' => 0
        );

        $parameters = $models->get_one_join_rows('parameters', 'categories.id', 'parameters.category_id', $where, $select);
        $data['parameters'] = $this->function_get_categorized_parameters($parameters);
        return view('site/object/add', ['data' => $data]);
    }

    public function object_filtering(Request $request)
    {
        $models = new Models('categories');

        $select = array('id', 'name');
        $where = array(
            'disabled' => 0
        );

        $categories = $models->get_specific_rows($select, $where);

        $category_id = Input::get('filter-category');
        $filter_type = Input::get('filter-type');
        $enable_filtering = Input::get('enable-filtering', 0);

        if ($filter_type == 'All') {
            $where = array(
                'category_id' => $category_id,
                'enable_filtering' => $enable_filtering
            );
        } else {
            $where = array(
                'category_id' => $category_id,
                'enable_filtering' => $enable_filtering,
                'field_type' => $filter_type
            );
        }

        $objects = DB::table('objects')
            ->where($where)
            ->paginate(10);

        $data['objects'] = $objects;
        $data['categories'] = $categories;

        $request->session()->put('object-filtering', 'Showing filtering results:');

        return view('site/object/object', ['data' => $data]);
    }

    public function redirect_object_filtering()
    {
        return Redirect::to('object/');
    }

    /** Save a new object to database
     * @param Request $request
     * @return mixed
     */
    public function submit_object(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:objects',
            'unique_code' => 'required|unique:objects'
        ]);

        $models = new Models('parameters');

        $select = array('id', 'name');

        $where = array(
            'field_type' => 'Image'
        );

        $image_parameters = $models->get_specific_rows($select, $where);

        $models = new Models('objects');

        $data['name'] = Input::get('name');
        $data['unique_code'] = Input::get('unique_code');
        $data['website_link'] = Input::get('website_link');
        $data['locked'] = Input::get('locked', 0);
        $data['disabled'] = Input::get('disabled', 0);

        if(!File::exists(public_path('/assets/logo'))) {
            $result = File::makeDirectory(public_path('/assets/logo'));
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $id = uniqid();
            $file_extension = $logo->getClientOriginalExtension();
            $logo_name = $id.'.'.$file_extension;
            if(!File::exists(public_path('/assets/logo/'.$logo_name))) {
                $request->file('logo')->move(public_path('/assets/logo'), $logo_name);
                $data['logo'] = $logo_name;
            }
        }

        $parameters = Input::get('parameter');

        foreach($image_parameters as $parameter){
            $parameter_id = $parameter->id;
            if ($request->hasFile('parameter.'.$parameter_id.'')) {
                $logo = $request->file('parameter.'.$parameter_id.'');
                $id = uniqid();
                $file_extension = $logo->getClientOriginalExtension();
                $parameter_logo_name = $id.'.'.$file_extension;
                if(!File::exists(public_path('/assets/logo/'.$parameter_logo_name))) {
                    $request->file('parameter.'.$parameter_id.'')->move(public_path('/assets/logo'), $parameter_logo_name);
                    $parameters[$parameter_id] = $parameter_logo_name;
                }
            }
        }

        $data['parameters'] = serialize($parameters);

        $models->insert($data);

        DB::table('parameters')
            ->where(['disabled' => 0])
            ->increment('total_used');

        $request->session()->put('object-add', 'Successfully saved object');

        return Redirect::to('object/add');
    }

    /** Delete a object
     * @param $id
     * @return mixed
     */
    public function delete_object($id){
        $models = new Models('objects');

        $where = array(
            'id' => $id
        );

        $models->delete_row($where);
        return Redirect::to('object/');
    }

    /** Check a object is editable
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit_object($id)
    {
        $models = new Models('objects');

        $select = '*';
        $where = array(
            'id' => $id,
            'locked' => 0
        );

        $object_data = $models->get_one_row($select, $where);

        $models = new Models('categories');

        $select = array('categories.id as category_id', 'categories.name as category_name', 'parameters.id as parameter_id', 'parameters.name as parameter_name', 'parameters.field_type as parameter_field_type');
        $where = array(
            'categories.disabled' => 0,
            'parameters.disabled' => 0
        );

        $parameters = $models->get_one_join_rows('parameters', 'categories.id', 'parameters.category_id', $where, $select);
        $parameters = $this->function_get_categorized_parameters($parameters);

        $object_data->parameters = unserialize($object_data->parameters);

        $data['object'] = $object_data;
        $data['parameters'] = $parameters;

        if (isset($object_data) && !empty($object_data)) {
            return view('site/object/edit', ['data' => $data]);
        } else {
            return Redirect::to('object/');
        }
    }

    /** Update a object information
     * @param Request $request
     * @return mixed
     */
    public function update_object(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'unique_code' => 'required'
        ]);

        $models = new Models('parameters');

        $select = array('id', 'name');

        $where = array(
            'field_type' => 'Image'
        );

        $image_parameters = $models->get_specific_rows($select, $where);

        $models = new Models('objects');

        $object_id = Input::get('object-id');

        $data['name'] = Input::get('name');
        $data['unique_code'] = Input::get('unique_code');
        $data['website_link'] = Input::get('website_link');
        $data['locked'] = Input::get('locked', 0);
        $data['disabled'] = Input::get('disabled', 0);

        if(!File::exists(public_path('/assets/logo'))) {
            $result = File::makeDirectory(public_path('/assets/logo'));
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $id = uniqid();
            $file_extension = $logo->getClientOriginalExtension();
            $logo_name = $id.'.'.$file_extension;
            if(!File::exists(public_path('/assets/logo/'.$logo_name))) {
                $request->file('logo')->move(public_path('/assets/logo'), $logo_name);
                $data['logo'] = $logo_name;
            }
        }

        $parameters = Input::get('parameter');

        foreach($image_parameters as $parameter){
            $parameter_id = $parameter->id;
            if ($request->hasFile('parameter.'.$parameter_id.'')) {
                $logo = $request->file('parameter.'.$parameter_id.'');
                $id = uniqid();
                $file_extension = $logo->getClientOriginalExtension();
                $parameter_logo_name = $id.'.'.$file_extension;
                if(!File::exists(public_path('/assets/logo/'.$parameter_logo_name))) {
                    $request->file('parameter.'.$parameter_id.'')->move(public_path('/assets/logo'), $parameter_logo_name);
                    $parameters[$parameter_id] = $parameter_logo_name;
                }
            }else{
                $object_model = new Models('objects');

                $select = array('*');

                $where = array(
                    'id' => $object_id
                );

                $existing_object = $object_model->get_one_row($select, $where);

                $existing_object->parameters = unserialize($existing_object->parameters);

                $parameters[$parameter_id] = $existing_object->parameters[$parameter_id];
            }
        }

        $data['parameters'] = serialize($parameters);

        $where = array(
            'id' => $object_id
        );

        $models->update($where, $data);

        $request->session()->put('object-update', 'Successfully updated object');

        return Redirect::to('object/edit/' . $object_id);
    }

    /** Enable or disable a object
     * @param Request $request
     */
    public function enable_disable_object(Request $request)
    {
        $models = new Models('objects');

        $id = Input::get('object_id');
        $name = Input::get('object_name');
        $disabled = Input::get('disabled');

        $where = array(
            'id' => $id
        );

        $value = array(
            'disabled' => $disabled
        );

        $models->update($where, $value);

        if ($disabled == 1) {
            $message = <<<EOD
                    <div class="alert alert-warning">
                        Successfully disabled object - {$name}
                    </div>
EOD;
        } else {
            $message = <<<EOD
                    <div class="alert alert-success">
                        Successfully enabled object - {$name}
                    </div>
EOD;
        }
        die($message);
    }
}
