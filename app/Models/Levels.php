<?php
/**
 * Created by PhpStorm.
 * User: Tauhid
 * Date: 4/11/2016
 * Time: 11:05 AM
 */
namespace App\Models;

//use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class Levels{
    public $table;

    public function __construct(){
        $this->table = "levels";
    }

    /** Insert a level
     * @params $data
     */
    public function insert($data){
        $id = DB::table($this->table)->insertGetId(
            $data
        );
        return $id;
    }

    /** Update a level
     * @params $where, $value
     */
    public function update($where, $value){
        DB::table($this->table)
            ->where($where)
            ->update($value);
    }

    /** Get all levels information from database
     * @return mixed
     */
    public function get_all_levels(){
        $levels = DB::table($this->table)->select()->get();
        return $levels;
    }

    /** Get specific levels information from database
     * @return mixed
     */
    public function get_levels_columns($columns = null){
        $levels = DB::table($this->table)->select($columns)->get();
        return $levels;
    }

    /** Check a level option exists
     * @return bool
     */
    public function check_row_exists($where){
        $setting = DB::table($this->table)->where($where)->first();
        if(($setting != null) && !empty($setting)){
            return true;
        }else{
            return false;
        }
    }
}