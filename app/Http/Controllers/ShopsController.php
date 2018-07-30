<?php

namespace App\Http\Controllers;

use App\Models\Shops;
use Illuminate\Http\Request;

class ShopsController extends Controller
{
    public function index()
    {
        $all = Shops::all();;
        return view('shops/index',compact('all',[$all]));
    }

    public function create()
    {
        return view('shops/create');
    }
    public function store(Request $request)
    {
        //数据验证
        $this->validate($request,[
            'name'=>'required|max:10',
            'img'=>'required',
            'status'=>'required',
        ],[
            'name.required'=>'分类名不能为空',
            'name.max'=>'分类名不能超过10个字',
            'img.required'=>'图片不能为空',
            'status.required'=>'状态不能为空',
        ]);
        //处理上传文件
        $file = $request->img;
        $filename = $file->store('public/img');
        $model = shops::create([
            'name'=>$request->name,
            'img'=>$request->img,
            'status'=>$request->status,
            'img'=>$filename,
        ]);
        //设置提示信息
        session()->flash('success','添加成功');
        return redirect()->route('shops.index');
    }

    public function edit(shops $shopCategory)
    {
        return view('shops/edit',['edit'=>$shopCategory]);
    }
    public function update(shops $shopCategory,Request $request)
    {
//Rule::unique('')->ignore($request->id)
        //数据验证
        $this->validate($request,[
            'name'=>['required','max:10',Rule::unique('shops')->ignore($shopCategory->id)],
            'img'=>'required',
            'status'=>'required',
        ],[
            'name.required'=>'分类名不能为空',
            'name.max'=>'分类名不能超过10个字',
            'img.required'=>'图片不能为空',
            'status.required'=>'状态不能为空',
            'name.unique'=>'分类名不能相同'
        ]);
        //处理上传文件
        $file = $request->img;
        $filename = $file->store('public/img');
        $shopCategory->update([
            'name'=>$request->name,
            'status'=>$request->status,
            'img'=>$filename,
        ]);
        return redirect()->route('shops.index');
    }

    public function destroy(shops $shopCategory)
    {
        $shopCategory->delete();
        return redirect()->route('shops.index');
    }
}
