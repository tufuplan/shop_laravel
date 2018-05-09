@extends('Default.default')
@section('title','订单列表')
@section('content')
    <form method="post" action="{{route('dayCount')}}">
    <div class="form-group">
        <label for="day">日统计</label>
        {{csrf_field()}}
        <input type="date" class="form-control" id="day" name="day">
    </div>
    <button type="submit" class="btn btn-default">日统计</button>
    </form>
    <form method="post" action="{{route('monthCount')}}">
        <div class="form-group">
            <label for="month">月搜索</label>
            <input type="month" class="form-control" id="month" name="month">
        </div>
        {{csrf_field()}}
        <button type="submit" class="btn btn-default">月统计</button>
    </form>
    <form method="post" action="{{route('allCount')}}">
        <div class="form-group">
            <label for="day">总搜索</label>
            <input type="hidden" name="all" value="1">
            {{csrf_field()}}
            </div>
        <button type="submit" class="btn btn-default">总统计</button>
    </form>

    
    <table class="table mytable">
        <tr>
            <th>订单编号</th>
            <th>订单状态</th>
            <th>订单生成时间</th>
            <th>操作</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->order_code}}</td>
                <td>{{$order->order_status}}</td>
                <td>{{$order->created_at}}</td>
                <td>
                    <a href="{{route('orders.show',['order'=>$order])}}" class="btn btn-default">
                        查看订单详情
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
{{$orders->links()}}


@stop


