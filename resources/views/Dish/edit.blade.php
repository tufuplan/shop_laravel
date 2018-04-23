@extends('Default.default')
@section('title','商户修改产品信息')
@section('content')
    <form method="post" action="{{route('dishs.update',$dish)}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">菜名</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="菜名" value="{{$dish->name}}">
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="price">价格</label>
                <input type="text" class="form-control" name="price" id="price" placeholder="价格" value="{{$dish->price}}">
            </div>
            {{csrf_field()}}
            {{method_field('PUT')}}
            <div class="form-group">
                <label for="fcategory">分类</label>
                <select class="form-control" name="fcategory" id="fcategory">
                    @foreach($Fcategories as $fcategory)
                        <option value="{{$fcategory->id}}"{{$dish->fcategory_id==$fcategory->id?'selected':''}}>{{$fcategory->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="cover">菜品封面图</label>
                原图片:<img src="{{$dish->cover}}" alt="">
                <input type="file" id="cover" name="cover">
            </div>
            <textarea name="detail"  class="form-control">{{$dish->detail}}</textarea>
            <button type="submit" class="btn btn-default">提交</button>
    </form>
@stop