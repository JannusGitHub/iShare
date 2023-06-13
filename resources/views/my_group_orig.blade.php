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
                        <h1>Group Management</h1>
                    </div>
                    <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Group Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="margin-bottom: 100px;">
                            <div class="card-header">
                                <h3 class="card-title fw-bold mt-2">My Group</h3>
                                <button type="button" class="btn btn-danger float-right d-none" id="buttonLeaveGroup" data-bs-toggle="modal" data-bs-target="#modalLeaveGroup"><i class="fa-solid fa-right-from-bracket"></i> Leave Group</button>
                            </div>
                            <div class="container-fluid">
                                <div class="text-center my-3" id="noGroupList">Your group will be shown here</div>
                                <div class="d-none" id="divGroup">
                                    <div class="row">
                                        <div class="col-lg-9 border-end">
                                            <div class="h-100">
                                                <div class="table-responsive my-5">
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
                                        <div class="col-lg-3 border-bottom" id="divGroupDetails" style="max-height: 400px;">
                                            <h3 class="mt-2 text-center">Group Details</h3>
                                            <div class="text-center">
                                                <img style="width: 200px; height: auto;" class="my-3" src="{{ asset('/images/img/networking.png') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
    </div>
    
    <div class="modal fade" id="modalLeaveGroup" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Leave Group</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formLeaveGroup" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <span>Are you sure you want to leave?</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonLeaveGroup" class="btn btn-primary"><i id="iconLeaveGroup" class="fa fa-check"></i> Leave</button>
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

            /**
             * Get all Groups
            */
            let sessionUserId = $('#sessionUserId').val();
            getMyGroup(sessionUserId);
            
            /**
             * Leave Group
            */
            $("#formLeaveGroup").submit(function(event){
                event.preventDefault();
                leaveGroup();
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
        });
    </script>
@endsection
