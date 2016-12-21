<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
/**
 * Created by PhpStorm.
 * User: Tauhid
 * Date: 4/4/2016
 * Time: 9:31 PM
 */

class PaginatorClass {

    private $_limit;
    private $_page;
    private $_query;
    private $_total;

    public function __construct( $query ) {

        $this->_query = $query;

        $this->_total = count( DB::select($query) );
    }

    public function getData( $limit = 10, $page = 1 ) {

        $this->_limit   = $limit;
        $this->_page    = $page;

        if ( $this->_limit == 'all' ) {
            $query      = $this->_query;
        } else {
            $query      = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
        }

        $results = DB::select($query);

        $object         = new \stdClass();
        $object->page   = $this->_page;
        $object->limit  = $this->_limit;
        $object->total  = $this->_total;
        $object->data   = $results;

        return $object;
    }

    public function createLinks( $url, $links, $list_class ) {
        if ( $this->_limit == 'all' ) {
            return '';
        }

        $last       = ceil( $this->_total / $this->_limit );

        $start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
        $end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;

        $html       = '<ul class="' . $list_class . '">';

        $class      = ( $this->_page == 1 ) ? "disabled" : "";
        $html       .= '<li class="' . $class . '"><a data-csrf="'.csrf_token().'" data-url="'.url($url).'" data-page="'.( $this->_page - 1 ).'"><i class="fa fa-chevron-left"></i></a></li>';

        if ( $start > 1 ) {
            $html   .= '<li><a data-csrf="'.csrf_token().'" data-url="'.url($url).'" data-page="1">1</a></li>';
            $html   .= '<li class="disabled"><span>...</span></li>';
        }

        for ( $i = $start ; $i <= $end; $i++ ) {
            $class  = ( $this->_page == $i ) ? "active" : "";
            $html   .= '<li class="' . $class . '"><a data-csrf="'.csrf_token().'" data-url="'.url($url).'" data-page="'.$i.'">' . $i . '</a></li>';
        }

        if ( $end < $last ) {
            $html   .= '<li class="disabled"><span>...</span></li>';
            $html   .= '<li><a data-csrf="'.csrf_token().'" data-url="'.url($url).'" data-page="'.$last.'">' . $last . '</a></li>';
        }

        $class      = ( $this->_page == $last ) ? "disabled" : "";
        $html       .= '<li class="' . $class . '"><a data-csrf="'.csrf_token().'" data-url="'.url($url).'" data-page="'.( $this->_page + 1 ).'"><i class="fa fa-chevron-right"></i></a></li>';
        $html       .= '</ul>';

        return $html;
    }

}