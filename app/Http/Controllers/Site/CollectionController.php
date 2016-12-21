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

class CollectionController extends Controller
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

    /** Show all/paginate collections
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = Input::get('search', '');

        if ($search != '') {
            $collections = DB::table('collections')
                ->where('name', 'like', '%' . $search . '%')
                ->paginate(10);
            $request->session()->put('collection-search', 'Search results for - "' . $search . '"');
        } else {
            $collections = DB::table('collections')->paginate(10);
        }

        if (isset($collections) && !empty($collections)) {
            foreach ($collections as $collection) {
                $objects = unserialize($collection->objects);
                foreach ($objects as $object) {
                    $all_objects[] = $object;
                }
            }
        }

        if (isset($all_objects) && is_array($all_objects) && !empty($all_objects)) {
            $all_objects = array_unique($all_objects);

            $select = array('id', 'name');

            $objects_info = DB::table('objects')
                ->select($select)
                ->whereIn('id', $all_objects)
                ->get();

            foreach ($objects_info as $info) {
                $data_object[$info->id] = $info->name;
            }
        }else{
            $data_object = array();
        }

        $data['collections'] = $collections;
        $data['objects'] = $data_object;
        return view('site/collection/collection', ['data' => $data]);
    }

    /** New parameter creating view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $models = new Models('objects');

        $select = array('id', 'name');
        $where = array(
            'disabled' => 0
        );

        $objects = $models->get_specific_rows($select, $where);
        $data['objects'] = $objects;
        return view('site/collection/add', ['data' => $data]);
    }

    /** Save a new parameter to database
     * @param Request $request
     * @return mixed
     */
    public function submit_collection(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:collections',
            'unique_code' => 'required|unique:collections'
        ]);

        $models = new Models('collections');

        $data['name'] = Input::get('name');
        $data['unique_code'] = Input::get('unique_code');
        $data['locked'] = Input::get('locked', 0);
        $data['disabled'] = Input::get('disabled', 0);
        $data['objects'] = Input::get('objects');

        $data['objects'] = serialize($data['objects']);

        $models->insert($data);

        $request->session()->put('collection-add', 'Successfully saved collection');

        return Redirect::to('collection/add');
    }

    /** Check a parameter is editable
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit_collection($id)
    {
        $models = new Models('collections');

        $select = '*';
        $where = array(
            'id' => $id,
            'locked' => 0
        );

        $collection = $models->get_one_row($select, $where);

        $models = new Models('objects');

        $select = array('id', 'name');
        $where = array(
            'disabled' => 0
        );

        $objects = $models->get_specific_rows($select, $where);

        $data['collection'] = $collection;
        $data['objects'] = $objects;

        if (isset($collection) && !empty($collection)) {
            return view('site/collection/edit', ['data' => $data]);
        } else {
            return Redirect::to('collection/');
        }
    }

    /** Update a parameter information
     * @param Request $request
     * @return mixed
     */
    public function update_collection(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'unique_code' => 'required'
        ]);

        $models = new Models('collections');

        $id = Input::get('collection-id');

        $data['name'] = Input::get('name');
        $data['unique_code'] = Input::get('unique_code');
        $data['locked'] = Input::get('locked', 0);
        $data['disabled'] = Input::get('disabled', 0);
        $data['objects'] = Input::get('objects');

        $data['objects'] = serialize($data['objects']);

        $where = array(
            'id' => $id
        );

        $models->update($where, $data);

        $request->session()->put('collection-update', 'Successfully updated collection');

        return Redirect::to('collection/edit/' . $id);
    }

    /** Enable or disable a collection
     * @param Request $request
     */
    public function enable_disable_collection(Request $request)
    {
        $models = new Models('collections');

        $id = Input::get('collection_id');
        $name = Input::get('collection_name');
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
                        Successfully disabled collection - {$name}
                    </div>
EOD;
        } else {
            $message = <<<EOD
                    <div class="alert alert-success">
                        Successfully enabled collection - {$name}
                    </div>
EOD;
        }
        die($message);
    }

    /** Delete a collection
     * @param $id
     * @return mixed
     */
    public function delete_collection($id)
    {
        $models = new Models('collections');

        $where = array(
            'id' => $id
        );

        $models->delete_row($where);
        return Redirect::to('collection/');
    }
}
