<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    //
    public function index(){
        $user='';
        $pass='';
        $remember='';
        if(Cookie::get('user')!=null){
            $user=Cookie::get('user');
            $pass=Cookie::get('password');
            $remember='checked';
        }
        return view('Admin.Login',[
            'title'=>'Đăng nhập',
            'user'=>$user,
            'password'=>$pass,
            'remember'=>$remember
        ]);
    }
    public function store(LoginRequest $request){
        $remember=$request->has('ckoRemember')?true:false;
        if(Auth::attempt([
            'name'=>$request->txtAccount,
            'password'=>$request->txtPassword,
        ])){
            if($remember){
                Cookie::queue('user',$request->txtAccount,1000);
                Cookie::queue('password',$request->txtPassword,1000);
            }   
            else{
                Cookie::queue('user',$request->txtAccount,-1);
                Cookie::queue('password',$request->txtPassword,-1);
            } 
            $request->session()->flash('success', 'Bạn đã đăng nhập thành công');    
            return redirect()->route('admin.homePage');
        }
        else{
            $request->session()->flash('error', 'Incorrect account or password');
            return redirect()->back();
        }
        
    }
}
