@extends('Default.default')
@section('title','商户添加产品信息')
    @section('content')
        <form method="post" action="{{route('dishs.store')}}" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">菜名</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="菜名" value="{{old('name')}}">
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="price">价格</label>
                    <input type="text" class="form-control" name="price" id="price" placeholder="价格" value="{{old('price')}}">
                </div>
                {{csrf_field()}}
                <div class="form-group">
                    <label for="fcategory">分类</label>
                    <select class="form-control" name="fcategory" id="fcategory">
                        @foreach($Fcategories as $fcategory)
                            <option value="{{$fcategory->id}}">{{$fcategory->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <div id="fileList" class="uploader-list"></div>
                    <input type="hidden" value="" id="cover" name="cover">
                    <div id="filePicker">选择图片</div>
                    <div>
                        <img src="" alt="" id="myimg">
                    </div>
                </div>
                <textarea name="detail"  class="form-control">{{old('detail')}}</textarea>
                <button type="submit" class="btn btn-default">提交</button>
        </form>
        @stop

