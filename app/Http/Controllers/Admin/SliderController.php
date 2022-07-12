<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    //
    public function index(){
        $title='Slider Manager';
        $sliders=Slider::orderBy('id','desc')->paginate(5);
        return view('Admin.Slider.Slider',compact('title','sliders'));
    }
    public function getData(Request $request){
        $search=$request->search;
        $sliders="";
        if($search=="active" || $search=="no active"){
            $active=0;
            if($search=="active"){
                $active=1;
            }
            $sliders=Slider::orderBy('id','desc')
            ->where('id','=',$search)
            ->orwhere('name_slider','like','%'.$search.'%')
            ->orwhere('active','=',$active)
            ->paginate(5);
        }else{
            $sliders=Slider::orderBy('id','desc')
            ->where('id','=',$search)
            ->orwhere('name_slider','like','%'.$search.'%')
            ->paginate(5);
        }
        $title='Slider Manager';
        return view('Admin.Slider.SliderTable',compact('title','sliders'));
    }
    public function insert(Request $request){
        $fileName="";
        if($request->has('imageSlider')){
            $file=$request->imageSlider;
            $extension=$file->extension();
            $fileName=time()."-slider.".$extension;
            $file->move(public_path('Uploads'),$fileName);
        }
        if(!empty($fileName)){
            $fileName='/Uploads/'.$fileName;
        }
        $status=Slider::create([
            "name_slider"=>$request->nameSlider,
            "url"=>$request->urlSlider,
            "image"=>$fileName,
            "active"=>$request->rdoSlider
        ]
        );
        if($status)
        return true;
        return false;

    }
    public function update(Request $request){
        $fileName="";
        $status="";
        if($request->has('imageSlider')){
            $file=$request->imageSlider;
            $extension=$file->extension();
            $fileName=time()."-slider.".$extension;
            $file->move(public_path('Uploads'),$fileName);
            if(!empty($fileName)){
                $fileName='/Uploads/'.$fileName;
            }
            $status=Slider::where('id','=',$request->idSlider)
            ->update([
            "name_slider"=>$request->nameSlider,
            "url"=>$request->urlSlider,
            "image"=>$fileName,
            "active"=>$request->rdoSlider
        ]
        );
        }else{
            $status=Slider::where('id','=',$request->idSlider)
            ->update([
            "name_slider"=>$request->nameSlider,
            "url"=>$request->urlSlider,
            "active"=>$request->rdoSlider
        ]
        );
        }
        if($status)
        return true;
        return false;
    }
    public function delete(Request $request){
        $status=Slider::where("id","=",$request->id)->delete();
        if($status)
        return true;
        return false;
    }
    public function get(Request $request){
        $slider=Slider::where("id",'=',$request->idSlider)->get();
        return response()->json($slider);
    }
}
