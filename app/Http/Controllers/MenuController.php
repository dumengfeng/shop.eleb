<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\nus;
use App\Models\OrderGood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    //权限
    public function __construct()
    {
        $this->middleware('auth',[
//            'only'=>['info'],//（登录后可以查看的）该中间件只对这些方法生效
            'except'=>['index'],//（未登录可以查看的）该中间件除了这些方法，对其他方法生效
        ]);
    }

    //菜品列表
    public function index(Request $request)
    {
        //获得菜品分类信息
//        $menu_category = DB::table('menu_categories')->get();
        $keyword = '';
        if($request->keyword){
            $keyword = $request->keyword;
            $nus = nus::where('goods_name','like','%'.$keyword.'%')->paginate(5);//包含功能分页搜索
        }else{
            $nus = nus::paginate(5);//包含功能分页
        }

        return view('menu/index2',compact(['menu_category','nus','keyword']));
    }
    //菜品添加页面
    public function create()
    {
        //获得商家信息
        $shops = DB::table('shops')->get();
        //获得菜品分类信息
        $menu_category = DB::table('menu_categories')->get();
        return view('menu/create',compact(['menu_category','shops']));
    }
    //菜品添加功能
    public function store(Request $request)
    {
        //验证数据
        $this->validate($request,[
            'goods_name'=>'required|max:20|unique:menus',
            'goods_price'=>'required',
            'tips'=>'required',
            'goods_img'=>'required',
        ],[
            'goods_name.required'=>'菜品名不能为空',
            'goods_name.max'=>'菜品名不能大于20个字',
            'goods_name.unique'=>'菜品名已存在',
            'goods_price.unique'=>'价格不能为空',
            'description.unique'=>'描述不能为空',
            'tips.unique'=>'提示信息不能为空',
            'goods_img.unique'=>'商品图片不能为空',
        ]);

        //处理上传文件
//        $file = $request->goods_img;
//        //使用这个要开启storage   php artisan storage:link
//        $fileName = $file->store('public/goods_img');//获得保存图片路径，返回地址
////        dd(123);
//        $img = Storage::url($fileName);//这样商户的图片后台也可以访问
        $img = $request->goods_img;//因为使用了阿里云上传图片，返回的也是完整路径，所以不需要再获取路径

        $rating = 0;//评分
        $month_sales = 99;//月销量-
        $rating_count= 999;//评分数量
        $satisfy_count = 666;//满意度数量
        $satisfy_rate = 6.6;//满意度评分
        $model = nus::create([
            'goods_name'=>$request->goods_name,
            'rating'=>$rating,
            'shop_id'=>$request->shop_id,
            'category_id'=>$request->category_id,
            'goods_price'=>$request->goods_price,
            'description'=>$request->description,
            'month_sales'=>$month_sales,
            'rating_count'=>$rating_count,
            'tips'=>$request->tips,
            'satisfy_count'=>$satisfy_count,
            'satisfy_rate'=>$satisfy_rate,
            'goods_img'=>$img,
            'status'=>$request->status,
        ]);
        //设置提示信息
        session()->flash('success','添加菜品成功');
        return redirect()->route('nu.index');//跳转到
    }
    //菜品修改页面
    public function edit(nus $nu)
    {
        //获得商家信息
        $shops = DB::table('shops')->get();
        //获得菜品分类信息
        $menu_category = DB::table('menu_categories')->get();
        return view('menu/edit',compact(['menu_category','shops','nu']));
    }
    //菜品修改功能
    public function update(nus $nu,Request $request)
    {
//        dd(123);
        //验证数据
        $this->validate($request,[
            'goods_name'=>'required|max:20|unique:menus',
            'goods_price'=>'required',
            'tips'=>'required',
            'goods_img'=>'required',
        ],[
            'goods_name.required'=>'菜品名不能为空',
            'goods_name.max'=>'菜品名不能大于20个字',
            'goods_name.unique'=>'菜品名已存在',
            'goods_price.unique'=>'价格不能为空',
            'description.unique'=>'描述不能为空',
            'tips.unique'=>'提示信息不能为空',
            'goods_img.unique'=>'商品图片不能为空',
        ]);

        //处理上传文件
        if($request->goods_img){
            //处理上传文件
//            $file = $request->goods_img;
//            //使用这个要开启storage   php artisan storage:link
//            $fileName = $file->store('public/goods_img');//获得保存图片路径，返回地址
//            $img = Storage::url($fileName);//这样商户的图片后台也可以访问
            $img = $request->goods_img;//因为使用了阿里云上传图片，返回的也是完整路径，所以不需要再获取路径
        }else{
            $img = $nu->goods_img;
        }
        $rating = 0;//评分
        $month_sales = 99;//月销量-
        $rating_count= 999;//评分数量
        $satisfy_count = 666;//满意度数量
        $satisfy_rate = 6.6;//满意度评分
        $model = $nu->update([
            'goods_name'=>$request->goods_name,
            'rating'=>$rating,
            'shop_id'=>$request->shop_id,
            'category_id'=>$request->category_id,
            'goods_price'=>$request->goods_price,
            'description'=>$request->description,
            'month_sales'=>$month_sales,
            'rating_count'=>$rating_count,
            'tips'=>$request->tips,
            'satisfy_count'=>$satisfy_count,
            'satisfy_rate'=>$satisfy_rate,
            'goods_img'=>$img,
            'status'=>$request->status,
        ]);
        //设置提示信息
        session()->flash('success','修改菜品成功');
        return redirect()->route('nu.index');//跳转到
    }
    //查看菜品详情
    public function show(nus $nu)
    {
        //获得商家信息
        $shops = DB::table('shops')->get();
        //获得菜品分类信息
        $menu_category = DB::table('menu_categories')->get();
        return view('menu/show',compact(['menu_category','shops','nu']));
    }
    //删除菜品
    public function destroy(nus $nu)
    {
        $nu->delete();
        session()->flash('success','删除菜品成功');
        return redirect()->route('nu.index');//跳转
    }
    //文件接收服务端
    public function upload()
    {
        $storage = \Illuminate\Support\Facades\Storage::disk('oss');
        $fileName = $storage->putFile('eleb/menus',request()->file('file'));//upload,file名字是在控制台错误文件header下找到的
        return [
            'fileName'=>$storage->url($fileName)//fileName作为响应内容名
        ];
    }
    //菜品统计
    public function count(Request $request)
    {
        $menu = DB::select("select s.shop_name,m.goods_name,m.goods_img,m.goods_price,sum(g.goods_id) as `sum` 
from `menus` as m 
join `shops` as s on s.id=m.shop_id 
join `order_goods` as g on g.goods_id=m.id
group by g.goods_id
order by `sum` desc
 limit 0,10");
        $count='';
        foreach ($menu as $sum){
            $count +=$sum->sum;
        }
        return view('menu/count',compact('keyword','menu','count'));
    }
    public function count_day(Request $request)
    {
        $count=0;
        $keyword = $request->keyword;
        if(!$keyword){
            $keyword = date('Y-m',time());
        }
        $menu = DB::select("select s.shop_name,m.goods_name,m.goods_img,m.goods_price,sum(g.goods_id) as `sum` 
from `menus` as m 
join `shops` as s on s.id=m.shop_id 
join `order_goods` as g on g.goods_id=m.id
where g.created_at like '%{$keyword}%' 
group by g.goods_id
order by `sum` desc
 limit 0,10");
        $count='';
        foreach ($menu as $sum){
            $count +=$sum->sum;
        }
        return view('menu/count_day',compact('keyword','menu','count'));
    }
    public function count_month(Request $request)
    {
        $count=0;
        $keyword = $request->keyword;
        if(!$keyword){
            $keyword = date('Y-m',time());
        }
        $menu = DB::select("select s.shop_name,m.goods_name,m.goods_img,m.goods_price,sum(g.goods_id) as `sum` 
from `menus` as m 
join `shops` as s on s.id=m.shop_id 
join `order_goods` as g on g.goods_id=m.id
where g.created_at like '%{$keyword}%' 
group by g.goods_id
order by `sum` desc
 limit 0,10");
        $count='';
        foreach ($menu as $sum){
            $count +=$sum->sum;
        }
        return view('menu/count_month',compact('keyword','menu','count'));
    }
}
