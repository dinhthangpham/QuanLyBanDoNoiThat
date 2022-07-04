@extends('Common.Admin.Home')
@section('css')
<style>
.ck-editor__editable_inline {
    min-height: 300px;
}
i{
      padding:5px;
    }
</style>

@endsection
@section('js')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection
@section('content_home')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <button style="float:right;" name="btn_product-add" id="btn_product-add" class="btn btn-success btn_product-add">  Add </button>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="product_search" name="product_search"
                style="width:80%; margin-left:75px;margin-top:20px;" id="usr" placeholder="Search">
        </div>
        <div id="alertSuccess">

        </div>

        <div class="card-body p-0">
            <div class="" id="table_product">
                @include('Admin.product.productTable')
            </div>
        </div>
        {{-- Dialog add, update --}}
        @extends('Common.Dialog')

    @section('title_dialog')
        <h3>Product Manager</h3>
    @endsection

    @section('content_dialog')
        <form id="form_product" enctype="multipart/form-data">
            @csrf
            <div class="form-group" id="infor_product">
                <div class="form-group" id="infor_product_1">
                    <p>Page 1/3</p>
                    <div><label for="usr">Name Product</label>
                        <input type="text" name="name_product" id="name_product" class="form-control">
                        <small id="name_product-error" class="text-danger"></small>
                    </div> 
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_product" class="form-control">
                            <option value="">Category</option>
                            @foreach($categories as $category)
                            <option value={{ $category->id }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    <small id="category_product-error" class="text-danger"></small>
                      </div>
                    <label for="usr">Choose Avatar</label>
                    <div class="input-group">
                        <input type="file" name="img_product" id="img_product" class="form-control">
                    </div>
                    <small id="img_product-error" class="text-danger"></small>
                    <br>
                    <img style="width: 100px; margin-top:10px;" src="/Admin/Image/no-image.jpg" id="img-product-demo" alt="">
                    <div>
                        <input style="margin:10px; float:right" type="button"  onclick="onClickNextInput()" class="btn btn-success" value="Next">
                    </div>
                </div>              
                
                <div  class="form-group"  id="infor_product_2">
                    <p>Page 2/3</p>
                    <label for="usr">Description product</label>
                  
                    <textarea style="min-height: 300px" id="desc_product" name="desc_product"></textarea>
                    <small id="desc_product-error" class="text-danger"></small>
                    <div>
                        <input style="margin:10px; float:right" type="button"  onclick="onClickNextInput()" class="btn btn-success" value="Next">
                        <input style="margin:10px; float:right" type="button" onclick="onClickPreInput()" class="btn btn-danger" value="Back">
                    </div>
                    
                </div>
                

            </div>
            @csrf
        </form>
        <div id="form_detail_product">
            <p>Page 3/3</p>
            <div id="synthesis_form_product_detail">
                <div class="div_product_detail div_product_detail_1">
                    <form class="form_product_detail" enctype="multipart/form-data">
                        <div class="form-group">
                            <div  class="form-group" id="infor_product_detail_1">
                                <input type="hidden" class="id_product_detail" name="id_product_detail">
                                <label for="usr">Color</label>
                                <div class="form-group">
                                    <select name="colorProduct" class="form-control">
                                        <option value="">Color</option>
                                        @foreach($colors as $color)
                                        <option value='{{ $color->id }}'>{{ $color->color }}</option>
                                        @endforeach
                                                                         
                                    </select>
                                    <small id="colorProduct-error-1"  class="text-danger colorProduct-error"></small>

                                  </div>
                                  <label for="usr">Choose Image</label>
                                  <div class="input-group">
                                      <input type="file" id="image_detail_id_1"  name='image_detail' image_detail="1" class="form-control img_detail">
                                  </div>
                                  <img style="width: 100px; margin-top:10px;" src="/Admin/Image/no-image.jpg" id="img-product-detail_1" alt="">
                                  <br>
                                  <small  id="image_detail-error-1" class="text-danger image_detail-error"></small>
                                    <br>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <!-- text input -->
                                      <div class="form-group">
                                        <label>Original Cost</label>
                                        <input type="number" name="original_cost_product" class="form-control" value=0 >
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                          <label>Discount</label>
                                          <input type="number"  name="discount_product" class="form-control" value=0 >
                                        </div>
                                      </div>
                                    
                                  </div>
                                  <div><label for="usr">Amount</label>
                                    <input  type="number" name="amout_product" value=0  class="form-control">
                                    <small id="name_product-error" class="text-danger"></small>
                                </div> 
                                <br>                                
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
                
            </div>
            <button  class="btn btn-outline-secondary" id="addMore" name="addMore">More</button>
            <div>
                <button style="margin:10px; float:right"  id="saveProduct" class="btn btn-success" >Save</button>
                <input style="margin:10px; float:right" type="button" onclick="onClickPreInput()" class="btn btn-danger" value="Back">
            </div>
            {{-- <input type="button" class="btn btn-secondary" value="" value="More"> --}}
        </div>
            
        
    @endsection
    <input type="hidden" name="" id="exits_product">
    <input type="hidden" name="" value="insert" id="state_product">
    <input type="hidden" name="" id="page_product" value="1">
</div>


<script src="{{ asset('Admin/MyJs/Product.js') }}"></script>
<script>

        CKEDITOR.replace( 'desc_product' );
        $(document).ready(function(){
        openDialogInsert();
       
        stepDialog(1);
        moreProduct();
        saveProduct();
        changeFileToImage('img_product','#img-product-demo');
        changeFileToImageProductDetail();
});
function changeFileToImageProductDetail(){
    var synthesis_form=$('#synthesis_form_product_detail');
    $(synthesis_form).on('click', '.img_detail', function(e){ //Once remove button is clicked
        let id= $(e.target).attr('image_detail');
         changeFileToImage('image_detail_id_'+id,'#img-product-detail_'+id);
    }); 
}
function moreProduct(){
    var stt=1;
    var synthesis_form=$('#synthesis_form_product_detail');
    $('#addMore').click(function (){
        stt++;
        synthesis_form.append(displayAddForm(stt,{!! json_encode($colors) !!}));
    });
    $(synthesis_form).on('click', '.removeFormDetail', function(e){ //Once remove button is clicked
        e.preventDefault();
        let id= $(e.target).attr('remove');
         $(".div_product_detail_"+id).remove();
    });  
}
function displayAddForm(stt,arrayColor ){
    let html="";
    html += "<div class='div_product_detail div_product_detail_"+stt+"'><div style='border-top: 2px solid #ff0000;'></div><br>"
    html+='<button style="float:right" class="btn btn-outline-secondary removeFormDetail" remove='+stt+'  name="removeFormDetail">Remove</button> <br> ';
    html+='<form class="form_product_detail"  enctype="multipart/form-data">';
    html+='<div class="form-group">';
    html+='<input type="hidden" class="id_product_detail" name="id_product_detail">'
    html+='    <div  class="form-group" id="infor_product_detail_'+stt+'">';                       
    html+='        <label for="usr">Color</label>';
    html+='        <div class="form-group">';
    html+='            <select name="colorProduct" class="form-control">';
    html+='              <option value="">Color</option>';
    arrayColor.forEach(function(color) {
        html+='<option value="'+color.id+'">'+color.color+'</option>';
      });
 
    html+='           </select>';
    html+='<small  id="colorProduct-error-'+stt+'" class="text-danger colorProduct-error"></small>';
    html+='          </div>';
    html+='          <label for="usr">Choose Image</label>';
    html+='          <div class="input-group">';
    html+='              <input name="image_detail" type="file" id="image_detail_id_'+stt+'" image_detail='+stt+' class="form-control img_detail">';
    html+='          </div>';
    html+='         <img style="width: 100px; margin-top:10px;" src="/Admin/Image/no-image.jpg" id="img-product-detail_'+stt+'" alt="">';
    html+='         <br>';
    html+='<small  id="image_detail-error-'+stt+'" class="text-danger image_detail-error"></small>';
    html+='         <br>';
    html+='         <div class="row">';
    html+='           <div class="col-sm-6">';
    html+='             <!-- text input -->';
    html+='            <div class="form-group">';
    html+='              <label>Original Cost</label>';
    html+='              <input name="original_cost_product" type="number" class="form-control" value=0 >';
    html+='             </div>';
    html+='           </div>';
    html+='            <div class="col-sm-6">';
    html+='               <!-- text input -->';
    html+='               <div class="form-group">';
    html+='                 <label>Discount</label>';
    html+='                 <input name="discount_product" type="number" class="form-control" value=0 >';
    html+='               </div>';
    html+='             </div>';               
    html+='         </div>';
    html+='        <div><label for="usr">Amount</label>';
    html+='            <input type="number" name="amout_product" id="name_product" class="form-control">';
    html+='           <small id="name_product-error" class="text-danger"></small>';
    html+='        </div> ';
    html+='        <br>';
    html+='    </div>';
    html+='</div>';
    html+='<input type="hidden" name="_token" value="{{ csrf_token() }}" />';
    html+='</form></div>';
    
    return html;
}
    
</script>

@endsection
