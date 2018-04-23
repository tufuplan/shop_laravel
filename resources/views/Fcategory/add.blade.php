@extends('Default.default')
@section('title','商户添加菜品分类')
    @section('content')
    <form method="post" action="{{route('fcategories.store')}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">菜品分类名称:</label>
            <input type="text" class="form-control" id="name" placeholder="菜品分类名称" name="name" value="{{old('name')}}">
        </div>
        <div class="form-group">
            <label for="detail">分类描述</label>
            <textarea class="form-control" id="detail" name="detail">
                    {{old('detail')}}
                </textarea>
        </div>
        {{csrf_field()}}

        <div class="form-group">
            <label for="cover">分类封面图</label>
            <input type="file" id="cover" name="cover">
            <p class="help-block">分类图片具有代表性</p>
        </div>
        <div class="radio ">
            <label>
                默认选中: <input type="radio" class="radio form-group" name="is_selected" value="1">
            </label>
            <label>
                默认不选中:  <input type="radio" class="radio form-group" name="is_selected" value="0">
            </label>
        </div>
        <div style="margin-top: 20px">
            <button type="submit" class="btn btn-default">马上添加分类</button>
        </div>
    </form>
        @stop
