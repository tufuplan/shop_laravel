@extends('Default.default')
@section('title','商户添加页面')
    @section('content')
        <form method="post" action="{{route('shops.store')}}" enctype="multipart/form-data">
            <div class="form-group">
                <label for="account">商户账号</label>
                <input type="text" class="form-control" id="account" placeholder="账号" name="account" value="{{old('account')}}">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">密码</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
            </div>
            {{csrf_field()}}
            <div class="form-group">
                <label for="exampleInputPassword2">确认密码</label>
                <input type="password" class="form-control" name="password_confirmation" id="exampleInputPassword2" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">上传商家logo</label>
                <input type="file" id="exampleInputFile" name="logo">
                <p class="help-block">上传logo</p>
            </div>
            <span>
                选择所属分类
            </span>
            <select class="form-control" name="category_id" id="category_id">
                    @foreach($Categorys as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
            </select>
            <div>
            <label class="checkbox-inline">
                <input type="checkbox" id="inlineCheckbox1" value="1" name="brand"> 是否品牌
            </label>
            <label class="checkbox-inline" >
                <input type="checkbox" id="inlineCheckbox1" value="1" name="zhun"> 是否能准时到达
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" id="inlineCheckbox1" value="1" name="fengniao"> 是否是蜂鸟配送
            </label>
            </div>
            <div>
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox1" value="1" name="bao"> 是否保
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox1" value="1" name="piao"> 是否票
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" id="inlineCheckbox1" value="1" name="zhunMarket"> 是否准标记
                </label>
            </div>
            <span>起送金额</span>
            <input type="text" class="form-control" placeholder="输入起送金额" value="{{old('start_send')}}" name="start_send">
            <span>配送金额</span>
            <input type="text" class="form-control" placeholder="输入配送金额" value="{{old('send_cost')}}" name="send_cost">
            <span>输入公告</span>
            <input type="text" class="form-control" placeholder="输入公告" name="notice" value="{{old('notice')}}">
            <span>打折宣传语</span>
            <input type="text" class="form-control" placeholder="打折优惠语" name="discount" value="{{old('discount')}}">
            <button type="submit" class="btn btn-default">注册</button>

        </form>

    @stop
