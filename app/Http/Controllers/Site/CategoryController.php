<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Models\Models as Models;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
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

    /** Show all/paginate categories
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $search = Input::get('search', '');

        if($search != ''){
            $categories = DB::table('categories')
                ->where('name', 'like', '%'.$search.'%')
                ->paginate(10);
            $request->session()->put('category-search', 'Search results for - "'.$search.'"');
        }else {
            $categories = DB::table('categories')->paginate(10);

        }
        return view('site/category/category', ['categories' => $categories]);
    }

    /** New category creating view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        return view('site/category/add');
    }

    /** Save a new category to database
     * @param Request $request
     * @return mixed
     */
    public function submit_category(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:categories'
        ]);

        $models = new Models('categories');

        $data['name'] = Input::get('name');
        $data['mandatory'] = Input::get('category.mandatory', 0);
        $data['disabled'] = Input::get('category.disabled', 0);

        $models->insert($data);

        $request->session()->put('category-add', 'Successfully saved category');

        return Redirect::to('category/add');
    }

    /** Check a category is editable
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit_category($id){
        $models = new Models('categories');

        $select = '*';
        $where = array(
            'id' => $id,
            'mandatory' => 0
        );

        $category = $models->get_one_row($select, $where);

        if(isset($category) && !empty($category)){
            return view('site/category/edit', ['category' => $category]);
        }else{
            return Redirect::to('category/');
        }
    }

    /** Update a category information
     * @param Request $request
     * @return mixed
     */
    public function update_category(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);

        $models = new Models('categories');

        $id = Input::get('category-id');
        $name = Input::get('name');
        $mandatory = Input::get('category.mandatory', 0);
        $disabled = Input::get('category.disabled', 0);

        $where = array(
            'id' => $id
        );

        $value = array(
            'name' => $name,
            'mandatory' => $mandatory,
            'disabled' => $disabled
        );

        $models->update($where, $value);

        $request->session()->put('category-update', 'Successfully updated category');

        return Redirect::to('category/edit/'.$id);
    }

    /** Enable or disable a category
     * @param Request $request
     */
    public function enable_disable_category(Request $request){
        $models = new Models('categories');

        $id = Input::get('category_id');
        $name = Input::get('category_name');
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
                        Successfully disabled category - {$name}
                    </div>
EOD;
        }else{
            $message = <<<EOD
                    <div class="alert alert-success">
                        Successfully enabled category - {$name}
                    </div>
EOD;
        }
        die($message);
    }
}
