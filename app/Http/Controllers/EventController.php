<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class EventController extends Controller
{
    //查看活动
    public function index()
    {
        $Event = Event::all();
        return view('Event/index', compact('Event'));
    }

    public function bm(Request $request,Event $event)
    {
        if (null !==(EventMember::where([['member_id',auth()->user()->id],['events_id',$event->id]])->first())){
            session()->flash('warning','该账号已报名');
            return redirect()->route('Event.index');
        }
        $E=Event::find($event->id);//报名的活动
        $total = Redis::incr('total_'.$E->id);
        if($total > $E->signup_num){
            Redis::decr('total_'.$E->id);
            session()->flash('warning','报名人数已满');
            return redirect()->route('Event.index');
        }
        session()->flash('success','报名成功');
        return redirect()->route('Event.index');
    }

    //查看详情
    public function show(Event $Event)
    {
        return view('Event/show',compact('Event'));
    }
    //清理过期订单
    public function CleanOrders()
    {
        set_time_limit(0);
        while (true){
            $time=time();
            DB::update("UPDATE `orders` SET status=-1 WHERE `created_at` <={date('Y-m-d',($time-60*15))} AND status=0");
            sleep(60);
        }
    }

}
