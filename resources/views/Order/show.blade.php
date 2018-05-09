@extends('Default.default')
@section('title','指定订单详情')
@section('content')
    <table class="table mytable">
        <tr>
            <th>订单编号</th>
            <th>订单状态</th>
            <th>订单生成时间</th>
            <th>客户姓名</th>
            <th>客户电话号码</th>
            <th>客户地址</th>
            <th>订单总价</th>
            <th>订单状态</th>
            <th>操作</th>
        </tr>
            <tr>
                <td>{{$order->order_code}}</td>
                <td>{{$order->order_status}}</td>
                <td>{{$order->created_at}}</td>
                <td>{{$order->Receiver}}</td>
                <td>{{$order->phone}}</td>
                <td>{{$order->province.$order->city.$order->area.$order->detail}}</td>
                <td>{{$order->total_price}}</td>
                <td>{{$order->order_status==1?'已发货':"未发货或取消发货"}}</td>
                <td>
                    @if($order->order_status==0)
                    <a href="{{route('orders.edit',$order)}}">发货</a>
                    @else
                    <a href="{{route('orders.edit',$order)}}">取消发货</a>
                        @endif
                </td>
            </tr>

    </table>
    订单下商品
    <table class="table">
        <tr>
            <th>商品名称</th>
            <th>商品图片</th>
            <th>商品数量</th>
            <th>商品价格</th>
        </tr>
        @foreach($goods_list as $goods)
        <tr>
            <td>{{$goods->good_name}}</td>
            <td><img src="{{$goods->good_image}}" alt="商品图片" width="100px"></td>
            <td>{{$goods->amount}}</td>
            <td>{{$goods->good_price}}</td>
        </tr>
            @endforeach
    </table>
@stop