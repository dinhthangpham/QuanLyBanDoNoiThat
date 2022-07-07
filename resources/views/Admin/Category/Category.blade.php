@extends('Common.Admin.Home')
@section('content_home')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <button style="float:right;" name="btn_category-add" id="btn_category-add"
                class="btn btn-success btn_category-add">Add</button>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="category_search" name="category_search"
                style="width:80%; margin-left:75px;margin-top:20px;" id="usr" placeholder="Search">
        </div>
        <div id="alertSuccess">

        </div>

        <div class="card-body p-0">
            <div class="" id="tableCategory">
                @include('Admin.Category.CategoryTable')

            </div>
        </div>
        {{-- Dialog add, update --}}
        @extends('Common.Dialog')

    @section('title_dialog')
        <h3>Category Manager</h3>
    @endsection

    @section('content_dialog')
        <form id="form_category" enctype="multipart/form-data">
            @csrf
            <div class="form-group" id="infor_category">
                <div><label for="usr">Name Category</label>
                    <input type="text" name="name_category" id="name_category" class="form-control">
                    <small id="name_category-error" class="text-danger"></small>
                </div>
                <label for="usr">Choose Image</label>
                <div class="input-group">
                    <input type="file" name="img_category" id="img_category" class="form-control">
                </div>
                <small id="img_category-error" class="text-danger"></small>

                <img style="width: 100px; margin-top:10px;" src="/Admin/Image/no-image.jpg" id="img-category-demo" alt="">
                <br>
                <label for="usr">Description category</label>
                <textarea name="desc_category" id="desc_category" class="form-control" cols="30" rows="10"></textarea>

                <button type="submit" style="margin:10px; float:right" name="btn-category_insert"
                    class="btn btn-success">Save</button>
            </div>
        </form>
    @endsection
    <input type="hidden" name="" id="exits_category">
    <input type="hidden" name="" id="state_category">
    <input type="hidden" name="" id="page_category" value="1">
</div>



<script>
    $(document).ready(function() {
        changeFileToImage('img_category', '#img-category-demo');
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#page_category').val(page);
            var category_search = $('#category_search').val();
            getData(page, category_search);
        });
        submitFormCategory();
        searchCategory();
        insertCategory();
    });

    function searchCategory() {
        $(document).on('keyup', '#category_search', function() {
            var category_search = $(this).val();
            var page = $('#page_category').val();
            getData(page, category_search);

        });
    }

    function searchByNameCategory() {
        $(document).on('keyup', '#name_category', function() {
            let name_category = $("input[name='name_category']").val();
            $.ajax({
                type: "get",
                url: '{{ route('admin.category.searchByName') }}',
                data: {
                    name_category: name_category
                },
                success: function(data) {
                    if (data.status == 'exist') {
                        $('#name_category-error').text('Category name already exists');
                        $('#exits_category').val('true');
                    } else {
                        $('#name_category-error').text('');
                        $('#exits_category').val('false');
                    }

                }
            })
        });

    }

    function insertCategory() {
        $(document).on('click', "#btn_category-add", function() {
            $('#alertSuccess').html('');
            $('#name_category').val('');
            $('#img_category').val('');
            $('#desc_category').val('');
            $('#img-category-demo').attr('src', '/Admin/Image/no-image.jpg');
            $('#state_category').val('insert');
            OpenModal();
            searchByNameCategory();
        });
    }

    function getData(page, category_search) {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.category.search') }}?page=" + page + "&search=" +
                category_search,
            success: function(data) {
                $('#tableCategory').html(data);
            }
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

    function updateCategory(categoryid, index_line) {
        var line_category = $(".line-category-" + index_line);
        $('#alertSuccess').html('');
        $.ajax({
            type: "get",
            url: '{{ route('admin.category.searchById') }}',
            data: {
                categoryid: categoryid
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('#infor_category').html(data);
            }
        }).then(function(data) {
            changeFileToImage('img_category', '#img-category-demo');
        });
        $('#state_category').val('update');
        OpenModal();
    }

    function submitFormCategory() {
        $(document).on('submit', '#form_category', function(e) {
            e.preventDefault();
            $('#name_category-error').text('');
            $('#img_category-error').text('');
            console.log($('#state_category').val())
            if ($('#state_category').val() == "update") {
                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.category.update') }}',
                    dataType: "JSON",
                    data: new FormData($('#form_category')[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        closeModal();
                        $('#form_category')[0].reset();
                         $('#img-category').attr('src','/Admin/Image/no-image.jpg');
                        $('#alertSuccess').html(
                            '<div class="alert alert-success">' +
                            '<strong>Success!</strong> Update Category Successfull' +
                            '</div> <br>');
                        console.log(data);
                        var page = $('#page_category').val();
                        getData(page, '');
                    },
                    error: function(reject) {
                        let respone = $.parseJSON(reject.responseText);
                        $.each(respone.errors, function(key, val) {
                            $('#' + key + '-error').text(val[0]);
                        });
                    }
                });
            } else if ($('#state_category').val() == "insert") {
              
                if ($('#exits_category').val() == "false") {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('admin.category.insert') }}',
                        dataType: "JSON",
                        data: new FormData($('#form_category')[0]),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            closeModal();
                            $('#alertSuccess').html(
                                '<div class="alert alert-success">' +
                                '<strong>Success!</strong> Create a new Category' +
                                '</div> <br>');
                                $('#form_category')[0].reset();
                                $('#img-category').attr('src','/Admin/Image/no-image.jpg');
                            let html = '<tr><td>' + data.id + '</td>+<td>' + data.name +
                            '</td><td>';
                            html +=
                                '<img style="width: 100px;height: 100px; background-size=cover;" src=" ' +
                                data.image + ' " alt=""></td>';
                            html +=
                                '<td style="max-width:190px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">';
                            html += '<span class=""> ' + data.desc + ' </span></td>';
                            html +=
                                '<td><input type="hidden" class="idCate" name="idCate" value="{{ '+data.id+' }}" </td>';
                            html +=
                                '<td><button class="btn btn-warning btn_category-update" onclick="updateCategory( ' +
                                data.id + ' ,0)" name="btn_category-update">Update</button> ';
                            html +=
                                '<button class="btn btn-danger btn_category-delete" onclick="deleteCategory( ' +
                                data.id +
                                ' ,0)"  name="btn_category-delete">Delete</button></td></tr>';
                            let categoryCurrent = html + document.getElementById('listCategory')
                                .innerHTML;
                            document.getElementById('listCategory').innerHTML = categoryCurrent;
                        },
                        error: function(reject) {
                            let respone = $.parseJSON(reject.responseText);
                            $.each(respone.errors, function(key, val) {
                                $('#' + key + '-error').text(val[0]);
                            });
                        }
                    });
                } else {
                    $('#name_category-error').text('Category name already exists');
                }
            }

        });
    }

    function deleteCategory(categoryid, index_line) {
        var result = confirm("Want to delete?");
        if (result) {
            console.log(categoryid);
            $.ajax({
                type: "get",
                url: "{{ route('admin.category.delete') }}",
                dataType: "JSON",
                data: {
                    categoryid: categoryid
                },
                success: function(data) {
                    var page = $('#page_category').val();
                    getData(page, " ");
                    alert("Đã xóa thành công");
                }
            });
        }
    }
</script>
@endsection
