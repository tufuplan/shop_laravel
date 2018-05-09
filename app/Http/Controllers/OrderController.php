<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //显示订单列表
    public function index(Request $request)
    {
        if($request->month){
            $keyword = $request->month;
            $year =  date('Y', strtotime($keyword));//当前年
            $nextmonth = date('m',strtotime($keyword))+1;//下一个月
            $count = DB::tale('orders')->select("select count(*) from orders where created_at BETWEEN $keyword  and  $year.'-'.$nextmonth");
        }
        if($request->all){
            $keyword = '';
            $count = DB::table('orders')->count();
        }
        $shop_id  = Auth::user()->id;//商家id
        //找到商家的所有订单
        $orders = Order::where('shop_id',$shop_id)->paginate(5);
        return view('Order.index',compact(['orders','count']));
    }
    //商家查看订单详情
    public function show(Order $order)
    {
        $order_id = $order->id; //订单的id
        //找到订单下的所有商品信息
       $goods_list =  DB::table('order_dishes')->where('order_id',$order_id)->get();
       $price= 0;
        foreach ($goods_list as $good){
            $price += ($good->good_price)*($good->amount);
        }
        $order->total_price = $price;
        return view('Order.show',compact(['order','goods_list']));
    }
    //商家发货更改发货更改发货状态
    public function edit(Order $order)
    {
        $order->update([
            'order_status'=>($order->order_status==0?1:0)
        ]);
        //成功提示
        session()->flash('success','修改发货状态成功');
        //跳转到列表
        return redirect()->route('orders.index');
    }
    //商家统计一天有多少订单
    public function dayCount()
    {
        $id = Auth::user()->id;
            $day = $_POST['day'];
            $day =  htmlspecialchars($day);
            $preday = date('Y-m-d',strtotime($day)-24*60*60)." 23:59:59";
            $today = $day." 23:59:59";
//        $count  =   DB::table('orders')->where('created_at',$day)->count();
        $count = DB::table('orders')
            ->select(DB::raw('count(*) as order_count'))
            ->where('created_at', '>', $preday)
            ->where('created_at','<',$today)
            ->where('shop_id','=',$id)
            ->first();
        $num = $count->order_count;
            return view('Order.daycount',compact(['num','day']));

    }
    //统计时间范围内有多少个订单 显示提交订单
    public function dayWidthCount()
    {

     return view("Order.dayWidthCount");
    }
    //处理按时间范围查询
    public function dayWidthCountDeal(Request $request)
    {
        $this->validate($request,[
            'start_time'=>'required|date|before:today',
            'end_time'=>'required|date|after:start_time|before:today'
        ],[
            'start_time.required'=>'开始时间不能为空',
            'start_time.date'=>'开始时间必须是一个日期',
            'start_time.before'=>'开始时间必须是今天之前',
            'end_time.required'=>'结束时间不能为空',
            'end_time.date'=>'结束时间必须是个日期',
            'end_time.after'=>'结束时间至少是开始时间之后',
            'end_time.before'=>'结束时间不能是今天,若要查看今天的订单请在列表首页查看'
        ]);
        $start_time = $request->start_time." 0:0:0";
        $end_time = $request->end_time." 23:59:59";
        //数据验证完成
        //查询数据库
       $id =  Auth::user()->id;
        $count = DB::table('orders')
            ->select(DB::raw('count(*) as order_count'))
            ->where('created_at', '>=', $start_time)
            ->where('created_at','<=',$end_time)
            ->where('shop_id','=',$id)
            ->first();
        $num = $count->order_count;
        session()->flash('success','查询成功');
         return  view('Order.dayWidthCountResult',compact(['num','start_time','end_time']));

    }
    //处理按月查询
    public function monthCount(Request $request)
    {
            $select_month = strtotime($request->month);
                $current_month = strtotime(date("Y-m",time()));
                if($select_month>$current_month){
                    session()->flash('danger','未来的月份不可查询');
                    return redirect()->back()->withInput();
                }
                $choose_month = $request->month;
               $next_month =  date("Y-m",strtotime("+1 month",$select_month));
               $id = Auth::user()->id;
        $count = DB::table('orders')
            ->select(DB::raw('count(*) as order_count'))
            ->where('created_at', '>=', $choose_month)
            ->where('created_at','<=',$next_month)
            ->where('shop_id','=',$id)
            ->first();
        $num = $count->order_count;
        return  view('Order.monthCount',compact(['num','choose_month','next_month']));





    }
    //总查询
    public function allCount(Request $request)
    {
       $id =  Auth::user()->id;
       $num = DB::table('orders')->where('shop_id',$id)->count();
       return view('Order.allcount',compact('num'));
    }
    //商家菜品查询统计
    public function dishCount()
    {
       //查出所有数据显示在页面中
        //商户所有菜卖了多少
        $shop_id = Auth::user()->id;
        $rows = DB::table('order_dishes')
            ->join('orders','order_dishes.order_id','=','orders.id')
            ->join('businesses','orders.shop_id','=','businesses.id')
            ->select('businesses.account','order_dishes.good_name',DB::raw('sum(order_dishes.amount) as amount'))
            ->where('orders.shop_id','=',$shop_id)
            ->groupBy('order_dishes.good_name','businesses.account')
            ->orderBy('amount','desc')
            ->get();
        $shop_name = $rows->first()->account;
        $goods_name = [];
        $goods_amount = [];
        foreach ($rows as $row){
            $goods_name[] = $row->good_name;
            $goods_amount[] = $row->amount;
        }
        $array_all = array_combine($goods_name,$goods_amount);
        //商家今日卖了多少
        $today = date("Y-m-d",time())." 0:0:0";
        $current = date('Y-m-d H:i:s');
        $rows = DB::table('order_dishes')
            ->join('orders','order_dishes.order_id','=','orders.id')
            ->join('businesses','orders.shop_id','=','businesses.id')
            ->select('businesses.account','order_dishes.good_name',DB::raw('sum(order_dishes.amount) as amount'))
            ->where('orders.shop_id','=',$shop_id)
            ->where('orders.created_at','>',$today)
            ->where('orders.created_at','<',$current)
            ->groupBy('order_dishes.good_name','businesses.account')
            ->orderBy('amount','desc')
            ->get();
        $goods_name_today = [];
        $goods_amount_today = [];
        foreach ($rows as $row){
            $goods_name_today[] = $row->good_name;
            $goods_amount_today[] = $row->amount;
        }
        $array_today = array_combine($goods_name_today,$goods_amount_today);
        if($array_today==[]){
            $array_today = ['today','今日还没有订单'];
        }
        //商家当月卖了多少
        $current_month= date("Y-m-01",time())." 0:0:0";
        $time = date("Y-m-d H:i:s",time());
        $rows = DB::table('order_dishes')
            ->join('orders','order_dishes.order_id','=','orders.id')
            ->join('businesses','orders.shop_id','=','businesses.id')
            ->where('orders.shop_id','=',$shop_id)
            ->where('orders.created_at','>',$current_month)
            ->where('orders.created_at','<',$time)
            ->select('businesses.account','order_dishes.good_name',DB::raw('sum(order_dishes.amount) as amount'))
            ->groupBy('order_dishes.good_name','businesses.account')
            ->orderBy('amount','desc')
            ->get();
        $goods_name_month = [];
        $goods_amount_month = [];
        foreach ($rows as $row){
            $goods_name_month[] = $row->good_name;
            $goods_amount_month[] = $row->amount;
        }
        $array_month = array_combine($goods_name_month,$goods_amount_month);
        if($array_month==[]){
            $array_month = ['month'=>'本月还没有订单'];
        }

        return view('Order.shopCount',compact(['array_today','array_all','array_month','shop_name']));

    }
    //商家按时间统计菜品
    public function timeCount(Request $request)
    {
        $this->validate($request,[
            'start_time'=>'required|date|before:today',
            'end_time'=>'required|date|after:start_time|before:today'
        ],[
            'start_time.required'=>'开始时间不能为空',
            'start_time.date'=>'开始时间必须是一个时间',
            'start_time.before'=>'开始时间必须是今天以前',
            'end_time.required'=>'结束时间不能为空',
            'end_time.date'=>'结束时间必须是一个时间',
            'end_time.after'=>'结束时间必须在开始时间以后',
            'end_time.before'=>'结束时间必须在今天以前'
        ]);
        //数据验证完成,进行查询
        $start_time = $request->start_time." 0:0:0";
        $end_time = $request->end_time." 23:59:59";
        $shop_id = Auth::user()->id;
        $rows = DB::table('order_dishes')
            ->join('orders','order_dishes.order_id','=','orders.id')
            ->join('businesses','orders.shop_id','=','businesses.id')
            ->select('businesses.account','order_dishes.good_name',DB::raw('sum(order_dishes.amount) as amount'))
            ->where('orders.shop_id','=',$shop_id)
            ->where('orders.created_at','>',$start_time)
            ->where('orders.created_at','<',$end_time)
            ->groupBy('order_dishes.good_name','businesses.account')
            ->orderBy('amount','desc')
            ->get();
        $shop_name = $rows->first()->account;
        $goods_name = [];
        $goods_amount = [];
        foreach ($rows as $row){
            $goods_name[] = $row->good_name;
            $goods_amount[] = $row->amount;
        }
        $array = array_combine($goods_name,$goods_amount);
        if($array==[]){
            $array = ['没有菜品'=>'这段时间暂时没有销量'];
        }
        return view('Order.timedishCount',compact(['array','shop_name','start_time','end_time']));
    }
}



