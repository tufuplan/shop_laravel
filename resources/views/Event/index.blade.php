@extends('Default.default')
@section('title','活动列表页')
    @section('content')
        <table class="table" id="mytable">
            <tr>
                <th>活动标题</th>
                <th>活动状态</th>
                <th>活动开始时间</th>
                <th>活动结束时间</th>
                <th>活动开奖时间</th>
                <th>最多参加人数</th>
                <th>操作</th>
            </tr>
            @foreach($events as $event)
            <tr data-id="{{$event->id}}">
                <td>{{$event->title}}</td>
                <td>{{$event->is_prize==1?'已开奖':'未开奖'}}</td>
                <td>{{date('Y-m-d',$event->signup_start)}}</td>
                <td>{{date('Y-m-d',$event->signup_end)}}</td>
                <td>{{$event->prize_date}}</td>
                <td>{{$event->signup_num}}</td>
                <td>
                    <a href="/result?id={{$event->id}}" class="btn btn-link">查看抽奖结果</a>
                    <a href="{{route('prize.index',$event)}}" class="btn btn-default">查看该活动奖品列表</a>
                    <a href="{{route('event.show',$event)}}" class="btn btn-primary">查看活动详情</a>
                </td>
            </tr>
                @endforeach
        </table>
        @stop

