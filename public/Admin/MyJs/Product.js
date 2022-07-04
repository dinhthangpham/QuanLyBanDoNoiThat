
let step=1;
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

function openDialogInsert() {
    $(document).on('click', "#btn_product-add", function() {
        OpenModal();
        step=1;
        stepDialog(step);
    });
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
function resetAllForm(){
    $('#form_product')[0].reset();
    $('#img-product-demo').attr('src','/Admin/Image/no-image.jpg');
    $('.form_product_detail')[0].reset();
    for (var i = 2; i <=$('.div_product_detail').length;i++) {
        $(".div_product_detail_"+i).remove();
    }
    
    step=1;
}
function resetError(){
    $('#name_product-error').val('');
    $('#category_product-error').val('');
    $('#img_product-error').val('');
    $('#desc_product-error').val('');

    $('.colorProduct-error').text(' ');
    $('.image_detail-error').text(' ');
    

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
    let status=$('#state_product').val();
    let checkSuccess=true;
    if(status!="insertProductDetail"){
        $.ajax({
            type: "POST",
            url:'/Admin/Product/Store',
            data:new FormData($('#form_product')[0]),
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data){
                checkSuccess=true;
            },
            error: function (reject){
                let respone = $.parseJSON(reject.responseText);
                checkSuccess=false;
                $.each(respone.errors, function(key, val) {
                    $('#' + key + '-error').text(val[0]);
                    if(key == 'desc_product'){
                        step=2;
                        stepDialog(step);
                    }else{
                        step=1;
                        stepDialog(step);
                    }             
                });
                
            }
        }).then(function (data){
             $('.id_product_detail').val(data);
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
                        checkSuccess=data;
                    },
                    error: function(reject) {
                        numberError++;
                        let responeDetail = $.parseJSON(reject.responseText);
                        checkSuccess=false;
                        $.each(responeDetail.errors, function(key, val) {
                             $('#' +key+'-error-'+numberError).text(val[0]);
                             $('#state_product').val('insertProductDetail');
                        });
                    }
                });
            };
            
            
        }).then(function(data){
            if(checkSuccess==data){
                closeModal();
                resetAllForm();
                getDataProduct(0,' ');
                $('#alertSuccess').html(
                    '<div class="alert alert-success">' +
                    '<strong>Success!</strong> Create product Successfull' +
                    '</div> <br>');
            }
        });
    }else{
        // Lấy dữ liệu của chi tiết sản phẩm  
        var numberError=0; 
        resetError();     
       for (var i = 0; i <$('.div_product_detail').length;i++) {
           $.ajax({              
               type: 'POST',
               url: '/Admin/Product/StoreDetail',
               dataType: 'json',
               data:new FormData($('.form_product_detail')[i]),
               contentType: false,
               processData: false,
               success: function (data){
                   console.log(data);
               },
               error: function(reject) {
                   numberError++;
                   let responeDetail = $.parseJSON(reject.responseText);
                   $.each(responeDetail.errors, function(key, val) {                   
                        $('#' +key+'-error-'+numberError).text(val[0]);
                        $('#state_product').val('insertProductDetail');
                   });
               }
           });
       };
       setTimeout(function() {
        if(numberError==0){
            closeModal();
            resetAllForm();
            getDataProduct(0,' ');
            $('#alertSuccess').html(
                '<div class="alert alert-success">' +
                '<strong>Success!</strong> Create product Successfull' +
                '</div> <br>');
        }
       },$('.div_product_detail').length*300); 
       
    }
    
}

function updateProduct(){

}

function deleteProduct(){

}
function saveProduct(){
    $('#saveProduct').click(function (){     
        for (instance in CKEDITOR.instances) {CKEDITOR.instances[instance].updateElement()}
        let status=$('#state_product').val();
        
        if(status=="insert" || status=='insertProductDetail'){
            createNewProduct();
        }else{
            updateProduct();
        }
    
    });
}
