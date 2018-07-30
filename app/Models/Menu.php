<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    ///允许赋值和修改的字段
    protected $fillable = ['name','type_accumulation','shop_id','description','is_selected'];

}
