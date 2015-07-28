<?php
/**
 * 
 * Copyright (c) 2014 Zishan Ansari
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * Date: 7/26/2015
 * Time: 12:57 AM
 */

/**
 * Returns 'active' if Request is same as current.
 * This function is used to make a nav bar actived when in that page.
 *
 * @param $path
 * @param string $active
 * @return string
 */
function set_active($path, $active = 'active') {

    return call_user_func_array('Request::is', (array)$path) ? $active : '';

}

/**
 * Function that will create a link to sort rounds by specified coulmn name
 *
 * @param $column
 * @param $data
 * @return string
 */
function sort_rounds_by($column,$data)
{
    $sortDirCurrent = Request::get('direction') ? Request::get('direction') : 'desc';
    $getOrderBy = Request::has('orderBy') ? Request::get('orderBy') : 'created_at';

    $sortDir = Request::get('direction') == 'asc' ? 'desc' : 'asc' ;

    if($getOrderBy == $column)
        return link_to_route('round-reports',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary '.$sortDirCurrent]);
    else
        return link_to_route('round-reports',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary']);
}

/**
 * Function that will create a link to sort players by specified coulmn name
 *
 * @param $column
 * @param $data
 * @return string
 */
function sort_players_by($column,$data)
{
    $sortDirCurrent = Request::get('direction') ? Request::get('direction') : 'asc';
    $getOrderBy = Request::has('orderBy') ? Request::get('orderBy') : 'position';

    $sortDir = Request::get('direction') == 'asc' ? 'desc' : 'asc' ;

    if($getOrderBy == $column)
        return link_to_route('top-players',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary '.$sortDirCurrent]);
    else
        return link_to_route('top-players',$data,['orderBy'=>$column, 'direction' => $sortDir],['class' => 'a-primary']);
}