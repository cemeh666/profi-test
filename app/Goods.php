<?php
/**
 * Created by PhpStorm.
 * User: cemeh666
 * Date: 09.12.17
 * Time: 10:21
 */

namespace App;


class Goods extends \Eloquent
{
    protected $table      = 'goods';
    protected $guarded    = ['id'];
    protected $primaryKey = 'id';

    /**
     * Связь моногие ко многим с таблицеей Category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category(){
        return $this->belongsToMany(Category::class);
    }
}