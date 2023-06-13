@php
    $userLevelId = session('session_user_level_id'); // Or $userLevelId = session()->get('session_user_level_id'); Or $userLevelId = Session::get('session_user_level_id');
    if($userLevelId == 1){
        $layouts = 'layouts.admin_layout';
    }elseif ($userLevelId == 2) {
        $layouts = 'layouts.faculty_layout';
    }else{
        $layouts = 'layouts.student_layout';
    }
    date_default_timezone_set('Asia/Manila');
@endphp

@extends($layouts)
@section('title', 'Dashboard')
@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Library Management</h1>
                    </div>
                    <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Library Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 50px !important;">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold mt-2">Library</h3>
                                <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#modalAddLibrary"><i class="fa fa-plus fa-md"></i> Add New</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tableLibrary" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>File Name</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <!-- Add Library Modal Start -->
    <div class="modal fade" id="modalAddLibrary" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Library Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formAddLibrary" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For Edit -->
                                    <input type="text" class="form-control" style="display: none" name="library_id">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 50% !important;">
                                            <span class="input-group-text w-100 text-left" id="inputLibrary-sizing-default">Title</span>
                                        </div>
                                        <input type="text" class="form-control" name="title" id="textAddTitle">
                                    </div>
                                    
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 50% !important;">
                                            <span class="input-group-text w-100 text-left" id="inputLibrary-sizing-default">Author</span>
                                        </div>
                                        <input type="text" class="form-control" name="author" id="textAddAuthor">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 50% !important;">
                                            <span class="input-group-text w-100 text-left" id="inputLibrary-sizing-default">File Name</span>
                                        </div>
                                        <input type="file" class="form-control" name="file_name" id="fileAddFileName">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 50% !important;">
                                            <span class="input-group-text w-100 text-left" id="inputLibrary-sizing-default">Date Created</span>
                                        </div>
                                        <input type="hidden" class="form-control" name="date_created" id="textAddDateCreated" value="{{ date('Y-m-d H:i:s') }}" readonly>
                                        <input type="text" class="form-control" value="{{ date('F d, Y') }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonAddLibrary" class="btn btn-primary" title="On going module"><i id="iconAddLibrary" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- Add Library Modal End -->

    <!-- Join Library Modal Start -->
    <div class="modal fade" id="modalJoinLibrary" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Join Library</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formJoinLibrary" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For Edit -->
                                    <input type="text" class="form-control" style="display: none" name="library_id">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 50% !important;">
                                            <span class="input-group-text w-100 text-left" id="inputLibrary-sizing-default">Library Code</span>
                                        </div>
                                        <input type="text" class="form-control" name="library_code" id="textJoinLibraryCode">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonJoin" class="btn btn-primary" title="On going module"><i id="iconJoinLibrary" class="fa fa-check"></i> Join</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Join Library Modal End -->

    <div class="modal fade" id="modalChangeStatus" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editChangeStatusTitle"><i class="fas fa-info-circle"></i> Change Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formChangeStatus" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <p id="paragraphChangeStatus"></p>
                        <input type="hidden" name="library_id" placeholder="Library Id" id="textChangeId">
                        <input type="hidden" name="status" placeholder="Status" id="textChangeStatus">
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonChangeStatus" class=""><i id="iconChangeStatus" class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

<!--     {{-- JS CONTENT --}} -->
@section('js_content')

    <script type="text/javascript">
        $(document).ready(function () {
            /**
             * Initialize Select2 Elements
            */
            $('.select2-bs5').select2({
                theme: 'bootstrap-5',
                width: 'resolve'
            });
            
            $("#formAddLibrary").submit(function(event){
                event.preventDefault();
                addLibrary();
            });

            dataTablesLibrary = $("#tableLibrary").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                "orderClasses": false, // disable sorting_1 for unknown background
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "ajax" : {
                    url: "view_library",
                    data: function (param){
                        param.session_user_id = $('#sessionUserId').val();
                    },
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "title"},
                    { "data" : "author"},
                    { "data" : "file_name"},
                    { "data" : "status"},
                ],
                "columnDefs": [
                    { className: 'align-middle', targets: [0, 1, 2, 3] },
                ],
                "createdRow": function(row, data, index) {
                    $('td', row).eq(1).css('white-space', 'normal');
                    $('td', row).eq(2).css('white-space', 'normal');
                    // console.log('row ', row);
                    // console.log('data ', data);
                    // console.log('index ', index);
                },
            });
            
            /**
             * Get Library Id that was clicked to be use in Join Library
            */
            $(document).on('click', '.buttonJoinLibrary', function(){
                let groupId = $(this).attr('group-id');
                // console.log('groupId ', groupId);
                $("input[name='library_id'", $("#formJoinLibrary")).val(groupId);
            });
            
            $(document).on('click', '.actionChangeStatus', function(){
                let libraryStatus = $(this).attr('library-status');
                let libraryId = $(this).attr('library-id');
                
                $("#textChangeStatus").val(libraryStatus);
                $("#textChangeId").val(libraryId);

                if(libraryStatus == 1){
                    $("#paragraphChangeStatus").text('Are you sure to Approve?');
                    $("#buttonChangeStatus").text('Approve');
                    $("#buttonChangeStatus").removeClass('btn btn-danger');
                    $("#buttonChangeStatus").addClass('btn btn-success');
                }else if(libraryStatus == 2){
                    $("#buttonChangeStatus").text('Reject');
                    $("#buttonChangeStatus").removeClass('btn btn-success');
                    $("#buttonChangeStatus").addClass('btn btn-danger');
                }
            });


            $("#formChangeStatus").submit(function(event){
                event.preventDefault();
                approvedStatus();
            });
        });
    </script>
@endsection
