<?php
/**
 * Created by PhpStorm.
 * User: Tauhid
 * Date: 4/13/2016
 * Time: 10:36 AM
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Models
{
    public $table;

    public function __construct($table_name)
    {
        $this->table = $table_name;
    }

    /** Get specific data from table
     * @param $select
     * @param $where
     * @return mixed
     */
    public function get_specific_rows($select = null, $where){
        if($select === null) {
            $results = DB::table($this->table)
                ->select('*')
                ->where($where)
                ->get();
        }else{
            $results = DB::table($this->table)
                ->select($select)
                ->where($where)
                ->get();
        }
        return $results;
    }

    /** Get all pagination results
     * @param $items_per_page
     * @return mixed
     */
    public function get_all_paginate_results($items_per_page){
        $results = DB::table($this->table)->paginate($items_per_page);
        return $results;
    }

    /** Get all rows of a table
     * @return mixed
     */
    public function get_all_rows()
    {
        $settings = DB::table($this->table)->select()->get();
        return $settings;
    }

    /** Get a rows of a table
     * @return mixed
     */
    public function get_one_row($select = null, $where)
    {
        if($select === null){
            $settings = DB::table($this->table)
                ->select('*')
                ->where($where)
                ->first();
        }else {
            $settings = DB::table($this->table)
                ->select($select)
                ->where($where)
                ->first();
        }
        return $settings;
    }

    /** Insert a row and get the inserted id
     * @params $data
     */
    public function insert_with_id($data)
    {
        $id = DB::table($this->table)->insertGetId(
            $data
        );
        return $id;
    }

    /** Insert a row
     * @params $data
     */
    public function insert($data)
    {
        DB::table($this->table)->insert(
            $data
        );
    }

    /** Update a row
     * @params $where, $value
     */
    public function update($where, $value)
    {
        DB::table($this->table)
            ->where($where)
            ->update($value);
    }

    /** Check a row exists
     * @return bool
     */
    public function check_row_exists($where)
    {
        $setting = DB::table($this->table)->where($where)->first();
        if (($setting != null) && !empty($setting)) {
            return true;
        } else {
            return false;
        }
    }

    /** Get specific rows
     * @params $columns
     * @return mixed
     */
    public function get_rows($columns = null)
    {
        $levels = DB::table($this->table)->select($columns)->get();
        return $levels;
    }

    /** Get rows with one join of a table
     * @param $join_table_name
     * @param $default_table_column
     * @param $join_table_column
     * @param $select
     * @return mixed
     */
    public function get_one_join_rows($join_table_name, $default_table_column, $join_table_column, $where, $select){
        $data = DB::table($this->table)
            ->where($where)
            ->join($join_table_name, $default_table_column, '=', $join_table_column)
            ->select($select)
            ->get();
        return $data;
    }

    /** Delete a row
     * @param $where
     */
    public function delete_row($where){
        DB::table($this->table)->where($where)->delete();
    }
}