@extends('Default.default')
@section('title','商户菜品列表')
    @section('content')
        <table class="table mytable">
            <tr>
                <th>菜名</th>
                <th>所属分类名</th>
                <th>菜封面图</th>
                <th>菜价格</th>
                <th>描述</th>
                <th>操作</th>
            </tr>
            @foreach($Dishes as $dish)
            <tr data-id="{{$dish->id}}">
                <td>{{$dish->name}}</td>
                <td>{{$dish->fcategory_id}}</td>
                <td><img src="{{$dish->cover}}" width="100px" alt=""></td>
                <td>{{$dish->price}}</td>
                <td>{{$dish->detail}}</td>
                <td>
                    <a class="btn btn-primary" href="{{route('dishs.edit',$dish)}}">修改 </a>
                    <button class="btn  btn-danger">删除</button>
                </td>
            </tr>
                @endforeach
            <tr>
                <td colspan="6" style="text-align: center">
                    <a href="{{route('dishs.create')}}" class="btn btn-default">添加</a>
                </td>
            </tr>
        </table>
        @stop

@section('js')
    <script>
        $(function () {
            $(".mytable .btn-danger").click(function () {
                if(confirm('确认删除么?')){
                    var tr = $(this).closest('tr');
                    var id =tr.attr('data-id');
                    $.ajax({
                        type:'DELETE',
                        url:'dishs/'+id,
                        data:'_token={{csrf_token()}}',
                        success : function () {
                            tr.fadeOut();
                        }
                    })
                }
            })
        })
    </script>
@stop