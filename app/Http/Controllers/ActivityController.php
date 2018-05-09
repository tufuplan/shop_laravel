<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    //显示平台活动列表
    public function index()
    {
        $Activities = Activity::all();
        return view('Activity.index',compact('Activities'));
    }
    //查看某个活动详情
    public function show()
    {
       $id = $_GET['id'];
       $activity = Activity::find($id);
        return view('Activity.show',compact('activity'));
    }

}
