@extends('Common.Admin.Home')
@section('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }

        i {
            padding: 5px;
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
            <button style="float:right;" name="btn_product-add" id="btn_product-add" class="btn btn-success btn_product-add">
                Add </button>
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
                    <input type="hidden" class="form-control" id="id_product" name="id_product">
                    <div><label for="usr">Name Product</label>
                        <input type="text" name="name_product" id="name_product" class="form-control">
                        <small id="name_product-error" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select id="category_product" name="category_product" class="form-control">
                            <option value="">Category</option>
                            @foreach ($categories as $category)
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
                    <img style="width: 100px; margin-top:10px;" src="/Admin/Image/no-image.jpg" class="img-product-demo"
                        id="img-product-demo" alt="">
                    <div>
                        <input style="margin:10px; float:right" type="button" onclick="onClickNextInput()"
                            class="btn btn-success" value="Next">
                    </div>
                </div>

                <div class="form-group" id="infor_product_2">
                    <p>Page 2/3</p>
                    <label for="usr">Description product</label>

                    <textarea style="min-height: 300px" id="desc_product" name="desc_product"></textarea>
                    <small id="desc_product-error" class="text-danger"></small>
                    <div>
                        <input style="margin:10px; float:right" type="button" onclick="onClickNextInput()"
                            class="btn btn-success" value="Next">
                        <input style="margin:10px; float:right" type="button" onclick="onClickPreInput()"
                            class="btn btn-danger" value="Back">
                    </div>

                </div>


            </div>


        </form>
        <div id="form_detail_product">
            <p>Page 3/3</p>
            <div id="synthesis_form_product_detail">
                <div class="div_product_detail div_product_detail_1">
                    <form class="form_product_detail" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-group" id="infor_product_detail_1">

                                <input type="hidden" class="id_product" name="id_product">
                                <label for="usr">Color</label>
                                <div class="form-group">
                                    <select name="colorProduct" id="colorProduct-1" class="form-control colorProduct">
                                        <option value="">Color</option>
                                        @foreach ($colors as $color)
                                            <option value='{{ $color->id }}'>{{ $color->color }}</option>
                                        @endforeach

                                    </select>
                                    <small id="colorProduct-error-1" class="text-danger colorProduct-error"></small>

                                </div>
                                <label for="usr">Choose Image</label>
                                <div class="input-group">
                                    <input type="file" id="image_detail_id_1" name='image_detail' image_detail="1"
                                        class="form-control img_detail">
                                </div>
                                <img style="width: 100px; margin-top:10px;" src="/Admin/Image/no-image.jpg"
                                    class="img-product-demo" id="img-product-detail_1" alt="">
                                <br>
                                <small id="image_detail-error-1" class="text-danger image_detail-error"></small>
                                <br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Original Cost</label>
                                            <input type="number" min="0" name="original_cost_product"
                                                id="original_cost_product-1" class="form-control" value=0>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Discount</label>
                                            <input type="number" min="0" name="discount_product"
                                                id="discount_product-1" class="form-control" value=0>
                                        </div>
                                    </div>

                                </div>
                                <small id="number-error-1" class="text-danger number-error"></small>
                                <div><label for="usr">Amount</label>
                                    <input type="number" min="0" name="amout_product" id="amout_product-1"
                                        value=0 class="form-control">
                                </div>
                                <br>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>

            </div>
            <button class="btn btn-outline-secondary" id="addMore" name="addMore">More</button>
            <div>
                <input style="margin:10px; float:right" type="button" value="Save" id="saveProduct"
                    class="btn btn-success"></input>
                <input style="margin:10px; float:right" type="button" onclick="onClickPreInput()"
                    class="btn btn-danger" value="Back">
            </div>
            {{-- <input type="button" class="btn btn-secondary" value="" value="More"> --}}
        </div>
    @endsection
    <input type="hidden" name="" id="exits_product">
    <input type="hidden" name="" value="insert" id="state_product">
    <input type="hidden" name="" id="page_product" value="1">
</div>


<script src="{{ asset('Admin/MyJs/Product2.js') }}"></script>
<script>
    saveProduct();
    CKEDITOR.replace('desc_product');
    $(document).ready(function() {
        deleteProduct();
        
        openDialogInsert();

        stepDialog(1);

        moreProduct();

        changeFileToImage('img_product', '#img-product-demo');

        changeFileToImageProductDetail();

        ajaxPagination();

        searchProduct();
    });

    function ajaxPagination() {
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#page_product').val(page);
            var product_search = $('#product_search').val();
            getDataProduct(page, product_search);
        });
    }

    function changeFileToImageProductDetail() {
        var synthesis_form = $('#synthesis_form_product_detail');
        $(synthesis_form).on('click', '.img_detail', function(e) { //Once remove button is clicked
            let id = $(e.target).attr('image_detail');
            changeFileToImage('image_detail_id_' + id, '#img-product-detail_' + id);
        });
    }

    var stt = 1;

    function moreProduct() {
        var synthesis_form = $('#synthesis_form_product_detail');
        $('#addMore').click(function() {
            stt++;
            synthesis_form.append(displayAddForm(stt, {!! json_encode($colors) !!}, $('.id_product').first().val()));
            updateDetail.push(stt)

        });
        $(synthesis_form).on('click', '.removeFormDetail', function(e) { //Once remove button is clicked
            e.preventDefault();
            let id = $(e.target).attr('remove');
            $(".div_product_detail_" + id).hide();


            let checkDeteleDetail = true;
            for (var i = 0; i < updateDetail.length; i++) {
                if (updateDetail[i] == id) { // only splice array when item is found
                    updateDetail.splice(i, 1);
                    checkDeteleDetail = false;
                } // 2nd parameter means remove one item only     
            }
            if (checkDeteleDetail) {
                deleteDetail.push(id)
            }
            console.log("delete:" + deleteDetail)
        });
    }

    function openDialogInsert() {
        $(document).on('click', "#btn_product-add", function() {
            resetAllForm();
            OpenModal();
            step = 1;
            stepDialog(step);
            $('#state_product').val('insert');
        });
    }
    function deleteProduct(id){ 
    $('#product').on('click', '.btn_product-delete', function(e){ //Once remove button is clicked
        e.preventDefault();
        // let id= $(e.target).attr('idDelete');
        let check = confirm('Are you sure you want to delete');
        if(check){
            $.ajax({
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
        },
        type: 'POST',
        url: '/Admin/Product/DeleteProduct/'+id,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (data){
            if(data==true){
                let page=$('#page_product').val();
                var product_search = $('#product_search').val();
                getDataProduct(page, product_search);
                $('#alertSuccess').html(
                '<div class="alert alert-success">' +
                '<strong>Success!</strong> Delete product Successfull' +
                '</div> <br>');
            }
            
        }
    });
        }
      
    });  
}
    function openDialogUpdate(id) {
        updateDetail = [];
        deleteDetail = [];
        resetAllForm();
        $('#synthesis_form_product_detail').html('')
        $.ajax({
            type: 'GET',
            url: '/Admin/Product/Show/' + id,
            success: function(data) {
                $('#id_product').val(data[0].id_product);
                $('#name_product').val(data[0].nameProduct);
                $('#category_product option[value=' + data[0].categoryID + ']').attr('selected',
                'selected');
                $("#img-product-demo").attr("src", data[0].avatar);
                CKEDITOR.instances['desc_product'].setData(data[0].desc);
                for (var i = 0; i < data.length; i++) {
                    displayUpdateFormDetail(i + 1, {!! json_encode($colors) !!}, data[0].id_product, data[i]
                        .productDetailsID, data[i].color_id, data[i].productDetailsImage, data[i]
                        .original_cost, data[i].discount, data[i].amount)
                    stt = i + 1;

                }
            }
        })
        OpenModal();
        step = 1;
        stepDialog(step);
        $('#state_product').val('update');
    }

    function displayUpdateFormDetail(stt, arrayColor, idProduct, idProductDetail, colorCategory, image, original_cost,
        discount, amount) {
        let html = "";
        if (stt == 1)
            html += "<div class='div_product_detail  div_product_detail_" + stt +
            "'><div style='border-top: 2px solid #ff0000;'></div><br>"
        else{
            html += "<div class='div_product_detail product_detail_more div_product_detail_" + stt +
            "'><div style='border-top: 2px solid #ff0000;'></div><br>"
        html += '<button style="float:right" class="btn btn-outline-secondary removeFormDetail" remove=' + stt +
            '  name="removeFormDetail">Remove</button> <br> ';
        }
           
        html += '<form class="form_product_detail"  enctype="multipart/form-data">';
        html += '<div class="form-group">';

        html += '<input type="hidden" class="id_product" name="id_product" value=' + idProduct + '>';
        html += '<input type="hidden" class="id_product-detail" name="idProductDetail" value=' + idProductDetail + '>';

        html += '    <div  class="form-group" id="infor_product_detail_' + stt + '">';
        html += '        <label for="usr">Color</label>';
        html += '        <div class="form-group">';
        html += '            <select name="colorProduct" id="colorProduct-' + stt +
            '" class="form-control colorProduct">';
        html += '              <option value="">Color</option>';
        arrayColor.forEach(function(color) {
            if (color.id == colorCategory)
                html += '<option selected="selected" value="' + color.id + '">' + color.color + '</option>';
            else
                html += '<option value="' + color.id + '">' + color.color + '</option>';
        });

        html += '           </select>';
        html += '<small  id="colorProduct-error-' + stt + '" class="text-danger colorProduct-error"></small>';
        html += '          </div>';
        html += '          <label for="usr">Choose Image</label>';
        html += '          <div class="input-group">';
        html += '              <input name="image_detail" type="file" id="image_detail_id_' + stt + '" image_detail=' +
            stt + ' class="form-control img_detail">';
        html += '          </div>';
        html += '         <img style="width: 100px; margin-top:10px;" class="img-product-demo" src="' + image +
            '" id="img-product-detail_' + stt + '" alt="">';
        html += '         <br>';
        html += '<small  id="image_detail-error-' + stt + '" class="text-danger image_detail-error"></small>';
        html += '         <br>';
        html += '         <div class="row">';
        html += '           <div class="col-sm-6">';
        html += '             <!-- text input -->';
        html += '            <div class="form-group">';
        html += '              <label>Original Cost</label>';
        html += '              <input name="original_cost_product" min="0" id="original_cost-' + stt +
            '" type="number" class="form-control" value=' + original_cost + ' >';
        html += '             </div>';
        html += '           </div>';
        html += '            <div class="col-sm-6">';
        html += '               <!-- text input -->';
        html += '               <div class="form-group">';
        html += '                 <label>Discount</label>';
        html += '                 <input name="discount_product" type="number" min="0" id="discount_product-' + stt +
            '" class="form-control" value=' + discount + '>';
        html += '               </div>';
        html += '             </div>';
        html += '         </div>';
        html += '         <div><small id="number-error-'+stt+'" class="text-danger number-error"></small></div>';
        html += '        <div><label for="usr">Amount</label>';
        html += '            <input type="number" name="amout_product" min="0" value=' + amount +
            '  id="amout_product=' + stt + '" class="form-control">';
        html += '           <small class="text-danger"></small>';
        html += '        </div> ';
        html += '        <br>';
        html += '    </div>';
        html += '</div>';
        html += '<input type="hidden" name="_token" value="{{ csrf_token() }}" />';
        html += '</form></div>';

        $('#synthesis_form_product_detail').append(html)
    }

    function displayAddForm(stt, arrayColor, id_product) {
        let html = "";
        html += "<div class='div_product_detail product_detail_more div_product_detail_" + stt +
            "'><div style='border-top: 2px solid #ff0000;'></div><br>";
        if(stt!=1){
            html += '<button style="float:right" class="btn btn-outline-secondary removeFormDetail" remove=' + stt +
            '  name="removeFormDetail">Remove</button> <br> ';
        }
       
        html += '<form class="form_product_detail"  enctype="multipart/form-data">';
        html += '<div class="form-group">';
        // if (id_product != '')
            html += '<input type="hidden" class="id_product" name="id_product" value=' + id_product + '>'
        html += '    <div  class="form-group" id="infor_product_detail_' + stt + '">';
        html += '        <label for="usr">Color</label>';
        html += '        <div class="form-group">';
        html += '            <select name="colorProduct" id="colorProduct-' + stt + '" class="form-control">';
        html += '              <option value="">Color</option>';
        arrayColor.forEach(function(color) {
            html += '<option value="' + color.id + '">' + color.color + '</option>';
        });

        html += '           </select>';
        html += '<small  id="colorProduct-error-' + stt + '" class="text-danger colorProduct-error"></small>';
        html += '          </div>';
        html += '          <label for="usr">Choose Image</label>';
        html += '          <div class="input-group">';
        html += '              <input name="image_detail" type="file" id="image_detail_id_' + stt + '" image_detail=' +
            stt + ' class="form-control img_detail">';
        html += '          </div>';
        html +=
            '         <img style="width: 100px; margin-top:10px;" src="/Admin/Image/no-image.jpg" class="img-product-demo" id="img-product-detail_' +
            stt + '" alt="">';
        html += '         <br>';
        html += '<small  id="image_detail-error-'+stt+'" class="text-danger image_detail-error"></small>';
        html += '         <br>';
        html += '         <div class="row">';
        html += '           <div class="col-sm-6">';
        html += '             <!-- text input -->';
        html += '            <div class="form-group">';
        html += '              <label>Original Cost</label>';
        html += '              <input name="original_cost_product" id="original_cost_product-' + stt +
            '" type="number" class="form-control" value=0 >';
        html += '             </div>';
        html += '           </div>';
        html += '            <div class="col-sm-6">';
        html += '               <!-- text input -->';
        html += '               <div class="form-group">';
        html += '                 <label>Discount</label>';
        html += '                 <input name="discount_product" type="number" id="discount_product-' + stt +
            '" class="form-control" value=0 >';
        html += '               </div>';
        html += '             </div>';
        html += '         </div>';
        html += '         <div><small id="number-error-'+stt+'" class="text-danger number-error"></small></div>';

        
        html += '        <div><label for="usr">Amount</label>';
        html += '            <input type="number" name="amout_product" value=0  id="amout_product=' + stt +
            '" class="form-control">';
        html += '           <small class="text-danger"></small>';
        html += '        </div> ';
        html += '        <br>';
        html += '    </div>';
        html += '</div>';
        html += '<input type="hidden" name="_token" value="{{ csrf_token() }}" />';
        html += '</form></div>';

        return html;
    }
</script>

@endsection
