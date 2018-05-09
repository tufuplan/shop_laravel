@extends('Default.default')
@section('title','按日期统计订单量');
@section('content')
    <table class="table table-condensed">
        <tr>
            <th>时间</th>
            <th>订单量</th>
        </tr>
        <tr>
            <td>{{$choose_month."====".$next_month}}</td>
            <td>{{$num}}</td>
        </tr>
    </table>
@stop