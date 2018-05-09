<?php

namespace App\Http\Controllers;

use App\Dish;
use App\Fcategory;
use App\UploadTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DishesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //显示当前商户的菜品列表
    public function index()
    {
        $id = Auth::user()->id;
        $Dishes = Dish::all()->where('business_id',$id);
        //dump($Fcategories);
        //EXIT;
        return view('Dish.index',compact('Dishes'));
    }
    //显示添加菜品表单
    public function create()
    {
        $id = Auth::user()->id;
        $Fcategories = Fcategory::all()->where('business_id',$id);
        return view('Dish.add',compact('Fcategories'));
    }
    //保存菜品
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:2',
            'price'=>'required|numeric',
            'fcategory'=>'required|numeric',
            'cover'=>'required',
            'detail'=>'nullable|min:3',
        ],[
            'name.required'=>'菜名不能为空',
            'name.min'=>'菜名最少两个字符',
            'price.required'=>'价格不能为空',
            'price.numeric'=>"价格必须是数字",
            'cover.required'=>'封面图不能空',
            'detail.min'=>"描述最少要三个字符"
        ]);
        //数据验证完成
        //菜名在同一家商户不能重复
        $id = Auth::user()->id;
        $dish = DB::table('dishes')->where(
            [
                ['business_id',$id],
            ['name',$request->name]
            ]
        )->get()->first();
        if($dish){
            session()->flash('danger','该菜名已经存在,要不换一个?');
            return redirect()->back()->withInput();
        }
        //保存添加
        $fileName  = $request->cover;
        $aliyunpath  = UploadTool::upload($fileName);
        Dish::create(
            [
                'name'=>$request->name,
                'price'=>$request->price,
                'cover'=>$aliyunpath,
                'detail'=>$request->detail??'',
                'fcategory_id'=>$request->fcategory,
                'business_id'=>$id
            ]
        );
        //成功提示
        session()->flash('success','添加菜品成功');
        return redirect()->route('dishs.index');
    }
    //修改菜名表单
    public function edit(Dish $dish)
    {
        $id = Auth::user()->id;
        $Fcategories = Fcategory::all()->where('business_id',$id);
        return view('Dish.edit',compact('dish','Fcategories'));
    }
    //保存修改
    public function update(Request $request,Dish $dish)
    {
        $this->validate($request,[
            'name'=>'required|min:2',
            'price'=>'required|numeric',
            'fcategory'=>'required|numeric',
            'cover'=>'nullable|image',
            'detail'=>'nullable|min:3',
        ],[
            'name.required'=>'菜名不能为空',
            'name.min'=>'菜名最少两个字符',
            'price.required'=>'价格不能为空',
            'price.numeric'=>"价格必须是数字",
            'cover.image'=>"封面图必须是一张图片",
            'detail.min'=>"描述最少要三个字符"
        ]);
        //修改菜名不能和别人重复也不能喝主键冲突
        $id = Auth::user()->id;
        $name = DB::table('dishes')->where(
            [
                ['business_id',$id],
                ['name',$request->name]
            ]
        )->get()->first();
        if($name){
            //如果存在这么个名字
            if($name->id!=$dish->id){
                session()->flash('danger','这个名字已经存在');
                 return redirect()->back()->withInput();
            }
        }
        //修改的是自己的其他信息
        if($request->cover){
            $fileName = $request->file('cover')->store('public/cover');
            $filePath = url(Storage::url($fileName));
            $dish->update([
                'cover'=>$filePath
            ]);
        }
        $dish->update(
            [
                'name'=>$request->name,
                'price'=>$request->price,
                'detail'=>$request->detail??'',
                'fcategory_id'=>$request->fcategory

            ]

        );
        session()->flash('success','修改菜品信息成功');
        return redirect()->route('dishs.index');

    }
    //删除一个菜品
    public function destroy(Dish $dish)
    {

        $dish->delete();
    }
}
