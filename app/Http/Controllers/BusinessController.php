<?php

namespace App\Http\Controllers;

use App\Business;
use App\Category;
use App\Mail;
use App\UploadTool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'guest',
            [
                'only'=>['create','store']
            ]
        );
    }
    //显示商家注册表单
    public function create()
    {
        //需要获得分类的东西
        $Categorys = Category::all();
        return view('Shop.add',compact('Categorys'));
        }
    //添加用户
    public function store(Request $request)
    {
        $this->validate($request,[
            //验证规则
            'account'=>[
                'required',
                'min:3',
                Rule::unique('businesses'),
            ],
            'email'=>[
                'required',
                Rule::unique('businesses'),
            ],
            'password'=>'required|confirmed|min:3',
            'logo'=>'required|image',
            'start_send'=>'required|numeric',
            'send_cost'=>'required|numeric',
            'notice'=>'min:3',
            'discount'=>'min:3',

        ],[
            'account.required'=>'账号必须填',
            'account.min'=>'账号最少要三个字符',
            'account.unique'=>'该账号已存在',
            'password.required'=>'密码不能为空',
            'password.confirmed'=>'密码确认失败',
            'password.min'=>'密码最少要三位',
            'logo.required'=>'商家的logo不能为空',
            'logo.image'=>'请上传一张图片作为logo',
            'start_send.required'=>'起送费不能为空',
            'start_sent.numeric'=>'请输入数字作为起送费',
            'send_cost.required'=>'配送费不能为空',
            'send_cost.numeric'=>'输入数字作为配送费',
            'notice.min'=>'公告最少三个字符',
            'discount.min'=>'优惠消息最少是三个字符',
            'email.required'=>'邮箱不能为空',
            'email.unique'=>'邮箱已存在'
        ]);
         $fileName = $request->file('logo')->store('public/logo');

         $filePath = url(Storage::url($fileName));
         $path = UploadTool::upload($filePath);

            Business::create([
                'account'=>$request->account,
                'password'=>bcrypt($request->password),
                'logo'=>$path,
                'category_id'=>$request->category_id,
                'email'=>$request->email
            ]);
        $bao = $request->bao??0;
        $zhun = $request->zhun??0;
        $brand = $request->brand??0;
        $fengniao = $request->fengniao??0;
        $piao = $request->piao??0;
        $zhunMarket = $request->zhunMarket;
        $notice = $request->notice??'';
        $discount = $request->discount??'';
            DB::table('businesses_info')->insert([
                'brand'=>$brand,
                'on_time'=>$zhun,
                'fengniao'=>$fengniao,
                'bao'=>$bao,
                'piao'=>$piao,
                'zhun'=>$zhunMarket,
                'notice'=>$notice,
                'discount'=>$discount,
                'start_send'=>$request->start_send,
                'send_cost'=>$request->send_cost
            ]);
            //成功提示
        $name =$request->account;
        $email = $request->email;
        $result = Mail::send($name,$email);
        session()->flash('success','申请成功,等待审核没审核后可以登录');
            //跳转
        return redirect()->route('login');

    }
}
