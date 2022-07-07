<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductColor;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\ProductDetailRequest;
class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Product list";
        $products= Product::join('categories','products.category_id','=','categories.id')
        ->select('products.*','categories.name as categoryName')->orderBy('id','desc')->paginate(5);
        $categories=Category::get();
        $colors=ProductColor::get();
         return view('Admin.Product.Product',compact('title','products','categories','colors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $fileName='';
        if($request->has('img_product')){
            $file = $request->img_product;
            $extension=$file->extension();
            $fileName=time() .'-product.'.$extension;
            $file->move(public_path('Uploads'),$fileName);
        }
        if(!empty($fileName)){
            $fileName='/Uploads/'.$fileName;
        }
        $product=Product::create([
            'name'=>$request->name_product,
            'category_id'=>$request->category_product,
            'avatar'=>$fileName,
            'desc'=>$request->desc_product,
        ]);
        return $product->id;
      
    }
    public function storeDetail(ProductDetailRequest $request){
        $fileName="";
        if($request->has('image_detail')){
            $file=$request->image_detail;
            $extension=$file->extension();
            $fileName=time().'-productDetail.'.$extension;
            $file->move(public_path('Uploads'), $fileName);
        }
        if(!empty($fileName)){
            $fileName='/Uploads/'.$fileName;
        }
        ProductDetail::create([
            'product_id'=>$request->id_product,
            'image'=>$fileName,
            'color_id'=>$request->colorProduct,
            'original_cost'=>$request->original_cost_product,
            'discount'=>$request->discount_product,
            'amount'=>$request->amout_product,
         
        ]);
       
    }
    public function getData(Request $request){
        $search=$request->search;
        if($request->ajax()){
            $products = Product::join('categories','products.category_id','=','categories.id')   
            ->select('products.*','categories.name as categoryName')
            ->where('products.name','like','%'.$search.'%')
            -> orWhere('categories.name','like','%'.$search.'%')
            -> orWhere('products.id','=',$search)
            ->orderBy('products.id','desc')
            ->paginate(5);
            return view('Admin.Product.productTable',compact('products'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $products= Product::join('categories','products.category_id','=','categories.id')
        ->join('product_details','products.id','=','product_details.product_id')
        ->where('products.id','=',$id)
        ->select('*','products.name as nameProduct','products.id as id_product','products.desc','categories.id as categoryID','product_details.id as productDetailsID',
        'product_details.image as productDetailsImage')
        ->orderBy('products.id','desc')->get();
        return response()->json($products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $fileName='';
        if($request->has('img_product')){
            $file = $request->img_product;
            $extension=$file->extension();
            $fileName=time() .'-product.'.$extension;
            $file->move(public_path('Uploads'),$fileName);

            if(!empty($fileName)){
                $fileName='/Uploads/'.$fileName;
            }
            $product=Product::where('id','=',$request->id_product)
        ->update([
            'name'=>$request->name_product,
            'category_id'=>$request->category_product,
            'avatar'=>$fileName,
            'desc'=>$request->desc_product,
        ]);
        return $product;
        }else{
            $product=Product::where('id','=',$request->id_product)
            ->update([
                'name'=>$request->name_product,
                'category_id'=>$request->category_product,
                'desc'=>$request->desc_product,
            ]);
            return $product;
        }      
        
     
    }
    public function updateDetail(Request $request)
    {
        $fileName="";
        if($request->has('image_detail')){
            $file=$request->image_detail;
            $extension=$file->extension();
            $fileName=time().'-productDetail.'.$extension;
            $file->move(public_path('Uploads'), $fileName);

            if(!empty($fileName)){
                $fileName='/Uploads/'.$fileName;
            }
            ProductDetail::where('id','=',$request->idProductDetail)
            ->update([        
                'image'=>$fileName,
                'color_id'=>$request->colorProduct,
                'original_cost'=>$request->original_cost_product,
                'discount'=>$request->discount_product,
                'amount'=>$request->amout_product,
             
            ]);
        }else{
            ProductDetail::where('id','=',$request->idProductDetail)
            ->update([
                'color_id'=>$request->colorProduct,
                'original_cost'=>$request->original_cost_product,
                'discount'=>$request->discount_product,
                'amount'=>$request->amout_product,
             
            ]);
        }
     
        
    }
    public function deleteDetail(Request $request){
        ProductDetail::where('id','=',$request->idProductDetail)->delete();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductDetail::where('product_id','=',$id)->delete();
        Product::where('id','=',$id)->delete();
    }
}
