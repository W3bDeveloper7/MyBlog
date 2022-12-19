@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Trashed Blogs</div>
            <div class="card-body">
                <div class="d-flex align-content-end">
                        <a href="javascript:void(0)" role="button" id="customSearchBlog" class="btn btn-warning">Custom Search Yajra Fields</a>
                </div> <br>
                <table class="table table-bordered blogs-datatable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Published Date</th>
                        <th>status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="modal fade" id="searchModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeadingSearch"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <option value="" selected>Please Select</option>
                                    <option value="Active">Active</option>
                                    <option value="Disabled">Disabled</option>
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

    <div class="modal" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="deleteModalHeading" class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteForm" name="blogForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="blog_id" id="blog_id_delete" />
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>
                    <p id="nameDelete" ></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-danger" id="saveBtnDelete" value="create">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="deleteModalP" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="deleteModalHeadingP" class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteForm" name="blogForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="blog_id" id="blog_id_deleteP" />
                        <input type="hidden" name="_method" value="DELETE" />
                    </form>
                    <p id="nameDeleteP" ></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-danger" id="saveBtnDeleteP" value="create">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(()=>{
            var table = $('.blogs-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('blogs.trashed') }}",
                    data: function (d) {
                        d.title      = $('#title_search').val(),
                            d.published_at  = $('#publish_date_search').val(),
                            d.status    = $('#status_search').val(),
                            d.search    = $('input[type="search"]').val()
                    }
                },
                columns: [

                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,
                        searchable: false},
                    {data: 'title', name: 'title'},
                    {data: 'image', name: 'image'},
                    {data: 'published_at', name: 'published_at'},
                    {data: 'status', name: 'status'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
            //setup ajax header
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
//==================================================================================//
            /*
             Handle restore Btn
              */
            $('body').on('click', '.restore', function (e) {
                e.preventDefault();
                var blog_id = $(this).data('id');
                $.get("/list-blog" +'/' + blog_id , function (data) {
                    $('#deleteModalHeading').html("Restore "+ data.title);
                    $('#nameDelete').html("Are you sure you want to restore <strong >" + data.title + "</strong>?");
                    $('#saveBtnDelete').val("restore-blog").text('Restore Blog');
                    let myModal = new Modal(document.getElementById('deleteModal'));
                    myModal.show();
                    $('#blog_id_delete').val(blog_id);
                })
            });

            $("body").on("click","#saveBtnDelete",function(e){
                e.preventDefault()
                var form = $(this).closest("form")[0];
                var formData = new FormData($(this).closest("form")[0]);
                console.log($('#blog_id_delete').val())
                $.ajax({
                    url: '/restore-blog/' + $('#blog_id_delete').val() ,
                    type: 'post',
                    data: formData,
                    success: function (response) {
                        $(".print-success-msg").find("p").html('');
                        $(".print-success-msg").css('display','block');
                        $(".print-success-msg").find("p").html("Restored Successfully");
                        table.draw();
                        let myModal =  Modal.getOrCreateInstance(document.getElementById('deleteModal'));
                        myModal.hide();
                    },
                    error: function (response){
                        printErrorMsg(response.responseJSON.errors)
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
//==============================================================================//
        /*
        Custom Search Yajra
         */
        $('#customSearchBlog').click(function () {
            $(".print-error-msg").css('display','none');
            $(".print-success-msg").css('display','none');
            $('#searchBtn').val("search-Blog").text("search Blogs");
            $('#searchForm').trigger("reset");
            $('#modelHeadingSearch').html("Custom Search Yajra");
            let myModal = new Modal(document.getElementById('searchModel'));
            myModal.show();
        });
//================================================================================//
            /*
            Handle Search Btn
             */
            $('#searchBtn').on('click', function(e) {
                e.preventDefault()
                table.draw()
            });

//=================================================================================//
            /*
            Handle Delete Btn
             */
            /*
            Handle restore Btn
             */
            $('body').on('click', '.deletep', function (e) {
                e.preventDefault();
                var blog_id = $(this).data('id');
                $.get("/list-blog" +'/' + blog_id , function (data) {
                    $('#deleteModalHeadingP').html("Delete Permanently "+ data.title);
                    $('#nameDeleteP').html("Are you sure you want to delete permanently <strong >" + data.title + "</strong>?");
                    $('#saveBtnDeleteP').val("restore-blog").text('Delete Blog');
                    let myModal = new Modal(document.getElementById('deleteModalP'));
                    myModal.show();
                    $('#blog_id_deleteP').val(blog_id);
                })
            });

            $("body").on("click","#saveBtnDeleteP",function(e){
                e.preventDefault()
                var form = $(this).closest("form")[0];
                var formData = new FormData($(this).closest("form")[0]);
                $.ajax({
                    url: '/delete-blog-permanent/'+ $('#blog_id_deleteP').val(),
                    type: 'post',
                    data: formData,
                    success: function (response) {
                        $(".print-success-msg").find("p").html('');
                        $(".print-success-msg").css('display','block');
                        $(".print-success-msg").find("p").html("Restored Successfully");
                        table.draw();
                        let myModal =  Modal.getOrCreateInstance(document.getElementById('deleteModalP'));
                        myModal.hide();
                    },
                    error: function (response){
                        printErrorMsg(response.responseJSON.errors)
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

    })
    </script>
@endsection
