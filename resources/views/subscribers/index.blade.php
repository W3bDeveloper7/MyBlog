@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Subscribers</div>
            <div class="card-body">
                <div class="d-flex align-content-end">

                        <a href="javascript:void(0)" role="button" id="createNewBlog" class="btn btn-success">Create New Subscriber</a> &nbsp;
                        <a href="javascript:void(0)" role="button" id="customSearchBlog" class="btn btn-warning">Custom Search Yajra Fields</a>

                </div> <br>
                <table class="table table-bordered subscriber-datatable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>name</th>
                        <th>username</th>
                        <th>status</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

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
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value=""  required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username"  required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Role</label>
                            <div class="col-sm-12">
                                <select type="text" class="form-select" id="role_id" name="role_id">
                                    <option value="1" selected>Subscriber</option>
                                    <option value="2">Admin</option>
                                </select>
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
                            <label class="col-sm-4 control-label">password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control" id="content" placeholder="Enter New Password" name="password" required="" />
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
                    <h4 class="modal-title" id="modelHeadingSearch"></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="alert alert-success print-success-msg" style="display:none">
                        <p></p>
                    </div>
                    <form id="searchForm" name="blogForm" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name_search" name="name" placeholder="Enter Name" value=""  >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="username_search" name="username" placeholder="Enter Username" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Role</label>
                            <div class="col-sm-12">
                                <select type="text" class="form-select" id="role_id_search" name="role_id">
                                    <option value="" selected>please select</option>
                                    <option value="Subscriber">Subscriber</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Status</label>
                            <div class="col-sm-12">
                                <select type="text" class="form-select" id="status_search" name="status">
                                    <option value="" selected>please select</option>
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
@endsection

@section('scripts')
    <script>
        $(()=>{
            var table = $('.subscriber-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.index') }}",
                    data: function (d) {
                        d.name      = $('#name_search').val(),
                        d.username  = $('#username_search').val(),
                        d.status    = $('#status_search').val(),
                        d.role_id   = $('#role_id_search').val(),
                        d.search    = $('input[type="search"]').val()
                    }
                },
                columns: [

                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,
                        searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'username', name: 'username'},
                    {data: 'status', name: 'status'},
                    {data: 'role_id', name: 'role_id'},
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
            Handle Edit Blog Button
             */
            $('body').on('click', '.edit', function (e) {
                e.preventDefault();
                $(".print-success-msg").css('display','none');
                var subscriber_id = $(this).data('id');
                console.log($(this).attr('data_id'))
                $.get("/list-user" +'/' + subscriber_id , function (data) {
                    $('#modelHeading').html("Edit Subscriber");
                    $('#saveBtn').val("edit-user");
                    let myModal = new Modal(document.getElementById('actionModel'));
                    myModal.show();
                    $('#user_id').val(subscriber_id);
                    //$('#image').val(data.image);
                    $('#name').val(data.name);
                    $('#username').val(data.username);
                    $('#status').val(data.status);
                    $('#role_id').val(data.role_id);
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
                        table.draw();
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
                $(".print-success-msg").css('display','none');
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
                $('#saveBtn').val("create-subscriber");
                $('#user_id').val('');
                $('#blogForm').trigger("reset");
                $('#modelHeading').html("Create New Subscriber");
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
            $('#searchBtn').val("search-Blog").text("search Subscribers");
            $('#searchForm').trigger("reset");
            $('#modelHeadingSearch').html("Custom Search Yajra");
            let myModal = new Modal(document.getElementById('searchModel'));
            myModal.show();
        });
//================================================================================//
            $('#searchBtn').on('click', function(e) {
                e.preventDefault()
                let username = $('#username_search').val();
                let status = $('#status_search').val();
                let name = $('#name_search').val();
                let role_id = $('#role_id_search').val();
                table.draw()
            });

    })
    </script>
@endsection
