<?php

namespace App\Http\Controllers;

use App\Prize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrizeController extends Controller
{
    //显示对应活动下的奖品列表
    public function index(Request $request)
    {

        $event_id = substr($request->getRequestUri(),-1,1);
        //根据活动的id找到当前的奖品
        $event = DB::table('events')->where('id',$event_id)->first();
        $prizes= Prize::query()->where('events_id',$event_id)->get();
        return view('Prize.index',compact(['event','prizes']));
    }
}
