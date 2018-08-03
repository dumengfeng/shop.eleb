<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMember;
use Illuminate\Http\Request;

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
//        dd(null !==(EventMember::where([['member_id',auth()->user()->id],['events_id',$event->id]])->first()));
        $Event_num=count(EventMember::where([['member_id',auth()->user()->id],['events_id',$event->id]])->get());
        if ($Event_num<Event::select('signup_num')->where('id',$event->id)->first()->signup_num){
            if (null !==(EventMember::where([['member_id',auth()->user()->id],['events_id',$event->id]])->first())){
                session()->flash('warning','该账号已报名');
                return redirect()->route('Event.index');
            }
            EventMember::create([
                'events_id'=>$event->id,
                'member_id'=>auth()->user()->id,
            ]);
        }else{
            session()->flash('warning','报名人数已满');
            return redirect()->route('Event.index');
        }
        session()->flash('success','报名成功');
        return redirect()->route('Event.index');
    }

}
