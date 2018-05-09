@extends('Default.default')
@section('title','总统计量');
@section('content')
    <table class="table table-condensed">
        <tr>
            <th>订单量</th>
        </tr>
        <tr>
            <td>{{$num}}</td>
        </tr>
    </table>
    @stop
