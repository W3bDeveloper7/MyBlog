@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Blogs</div>
            <div class="card-body">
                <div class="d-flex align-content-end">

                        <a href="javascript:void(0)" role="button" id="createNewBlog" class="btn btn-success">Create New Blog</a> &nbsp;
                        <a href="javascript:void(0)" role="button" id="customSearchBlog" class="btn btn-warning">Custom Search Yajra Fields</a>

                </div> <br>
                {{ $dataTable->table() }}

            </div>
        </div>
    </div>

    <div class="modal fade" id="actionModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="alert alert-success print-success-msg" style="display:none">
                        <p></p>
                    </div>
                    <form id="blogForm" name="blogForm" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="blog_id" id="blog_id">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value=""  required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="image" class="col-sm-2 control-label">Image</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control" id="image" name="image" placeholder="Please Upload Image"  required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Publish Date</label>
                            <div class="col-sm-12">
                                <input type="date" class="form-control" id="publish_date" name="published_at" placeholder="Enter Publish Date"  required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Status</label>
                            <div class="col-sm-12">
                                <select type="text" class="form-select" id="status" name="status" required="">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Content</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="content" name="blog_content" placeholder="Enter Content"  required=""></textarea>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10 pt-3" >
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="searchModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="alert alert-success print-success-msg" style="display:none">
                        <p></p>
                    </div>
                    <form id="searchForm" name="blogForm" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="blog_id" id="blog_id">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title_search" name="title" placeholder="Enter Title" value=""  >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Publish Date</label>
                            <div class="col-sm-12">
                                <input type="date" class="form-control" id="publish_date_search" name="published_at" placeholder="Enter Publish Date" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Status</label>
                            <div class="col-sm-12">
                                <select type="text" class="form-select" id="status_search" name="status">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10 pt-3" >
                            <button type="submit" class="btn btn-primary" id="searchBtn" value="create">Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

@section('scripts')
    <script>
        $(()=>{
            //setup ajax header
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
//==================================================================================//
            /*
            Handle Edit Blog Button
             */
            $('body').on('click', '.edit', function (e) {
                e.preventDefault();
                var blog_id = $(this).closest('tr').attr('id');
                $.get("/list-blog" +'/' + blog_id , function (data) {
                    $('#modelHeading').html("Edit Blog");
                    $('#saveBtn').val("edit-user");
                    let myModal = new Modal(document.getElementById('actionModel'));
                    myModal.show();
                    $('#blog_id').val(blog_id);
                    //$('#image').val(data.image);
                    $("#image").closest('.form-group').css('display','block');
                    $("#content").closest('.form-group').css('display','block');
                    $('#title').val(data.title);
                    $('#content').val(data.blog_content);
                    $('#publish-date').val(data.published_date);
                    $('#status').val(data.status);
                })
            });
//============================================================================================//
            /*
            Save or update data
             */
            $("body").on("click","#saveBtn",function(e){
                e.preventDefault()
                var form = $(this).closest("form")[0];
                var formData = new FormData($(this).closest("form")[0]);
                $.ajax({
                    url: window.location.pathname,
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $(".print-error-msg").css('display','none');
                        $(".print-success-msg").find("p").html('');
                        $(".print-success-msg").css('display','block');
                        $(".print-success-msg").find("p").html("Success");
                        form.reset();
                        table.reload()
                    },
                    error: function (response){
                        printErrorMsg(response.responseJSON.errors)
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            var options = {
                complete: function(response)
                {
                    if($.isEmptyObject(response.responseJSON.error)){
                        $("input[name='title']").val('');
                        alert('Image Upload Successfully.');
                    }else{
                        printErrorMsg(response.error);
                    }
                }
            };

            function printErrorMsg (msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display','block');
                $.each( msg, function( key, value ) {
                    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                });
            }

//====================================================================================//
            /*
            create new blog
             */
            $('#createNewBlog').click(function () {
                $(".print-error-msg").css('display','none');
                $(".print-success-msg").css('display','none');
                $("#image").closest('.form-group').css('display','block');
                $("#content").closest('.form-group').css('display','block');
                $('#saveBtn').val("create-Blog");
                $('#blog_id').val('');
                $('#blogForm').trigger("reset");
                $('#modelHeading').html("Create New Blog");
                let myModal = new Modal(document.getElementById('actionModel'));
                myModal.show();
            });
//==============================================================================//
        /*
        Custom Search Yajra
         */
        $('#customSearchBlog').click(function () {
            $(".print-error-msg").css('display','none');
            $(".print-success-msg").css('display','none');
            $('#searchBtn').val("search-Blog").text("search Blog");
            $('#searchForm').trigger("reset");
            $('#modelHeading').html("Custom Search Yajra");
            let myModal = new Modal(document.getElementById('searchModel'));
            myModal.show();
        });
//================================================================================//
            $('#searchBtn').on('click', function(e){
                e.preventDefault()
            let table = $('#blogs-table').DataTable();
                let published = $('#publish_date_search').val();
                let status = $('#status_search').val();
                let title = $('#title_search').val();
                $.ajax({
                    url: window.location.pathname,
                    type: 'get',
                    data: {
                        published_at: published,
                        status: status,
                        title: title,
                    },
                    success: function (response) {
                        table.draw()
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            })
    })
    </script>
@endsection
