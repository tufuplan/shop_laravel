@extends('Default.default')
@section('title','商户修改分类信息')
@section('content')
    <form method="post" action="{{route('fcategories.update',$fcategory)}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">菜品分类名称:</label>
            <input type="text" class="form-control" id="name" placeholder="菜品分类名称" name="name" value="{{$fcategory->name}}">
        </div>
        <div class="form-group">
            <label for="detail">分类描述</label>
            <textarea class="form-control" id="detail" name="detail">
                    {{$fcategory->detail}}
                </textarea>
        </div>
        {{csrf_field()}}
        {{method_field('PUT')}}
        <div class="form-group">
            <label for="cover">分类封面图</label>
            原图片:<img src="{{$fcategory->cover}}" alt="">
            <input type="file" id="cover" name="cover">
            <p class="help-block">分类图片具有代表性</p>
        </div>
        <div class="radio ">
            <label>
                默认选中: <input type="radio" class="radio form-group" name="is_selected" value="1" {{$fcategory->is_selected==1?'checked':''}}>
            </label>
            <label>
                默认不选中:  <input type="radio" class="radio form-group" name="is_selected" value="0"
                        {{$fcategory->is_selected==0?'checked':''}}>
            </label>
        </div>
        <div style="margin-top: 20px">
            <button type="submit" class="btn btn-default">修改分类</button>
        </div>
    </form>
        @stop
