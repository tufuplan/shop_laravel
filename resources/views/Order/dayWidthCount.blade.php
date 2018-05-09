@extends('Default.default')
@section('title','按时间范围查询订单量')
    @section('content')
        <form method="post" action="{{route('dayWidthNum')}}">
            <div class="form-group">
                <label for="start_time">开始时间</label>
                <input type="date" class="form-control" name="start_time" id="start_time" value="{{old('start_time')}}">
            </div>
            <div class="form-group">
                <label for="end_time">结束时间</label>
                {{csrf_field()}}
                <input type="date" class="form-control" name="end_time" id="end_time"
                value="{{old('end_time')}}">
            </div>
            <button type="submit" class="btn btn-default">提交</button>
        </form>
        @stop
