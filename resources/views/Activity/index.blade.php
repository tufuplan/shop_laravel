@extends('Default.default')
@section('title','活动列表页')
    @section('content')
        <table class="table" id="mytable">
            <tr>
                <th>活动标题</th>
                <th>活动状态</th>
                <th>活动开始时间</th>
                <th>活动结束时间</th>
            </tr>
            @foreach($Activities as $activity)
            <tr data-id="{{$activity->id}}">
                <td><a href="/show?id={{$activity->id}}">{{$activity->name}}</a></td>
                <td>{{$activity->status==1?'火热进行中':'未进行'}}</td>
                <td>{{date('Y-m-d',$activity->start_time)}}</td>
                <td>{{date('Y-m-d',$activity->end_time)}}</td>
            </tr>
                @endforeach
        </table>
        @stop

