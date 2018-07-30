<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nus extends Model
{
    /*goods_name	string	名称
rating	float	评分
shop_id	int	所属商家ID
category_id	int	所属分类ID
goods_price	float	价格
description	string	描述
month_sales	int	月销量
rating_count	int	评分数量
tips	string	提示信息
satisfy_count	int	满意度数量
satisfy_rate	float	满意度评分
goods_img	string	商品图片
status	*/
    protected $table= 'menus';
    ///允许赋值和修改的字段
    protected $fillable = [
        'goods_name',
        'rating',
        'shop_id',
        'category_id',
        'goods_price',
        'description',
        'month_sales',
        'rating_count',
        'tips',
        'satisfy_count',
        'satisfy_rate',
        'goods_img',
        'status',
        ];
    public function Shops()
    {
        return $this->belongsTo(Shops::class,'shop_id','id');
        //Student::class ==== 'App\Models\Student'
    }

    public function Menus()
    {
        return $this->belongsTo(MenuCategory::class,'category_id','id');
    }
}
