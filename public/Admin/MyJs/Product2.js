
let step=1;
var updateDetail=[];
var deleteDetail=[];
function stepDialog(step){
    
    if(step==1){
        displayForm('infor_product_1',true);
        displayForm('infor_product_2',false);
        displayForm('form_detail_product',false);
    }else if(step==2){
        displayForm('infor_product_1',false);
        displayForm('infor_product_2',true);
        displayForm('form_detail_product',false);
    }else if(step==3){
        displayForm('infor_product_1',false);
        displayForm('infor_product_2',false);
        displayForm('form_detail_product',true);
    } 
}

function onClickNextInput(){
        step++;
        stepDialog(step);
}
function onClickPreInput(){
    if(step!=1)
    step--;
    stepDialog(step);
   
}
function displayForm(idForm,appear){
    if(appear==false)
    $('#'+idForm).css("display","none");
    else
    $('#'+idForm).css("display","block");
}
function resetAllForm(){
    $('#category_product option:selected').removeAttr('selected');
    $('.colorProduct option:selected').removeAttr('selected');
    $('#form_product')[0].reset();
    $('.img-product-demo').attr('src','/Admin/Image/no-image.jpg');
    $('.form_product_detail')[0].reset();
    $(".product_detail_more").remove();
    CKEDITOR.instances['desc_product'].setData("");
    step=1;
    $('#alertSuccess').html('');
}

function changeFileToImage(idFile, idImage) {
    document.getElementById(idFile).onchange = function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(idImage).attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    };
}

function resetError(){
    $('#name_product-error').val('');
    $('#category_product-error').val('');
    $('#img_product-error').val('');
    $('#desc_product-error').val('');

    $('.colorProduct-error').text(' ');
    $('.image_detail-error').text(' ');
    

}

function searchProduct() {
    $(document).on('keyup', '#product_search', function() {
        var product_search = $(this).val();
        var page = $('#page_product').val();
        getDataProduct(page, product_search);

    });
}


function getDataProduct(page,search){
    $.ajax({
        type: "GET",
        url: "/Admin/Product/GetData?page=" + page + "&search=" +search,
        success: function(data) {
            $('#table_product').html(data);
        }
    });
}

function createNewProduct(){
    // Lấy dữ liệu của Sản phẩm
    
        $.ajax({
            type: "POST",
            url:'/Admin/Product/Store',
            data:new FormData($('#form_product')[0]),
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data){               
            }

        }).then(function (data){
             $('.id_product').val(data);
             let numberError=0;
             // Lấy dữ liệu của chi tiết sản phẩm        
            for (var i = 0; i <$('.div_product_detail').length;i++) {
                $.ajax({              
                    type: 'POST',
                    url: '/Admin/Product/StoreDetail',
                    dataType: 'json',
                    data:new FormData($('.form_product_detail')[i]),
                    contentType: false,
                    processData: false,
                    success: function (data){
                       
                    }
                });
            };
            
            
        }).then(function(data){
                closeModal();
                resetAllForm();
                let page=$('#page_product').val();
                var product_search = $('#product_search').val();
                getDataProduct(page, product_search);
                $('#alertSuccess').html(
                    '<div class="alert alert-success">' +
                    '<strong>Success!</strong> Create product Successfull' +
                    '</div> <br>');
            
        });
    
         
}

