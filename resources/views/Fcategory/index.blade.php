@extends('Default.default')
@section('title','商户菜品分类')
    @section('content')
        <table class="table mytable">
            <tr>
                <th>分类名称</th>
                <th>分类封面图</th>
                <th>分类描述</th>
                <th>是否默认选中该分类</th>
                <th>操作</th>
            </tr>
            @foreach($Fcategories as $fcategory)
            <tr data-id="{{$fcategory->id}}">
                <td>{{$fcategory->name}}</td>
                <td><img src="{{$fcategory->cover}}" width="128" alt=""></td>
                <td>{{$fcategory->detail}}</td>
                <td>{{$fcategory->is_selected}}</td>
                <td>
                    <a href="{{route('fcategories.edit',$fcategory)}}" class="btn btn-primary">修改</a>
                    <button class="btn btn-danger"> 删除</button>
                </td>
            </tr>
                @endforeach
            <tr>
                <td colspan="5" style="text-align: center">
                    <a href="{{route('fcategories.create')}}" class="btn btn-default">添加菜品分类</a>
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
                        url:'fcategories/'+id,
                        data:'_token={{csrf_token()}}',
                        success : function (msg) {
                            var str = JSON.parse(msg);
                            console.debug(msg)
//                            if(){
//                                alert('分类下有菜品请先删除菜品不能删除');
//                                return false;
//                        }
//
//                         tr.fadeOut();

                        }
                    })
                }
            })
        })
    </script>
    @stop