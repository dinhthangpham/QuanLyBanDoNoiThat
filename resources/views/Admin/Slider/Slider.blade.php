@extends('Common.Admin.Home')
@section('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }

        i {
            padding: 5px;
        }

        .error {
            color: red;
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
            <input type="text" class="form-control" id="slider_search" name="slider_search"
                style="width:80%; margin-left:75px;margin-top:20px;" id="usr" placeholder="Search">
        </div>
        <div id="alertSuccess">

        </div>

        <div class="card-body p-0">
            <div class="" id="table_silder">
                @include('Admin.slider.sliderTable')
            </div>
        </div>
        {{-- Dialog add, update --}}
        @extends('Common.Dialog')

    @section('title_dialog')
        <h3>Slider Manager</h3>
    @endsection

    @section('content_dialog')
        <form action="" method="post" id="form_slider" enctype="multipart/form-data">
            <div class="form-group">
                <label for="">Name Slider</label>
                <input type="text" name="nameSlider" class="form-control" id="nameSlider">
            </div>
            <div class="form-group">
                <label for="">Url</label>
                <input type="text" name="urlSlider" class="form-control" id="urlSlider">
            </div>
            <div class="form-group">
                <label for="">Image</label>
                <input type="file" name="imageSlider" class="form-control" id="imageSlider">
                <br>
                <img style="width: 100px; margin-top:10px;" src="/Admin/Image/no-image.jpg" class="img-slider-demo"
                    id="img-slider-demo" alt="">
            </div>
            <div class="form-group">
                <label for="">Active</label>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" id="ckoYesActive" value=1 type="radio" name="rdoSlider">
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="ckoNoActive" value=0 type="radio" name="rdoSlider">
                        <label class="form-check-label">No</label>
                    </div>
                </div>
            </div>
            <input type="hidden" name="idSlider" class="idSlider" id="idSlider">
            @csrf
            <input style="float: right;" type="button" value="Save" id="btnSaveSlider" class="btn btn-primary">
        </form>
    @endsection
    <input type="hidden" name="" id="exits_silder">
    <input type="hidden" name="" value="insert" id="state_slider">
    <input type="hidden" name="" id="page_slider" value="1">
</div>

<script>
    $(document).ready(function() {
        openDialogInsert();
        paginateSlider();
        saveSlider();
        searchProduct();


    });

    function paginateSlider() {
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#page_slider').val(page);
            var slider_search = $('#slider_search').val();
            getDataSlider(page, slider_search);
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

    function saveSlider() {
        $('#btnSaveSlider').on('click', function(e) {
            e.preventDefault();

            if ($('#state_slider').val() == 'insert') {

                $("#form_slider").validate({
                    rules: {
                        nameSilder: "required",
                        urlSlider: "required",
                        imageSlider: "required",
                        rdoSlider: "required"
                    },
                    messages: {
                        nameSilder: "Name Slider must be fill",
                        urlSlider: "Url Slider must be fill",
                        imageSlider: "Image Slider must be choose",
                        rdoSlider: "Active must be choose"
                    }
                })
                if ($('#form_slider').valid() == true) {
                    // Gửi form add
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: '{{ route('admin.slider.insert') }}',
                        data: new FormData($('#form_slider')[0]),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            console.log("success");
                            getDataSlider(1, '');
                            closeModal();
                            $('#alertSuccess').html(
                                '<div class="alert alert-success">' +
                                '<strong>Success!</strong> Create Slider Successfull' +
                                '</div> <br>');
                        }
                    })
                }
            } else if ($('#state_slider').val() == 'update') {
                // Gửi form update
                let check=confirm('Are you sure to change this');
                if(check){
                    $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '{{ route('admin.slider.update') }}',
                    data: new FormData($('#form_slider')[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var page=$('#page_slider').val();
                        var slider_search = $('#slider_search').val();
                        getDataSlider(page, slider_search);
                        closeModal();
                        $('#alertSuccess').html(
                            '<div class="alert alert-success">' +
                            '<strong>Success!</strong> Update Slider Successfull' +
                            '</div> <br>');
                    }
                });
                }
                
            }
        });
    }

    function openDialogInsert() {
        $(document).on('click', "#btn_product-add", function() {

            changeFileToImage('imageSlider', "#img-slider-demo")
            resetFormSlider();
            OpenModal();
            $('#state_slider').val('insert');
        });

    }
    function deleteSlider(id){
        let check=confirm('Are you sure you want to delete');
        if(check){
            $.ajax({
            type:"post",
            url:"{{ route('admin.slider.delete') }}",
            data:{
                id:id,
                "_token": "{{ csrf_token() }}",
            },
            success:function(data) {
                if(data){
                    $('#alertSuccess').html(
                            '<div class="alert alert-success">' +
                            '<strong>Success!</strong> Delete Slider Successfull' +
                            '</div> <br>');
                    var page=$('#page_slider').val();
                    var slider_search = $('#slider_search').val();
                    getDataSlider(page, slider_search);
                }
            }

        });
        }
       
    }

    function openDiaLogUpdate(idSlider) {
        resetFormSlider();
        $('#state_slider').val('update');
        $.ajax({
            type: "get",
            dataType: "json",
            url: '{{ route('admin.slider.get') }}',
            data: {
                idSlider: idSlider
            },
            success: function(data) {
                $("#nameSlider").val(data[0].name_slider);
                $("#urlSlider").val(data[0].url);
                $("#idSlider").val(data[0].id);
                if (data[0].active == 1) {
                    $("#ckoYesActive").attr('checked', 'checked')
                } else {
                    $("#ckoNoActive").attr('checked', 'checked')
                }
                $("#img-slider-demo").attr("src", data[0].image);
                OpenModal();
            }
        });
    }

    function resetFormSlider() {
        $('#form_slider')[0].reset();
        $("label.error").hide();
        $(".error").removeClass("error");
        $("#img-slider-demo").attr("src", '/Admin/Image/no-image.jpg');
        $('#alertSuccess').html('');
        $("#ckoNoActive").removeAttr('checked');
        $("#ckoYesActive").attr('checked', 'checked')
    }

    function getDataSlider(page, search) {
        $.ajax({
            type: "GET",
            url: "/Admin/Slider/GetData?page=" + page + "&search=" + search,
            success: function(data) {
                $('#table_silder').html(data);
            }
        });
    }

    function searchProduct() {
        $(document).on('keyup', '#slider_search', function() {
            var slider_search = $(this).val();
            var page = $('#page_silder').val();
            getDataSlider(page, slider_search);

        });
    }
</script>


@endsection
