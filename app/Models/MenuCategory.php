<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MenuCategory extends Model
{
    //允许赋值和修改的字段
    protected $fillable = ['name','type_accumulation','shop_id','description','is_selected'];
    //获取logo的真实地址
    public function img(){
        return Storage::url($this->img);
    }
    public function shops(){
        return $this->belongsTo(Shops::class,'shop_id','id');
    }
}
