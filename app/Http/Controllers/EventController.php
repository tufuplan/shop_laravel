<?php

namespace App\Http\Controllers;

use App\Event;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    //用户产看活动列表
    public function index()
    {
        //查看所有活动
        $events = Event::all();
        return view('Event.index',compact('events'));
    }
    //用户查看活动详情
    public function show(Request $request)
    {
        $event_id = substr($request->getRequestUri(),-1,1);
       $event =  Event::query()->where('id',$event_id)->first();
        return view('Event.show',compact('event'));
    }
    //用户点击参与活动
    public function join (Request $request)
    {
        $Menber_id = Auth::user()->id;
        $event_id = substr($request->getRequestUri(),-1,1);
        $event = Event::query()->where('id',$event_id)->first();
        $result = DB::table('members')->where('member_id',$Menber_id)
            ->where('events_id',$event_id)
            ->first();
        $count = DB::table('members')->where('events_id',$event_id)
            ->count();

        if($count>=$event->signup_num){
            session()->flash('danger','人数已满');
            return redirect()->back();
        }
        if(!$result==null){
            //已经报名该活动
            session()->flash('danger','您已经报名活动');
            return redirect()->back();
        }
        //人数限制

        Member::create([
            'member_id'=>$Menber_id,
            'events_id'=>$event_id
        ]);
        session()->flash('success','您已报名成功');
        return redirect()->route('event.index');

    }
    //
    //查看抽奖结果
    public function result(Request $request)
    {
        //查看该活动是否已经抽奖
        $event_id = $request->id;
        $Event = Event::query()->where('id',$request->id)->first();
        if($Event->is_prize==0){
            session()->flash('danger','该活动尚未开奖');
            return redirect()->back();
        }
        //查出该活动的结果
        $Results = DB::table('prizes')->join('events','events.id','=','prizes.events_id')
            ->join('businesses','prizes.member_id','=','businesses.id')
            ->where('events.id',$event_id)
            ->select('prizes.name','businesses.account')
            ->get();
        return view('Event.result',compact('Results'));

    }

}


