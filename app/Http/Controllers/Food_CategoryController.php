<?php

namespace App\Http\Controllers;

use App\Dish;
use App\Fcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Food_CategoryController extends Controller
{
    //商户显示添加菜品分类列表
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //显示商户自己的所有分类
        $id = Auth::user()->id;
        $Fcategories = Fcategory::all()->where('business_id','=',$id);
        return view('Fcategory.index',compact('Fcategories'));
    }
    //商户显示添加表单
    public function create()
    {
        return view('Fcategory.add');
    }
    //商户保存添加
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:2',
            'cover'=>'required|image',
            'detail'=>'min:3|nullable',
            'is_selected'=>'required|numeric',
        ],[
            'name.required'=>'姓名不能为空',
            'name.min'=>'姓名最少两个字符',
            'cover.required'=>'封面图不可为空',
            'cover.image'=>'封面图必须是一张图片',
            'detail.min'=>'描述最少三个字符',
            'is_selected.required'=>'是否默认选中未勾选',
            'is_selected.numeric'=>'不要乱改好吗'
        ]);
        //数据验证完成保存
        //相同商户下分类名不重复
        $id = Auth::user()->id;
        $business = DB::table('fcategories')->where(
           [ [
                'business_id',$id
            ],
            [
                'name',$request->name
            ]
           ]
        )->get()->first();
        if($business){
            //存在相同分类名
            session()->flash('danger','该分类名已经存在');
            return redirect()->back()->withInput();
        }
        //保存
        $fileName = $request->file('cover')->store('public/cover');
        $filePath = url(Storage::url($fileName));
        Fcategory::create(
            [
                'name'=>$request->name,
                'detail'=>$request->detail??'',
                'is_selected'=>$request->is_selected,
                'cover'=>$filePath,
                'business_id'=>$id
            ]
        );
        //成功提示
        session()->flash('success','添加分类成功');
        return redirect()->route('fcategories.index');
    }
    //商户修改某个分类信息
    public function edit(Request $request,Fcategory $fcategory)
    {
        return view('Fcategory.edit',compact('fcategory'));
    }
    //保存修改
    public function update(Request $request,Fcategory $fcategory)
    {
        //数据验证
        $this->validate($request,[
            'name'=>[
                'required',
                'min:2',
            ],
            'cover'=>'nullable|image',
            'detail'=>'min:3|nullable',
            'is_selected'=>'numeric',
        ],[
            'name.required'=>'姓名不能为空',
            'name.min'=>'姓名最少两个字符',
            'cover.image'=>'封面图必须是一张图片',
            'detail.min'=>'描述最少三个字符',
            'is_selected.numeric'=>'不要乱改好吗'
        ]);
        //要修改的分类名称不能在数据库中,并且可以不修改冲突自己的
        $id = Auth::user()->id;
        $business = DB::table('fcategories')->where(
            [ [
                'business_id',$id
            ],
                [
                    'name',$request->name
                ]
            ]
        )->get();
        $current_id = $fcategory->id;
        foreach ($business as $record){
            //两种情况 1.$business是他自己,用户并没有修改分类名字
            //这种情况下这个business的id=current-id
            if($current_id!=$record->id){
                session()->flash('danger','该分类名已存在');
                return redirect()->back()->withInput();
            }
            //修改信息
            if($request->cover){
                //用户上传图片
                $fileName = $request->file('cover')->store('public/cover');
                $filePath = url(Storage::url($fileName));
                $fcategory->update(
                    [
                        'cover'=>$filePath
                    ]
                );
            }
            $fcategory->update([
                'name'=>$request->name,
                'detail'=>$request->detail??'',
                'is_selected'=>$request->is_selected??0
            ]);
            //修改成功
            session()->flash('success','修改分类信息成功');
            return redirect()->route('fcategories.index');
        }
    }
    //
    public function destroy(Fcategory $fcategory)
    {
       $id =  Auth::user()->id;
 $res = DB::select("select * from dishes where business_id = $id and fcategory_id=$fcategory->id");
        if($res==null){
            //该分类下没有菜品可以删除
            $result = ['result'=>'yes'];
            $fcategory->delete();
            return json_encode($result);
        }
        else{
            $result = ['result'=>'no'];
            return json_encode($result);
        }
    }
}
