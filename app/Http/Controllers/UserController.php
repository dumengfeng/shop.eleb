<?php

namespace App\Http\Controllers;

use App\Models\Shops;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
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
        $all = User::all();;
        return view('user/index', compact('all', [$all]));
    }

    public function create()
    {
        $shopcategories = DB::table('shopcategories')->get();
        return view('user/create', compact('shopcategories', $shopcategories));
    }

    public function store(Request $request)
    {

        //数据验证
        $this->validate($request, [
            'name' => 'required|max:10',
            'email' => 'required',
            'password' => 'required|same:repassword',
            'shop_name' => 'required',
            'shop_img' => 'required',
            'start_send' => 'required',
            'send_cost' => 'required',
            'notice' => 'required',
            'discount' => 'required',
        ], [
            'name.required' => '账号名称不能为空',
            'name.max' => '账号名称不能超过10个字',
            'email.required' => '账号邮箱不能为空',
            'password.required' => '账号密码不能为空',
            'password.same' => '账号密码与确认密码不能相同',
            'shop_name.required' => '店铺名称不能为空',
            'shop_img.required' => '店铺图片不能为空',
            'start_send.required' => '起送金额不能为空',
            'send_cost.required' => '配送费不能为空',
            'notice.required' => '店公告不能为空',
            'discount.required' => '优惠信息不能为空',
        ]);
        DB::beginTransaction();
        //处理上传文件
        $file = $request->shop_img;

//        dd($request->shop_img);
//        $storage = Storage::disk('oss');
//        $filename = $storage->putFile('shops',$request->shop_img);
//        var_dump(url($filename));exit;
        $re1 = Shops::create([
            'shop_name' => $request->shop_name,
            'shop_category_id' => $request->shop_category_id,
//            'shop_img' => $storage->url($filename),
            'shop_img'=>$request->shop_img,
            'brand' => $request->brand,
            'on_time' => $request->on_time,
            'fengniao' => $request->fengniao,
            'bao' => $request->bao,
            'piao' => $request->piao,
            'zhun' => $request->zhun,
            'start_send' => $request->start_send,
            'send_cost' => $request->send_cost,
            'notice' => $request->notice,
            'discount' => $request->discount,
            'shop_rating' => 10,
            'status' => 0,
        ]);

        $re2 = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => 0,
            'shop_id' => $re1->id,
        ]);
        if ($re1 && $re2) {   //判断两条同时执行成功
            DB::commit();  //提交
            session()->flash('success', '添加成功');
            return redirect()->route('user.index');
        } else {
            　　　　DB::rollback();  //回滚
            　　　　session()->flash('success', '添加成功');
        }
    }

    public function edit(user $user)
    {
        $shopcategories = DB::table('shopcategories')->get();
        return view('user/edit', ['edit' => $user, 'shopcategories' => $shopcategories]);
    }

    public function update(user $user, Request $request)
    {
        //数据验证
        $this->validate($request, [
            'name' => 'required|max:10',
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'shop_name' => 'required',
            'shop_img' => 'required',
            'start_send' => 'required',
            'send_cost' => 'required',
            'notice' => 'required',
            'discount' => 'required',
        ], [
            'name.required' => '账号名称不能为空',
            'name.max' => '账号名称不能超过10个字',
            'shop_img.required' => '图片不能为空',
            'email.required' => '邮箱不能为空',
            'email.unique' => '邮箱不能相同',
            'start_send.required' => '起送金额不能为空',
            'send_cost.required' => '配送费不能为空',
            'notice.required' => '店公告不能为空',
            'discount.required' => '优惠信息不能为空',
        ]);

        //处理上传文件
        $file = $request->shop_img;
        $filename = Storage::url($file->store('public/img'));
       $re1 = DB::table('shops')->update([
        'shop_name' => $request->shop_name,
        'shop_category_id' => $request->shop_category_id,
        'shop_img' => url($filename),
        'brand' => $request->brand,
        'on_time' => $request->on_time,
        'fengniao' => $request->fengniao,
        'bao' => $request->bao,
        'piao' => $request->piao,
        'zhun' => $request->zhun,
        'start_send' => $request->start_send,
        'send_cost' => $request->send_cost,
        'notice' => $request->notice,
        'discount' => $request->discount,
        'shop_rating' => 10,
        'status' => 0,
    ]);
//        $re1 = $shop->update();

        $re2 = $user->update(['name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => 0,
            'shop_id' => $user->id,]);
            session()->flash('success', '添加成功');
            return redirect()->route('user.index');



    }

    public
    function destroy(user $user)
    {
        $user->delete();
        return redirect()->route('user.index');
    }
    //修改密码
    public function pwd(user $user)
    {
        return view('user/password', ['edit' => $user]);

    }
    public function save(user $user, Request $request)
    {
//Rule::unique('')->ignore($request->id)
        //数据验证
        $this->validate($request, [
            'oldpassword' => 'required',
            'password' => 'required|same:repassword',
            'repassword' => 'required',


        ], [
            'oldpassword.required' => '旧密码不能为空',
            'password.required' => '新密码不能为空',
            'repassword.required' => '确认密码不能为空',
            'password.same' => '确认密码与新密码不能相同',
        ]);
        $oldpassword=auth()->user()->password;

        $password = $request->oldpassword;
        if (Hash::check($password,$oldpassword)) {
            $user->update([
                'password' => bcrypt($request->password),
                ]);
            session()->flash('success', '修改成功');
            return redirect()->route('user.index');
        }
        session()->flash('danger', '修改失败');
        return redirect()->route('user.index');
    }
}
