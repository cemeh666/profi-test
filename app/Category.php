<?php
/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 09.12.17
 * Time: 10:17
 */

namespace App;


class Category extends \Eloquent
{
    protected $table      = 'category';
    protected $guarded    = ['id'];
    protected $primaryKey = 'id';




}