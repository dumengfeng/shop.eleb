<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $all = Order::where('shop_id',auth()->user()->id)->paginate(2);
        return view('order/index',compact('all',[$all]));
    }
    //显示单个订单
    public function show(Order $order)
    {
//        dd($request);
        $res = Order::select()->where('id',$order->id)->first();
//        dd($res);
        return view('order/show',compact('res',[$res]));
    }
    //订单发货
    public function ship(Order $Order)
    {
        $rel = Order::where([['user_id',auth()->user()->id],['id',$Order->id]])->first();
//        dd($Order);
        if($rel->status==2){
            session()->flash('warning','已发货');
            return redirect()->route('order.index');
        }
        $rel->update([
            "status"=>2,
        ]);

        if (!$rel){
            session()->flash('danger','发货失败,请重试');
            return redirect()->route('order.index');
        }
        session()->flash('success','成功发货,等待确认');
        return redirect()->route('order.index');
    }
    //取消订单
    public function cancel(Order $Order)
    {
        $rel = Order::where([['user_id',auth()->user()->id],['id',$Order->id]])->first();
//        dd($Order);
        if($rel->status==-1){
            session()->flash('warning','已取消');
            return redirect()->route('order.index');
        }
        $rel->update([
            "status"=>-1,
        ]);

        if (!$rel){
            session()->flash('danger','取消失败,请重试');
            return redirect()->route('order.index');
        }
        session()->flash('success','取消成功');
        return redirect()->route('order.index');
    }
    //订单统计
    public function count(Request $request)
    {
        $count=0;
            $all = Order::where('shop_id',auth()->user()->id)->get();
            $count = count($all);
        return view('order/count',compact('all','count'));
    }
    public function count_day(Request $request)
    {
        $count=0;
        $keyword = $request->keyword;
        if(!$keyword){
            $keyword = date('Y-m-d',time());
        }
//        dd($keyword);
        $all = Order::where([['created_at','like',"%{$keyword}%"],['shop_id',auth()->user()->id]])->get();

        $count = count($all);
        return view('order/count_day',compact('keyword','count'));
    }
    public function count_month(Request $request)
    {
        $count=0;
        $keyword = $request->keyword;
        if(!$keyword){
            $keyword = date('Y-m',time());
        }
        $all = Order::where([['created_at','like',"%{$keyword}%"],['shop_id',auth()->user()->id]])->get();
        $count = count($all);
        return view('order/count_month',compact('keyword','count'));
    }
}
