<?php

namespace App\Http\Controllers;
use App\Models\MenuCategory;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            //'only'=>['info'],//该中间件只对这些方法生效
            'except'=>['index'],//该中间件除了这些方法，对其他方法生效
        ]);
    }
    public function index()
    {
        $all = MenuCategory::all();
        return view('MenuCategories/index',compact('all',[$all]));
    }

    public function create()
    {
        return view('MenuCategories/create');
    }
    public function store(Request $request)
    {
        //数据验证
        $this->validate($request,[
            'name'=>'required|max:10',
            'description'=>'required',
        ],[
            'name.required'=>'菜品分类名称不能为空',
            'name.max'=>'菜品分类名称不能超过10个字',
            'description.required'=>'菜品描述不能为空',
        ]);
        $model = MenuCategory::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'type_accumulation'=>uniqid(),
            'shop_id'=>auth()->user()->id,
            'is_selected'=>0,
        ]);
        //设置提示信息
        session()->flash('success','添加成功');
        return redirect()->route('MenuCategories.index');
    }

    public function edit(MenuCategory $MenuCategory)
    {
        return view('MenuCategories/edit',['edit'=>$MenuCategory]);
    }
    public function update(MenuCategory $MenuCategory,Request $request)
    {
//Rule::unique('')->ignore($request->id)
        //数据验证
        //数据验证
        $this->validate($request,[
            'name'=>'required|max:10',
            'description'=>'required',
        ],[
            'name.required'=>'菜品分类名称不能为空',
            'name.max'=>'菜品分类名称不能超过10个字',
            'description.required'=>'菜品描述不能为空',
        ]);
        //
        $MenuCategory->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'type_accumulation'=>uniqid(),
            'shop_id'=>auth()->user()->id,
            'is_selected'=>$request->is_selected,
        ]);
        //设置提示信息
        session()->flash('success','添加成功');
        return redirect()->route('MenuCategories.index');
    }

    public function destroy(MenuCategory $MenuCategory)
    {
        $MenuCategory->delete();
        return redirect()->route('MenuCategories.index');
    }

    public function mr(MenuCategory $MenuCategory,Request $request)
    {
        $is_selected = MenuCategory::where([
            ['shop_id',auth()->user()->shop_id],
            ['is_selected',1],
            ['id','!=',$MenuCategory->id],
        ])->first();
        if ($is_selected!=null){
            $is_selected->update([
                'is_selected'=>0,
            ]);
            $MenuCategory->update([
                'is_selected'=>1,
            ]);
        }
        $MenuCategory->update([
            'is_selected'=>1,
        ]);
        //设置提示信息
        session()->flash('success','选择成功');
        return redirect()->route('MenuCategories.index');
    }
}
