<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

class CategoryController extends Controller
{
  

    //
    public function index(){
        $list= Category::orderBy('id', 'desc')->paginate(5);
        $title='Category List';
        return view('Admin.Category.Category',compact(['list','title']));
    }

   
    public function search(Request $request){
      if($request->ajax()){
        $title='Category List'; 
        $list = Category::where('id','=',$request->search)
        ->orwhere('name','like','%'.$request->search.'%')->orderBy('id','desc')
        ->paginate(5);  
        // return view('Admin.Category.CategoryTable',compact('list'))->render(); 
        return view('Admin.Category.CategoryTable',[
          'list'=>$list
        ]);      

      }     
    }
    public function searchByName(Request $request){
      $category=Category::where('name','=',$request->name_category)->get();
      if($category->isnotempty()){
        return [
          "status"=>"exist"
        ];
      }
      else{
        return [
          "status"=>"not exist"
        ];
      }   
  }
    public function searchById(Request $request){   
      $html='';
      $category=Category::where('id','=',$request->categoryid)->get();
      $html.='
      <div>
      <input type="hidden" name="id_category" value="'.$category[0]->id.'" id="id_category">
        <label for="usr">Name Category</label>
                    <input type="text" name="name_category" id="name_category" value="'.$category[0]->name.'" class="form-control">
                    <small id="name_category-error" class="text-danger"></small>
                </div>
                <label for="usr">Choose Image</label>
                <div class="input-group">               
                  <input type="file" name="img_category"  id="img_category" class="form-control">
                </div>
                <small id="img_category-error" class="text-danger"></small>
              
                <img style="width: 100px; margin-top:10px;" src="'.$category[0]->image.'" id="img-category-demo" alt="">
                <br>
                <label for="usr">Description category</label>
                <textarea name="desc_category" id="desc_category" class="form-control" cols="30" rows="10">'.$category[0]->desc.'</textarea>
    
                <button type="submit" style="margin:10px; float:right" name="btn_dialog-update"
                    class="btn btn-success">Save</button>
        ';
      return response()->json($html);
      
  }
  public function update(CategoryRequest $request){
      $html='';
      $file_name='';
      $desc='';
      $id=$request->id_category;
      $name_category=$request->name_category;
      $contributeCategory=[];
      
    if(!empty($request->desc_category)){
      $desc=$request->desc_category;
    }
    if($request->has('img_category')){
      $file=$request->img_category;
      $extension=$file->extension();
      $file_name=time()."-category.".$extension;
      $file->move(public_path('Uploads'),$file_name);

      $category=Category::where('id','=',$id)->update([
          'name'=>$name_category,
          'image'=>'/Uploads/'.$file_name,
          'desc'=>$desc,
   
      ]);
      if($category){
        $contributeCategory=[
          'name'=>$name_category,
          'image'=>'/Uploads/'.$file_name,
          'desc'=>$desc
        ];
      }

    }else{
      $category=Category::where('id','=',$id)->update([
        'name'=>$request->name_category,
        'desc'=>$desc,
       
    ]);
  
    if($category){
      $contributeCategory=[
        'name'=>$name_category,
        'desc'=>$desc
      ];
    }
    }
    
    return response()->json($contributeCategory);
  }
  public function insert(CategoryRequest $request){
      $html='';
      $file_name='';
      $desc='';
        
        if($request->has('img_category')){
          $file=$request->img_category;
          $extension=$file->extension();
          $file_name=time()."-category.".$extension;
          $file->move(public_path('Uploads'),$file_name);
        }
        if(!empty($request->desc_category)){
          $desc=$request->desc_category;
        }
        $category=Category::create([
          'name'=>$request->name_category,
          'image'=>'/Uploads/'.$file_name,
          'desc'=>$desc,
        
        ]);
      
     
      if($category){
        $jsonInsert=[
          'id'=>$category->id,
          'name'=>$category->name,
          'image'=>$category->image,
          'desc'=>$category->desc
        ];
      }
      return response()->json($jsonInsert);
  }
  public function delete(Request $request){
       $category = Category::find($request->categoryid)->delete();
       return response()->json($category);
  }
}