function updateProduct(){
    $.ajax({
        type: "POST",
        url:'/Admin/Product/Update',
        data:new FormData($('#form_product')[0]),
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (data){               
        }

    }).then(function (data){
         $('.id_product_detail').val(data);
         let numberError=0;
         // Lấy dữ liệu của chi tiết sản phẩm        
        for (var i = 0; i <$('.div_product_detail').length;i++) {
            $.ajax({              
                type: 'POST',
                url: '/Admin/Product/UpdateDetail',
                dataType: 'json',
                data:new FormData($('.form_product_detail')[i]),
                contentType: false,
                processData: false,
                success: function (data){
                   
                }
            });
        };
        
        
    }).then(function(data){    
            closeModal();
            // resetAllForm();
            let page=$('#page_product').val();
            var product_search = $('#product_search').val();
            getDataProduct(page, product_search);
            $('#alertSuccess').html(
                '<div class="alert alert-success">' +
                '<strong>Success!</strong> Update product Successfull' +
                '</div> <br>');
        
    });
}
function updateCreateNewDetail(){
    for(var i = 0; i <updateDetail.length;i++){
        console.log(new FormData($('.div_product_detail_'+updateDetail[i]+' .form_product_detail')[0]));
        $.ajax({              
            type: 'POST',
            url: '/Admin/Product/StoreDetail',
            dataType: 'json',
            data:new FormData($('.div_product_detail_'+updateDetail[i]+' .form_product_detail')[0]),
            contentType: false,
            processData: false,
            success: function (data){
               
            }
        });
    }
}
function updateDeleteDetail(){
    for(var i = 0; i <deleteDetail.length;i++){
        console.log($('.div_product_detail_'+deleteDetail[i]+' .form_product_detail input[name="_token"]').val());
        $.ajax({              
            type: 'POST',
            url: '/Admin/Product/DeleteDetail',
            dataType: 'json',
            data:new FormData($('.div_product_detail_'+deleteDetail[i]+' .form_product_detail')[0]),
            contentType: false,
            processData: false,
            success: function (data){
               
            }
        });
    }
}
function deleteProduct(){ 
    $('#product').on('click', '.btn_product-delete', function(e){ //Once remove button is clicked
        e.preventDefault();
        let id= $(e.target).attr('idDelete');
       $.ajax({
        type: 'POST',
        url: '/Admin/Product/DeleteDetail/id='+id,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (data){
            let page=$('#page_product').val();
            var product_search = $('#product_search').val();
            getDataProduct(page, product_search);
        }
    })
    });  
}
function checkValueNull(idInputCheck,idTextError, textError, stepError){
    let value=$(idInputCheck).val();
    if(value==''){
        $(idTextError).text(textError);
        step=stepError;
        stepDialog(step);
        return false;
    }else if(value!=""){
        $(idTextError).text('');
        return true;
    }
}
function checkValueNullCkeditor(ckediterName,idTextError, textError, stepError){
    let value=CKEDITOR.instances[ckediterName].getData();
    if(value==''){
        $(idTextError).text(textError);
        step=stepError;
        stepDialog(step);
        return false;
    }else if(value!=""){
        $(idTextError).text('');
        return true;
    }
}
function saveProduct(){
        $('#saveProduct').on('click', function(e) {
            e.preventDefault();
            for ( instance in CKEDITOR.instances ) {
                CKEDITOR.instances[instance].updateElement();
            }
            let status=$('#state_product').val();
            let checkNameProduct=checkValueNull('#name_product','#name_product-error','Name Product is not null',1);
            let checkCategory=checkValueNull('select[name="category_product"]','#category_product-error','Category must be choose',1);
            let checkImageProduct;
            if(status=='insert'){
                checkImageProduct=checkValueNull('input[name="img_product"]','#img_product-error','Image must be upload',1);
            }
            let checkDescProduct=checkValueNullCkeditor('desc_product','#desc_product-error','Description is not null',2);
            let arrayCheckErrorDetail=[];
            let checkColorProductDetail=true;
            let checkImageProductDetail=true;
            for (var i = 0; i <$('.div_product_detail').length;i++) {
                
                 checkColorProductDetail=checkValueNull('#colorProduct-'+(i+1),'#colorProduct-error-'+(i+1),'Color must be choose',3);
                 if(status=='insert')
                 checkImageProductDetail=checkValueNull('#image_detail_id_'+(i+1),'#image_detail-error-'+(i+1),'Image must be choose',3);
                if(!checkColorProductDetail || !checkImageProductDetail){
                    arrayCheckErrorDetail.push('error');
                }
            }
               
                if(status=='insert'){
                    if(checkNameProduct && checkCategory && checkImageProduct && checkDescProduct && arrayCheckErrorDetail.length<1){
                        createNewProduct();
                    }
                }           
                else if(status=='update'){
                    if(checkNameProduct && checkCategory && checkDescProduct && arrayCheckErrorDetail.length<1){
                        
                        var result = confirm("Are you sure to change this ");
                        if(result){
                            if(updateDetail.length>0){
                                updateCreateNewDetail();
                            }
                            if(deleteDetail.length>0){
                                updateDeleteDetail();
                            }
                        updateProduct();
                        }
                    }
                    
                }
            
            
      });
       
        

    
}
