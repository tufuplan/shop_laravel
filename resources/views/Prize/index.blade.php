@extends('Default.default')
@section('title','活动列表页')
    @section('content')
        <h1>{{$event->title}}</h1>
        <table class="table" id="mytable">
            <tr>
                <th>奖品名称</th>
                <th>奖品描述</th>
            </tr>
            @foreach($prizes  as $prize)
            <tr data-id="{{$prize->id}}">
                <td>{{$prize->name}}</td>
                <td>{{$prize->description}}</td>
            </tr>
            @endforeach
        </table>
        @stop

