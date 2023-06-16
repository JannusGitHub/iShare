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
                        <h1>Topics Management</h1>
                    </div>
                    <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Topics Management</li>
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
                                <h3 class="card-title fw-bold mt-2">Topics</h3>
                                {{-- <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#modalAddTopics"><i class="fa fa-plus fa-md"></i> Add New</button> --}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tableTitle" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Group Number</th>
                                                <th>Group Leader</th>
                                                <th>Section</th>
                                                <th>Group Member</th>
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
                        <input type="hidden" name="title_id" placeholder="Topics Id" id="textTitleId">
                        <input type="hidden" name="title_status" placeholder="Status" id="textTitleStatus">
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonChangeStatus" class=""><i id="iconChangeStatus" class="fa fa-check"></i>&nbsp;<span id="spanButtonLabel">Submit</span></button>
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
             * Get all submitted titles
            */
            dataTablesTitle = $("#tableTitle").DataTable({
                "processing" : false,
                "serverSide" : true,
                "responsive": true,
                "orderClasses": false, // disable sorting_1 for unknown background
                // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                "ajax" : {
                    url: "view_title_for_faculty",
                    data: function (param){
                        param.session_user_id = $('#sessionUserId').val();
                    },
                },
                "columns":[
                    { "data" : "title"},
                    { "data" : "group_number"},
                    { "data" : "group_leader_name_info.fullname"},
                    { "data" : "section_info.section_name"},
                    { "data" : "group_member"},
                    { "data" : "status"},
                ],
                "columnDefs": [
                    { className: 'align-middle', targets: [0, 1, 2, 3, 4, 5] },
                ],
                "createdRow": function(row, data, index) {
                    $('td', row).eq(1).css('white-space', 'normal');
                    $('td', row).eq(2).css('white-space', 'normal');
                    // console.log('row ', row);
                    // console.log('data ', data);
                    // console.log('index ', index);
                },
            });
            
            $(document).on('click', '.actionChangeStatus', function(){
                let groupLeaderTitleStatus = $(this).attr('group-leader-title-status');
                let groupLeaderTitleId = $(this).attr('group-leader-title-id');
                
                console.log('groupLeaderTitleStatus', groupLeaderTitleStatus);
                console.log('groupLeaderTitleId', groupLeaderTitleId);
                $("#textTitleStatus").val(groupLeaderTitleStatus);
                $("#textTitleId").val(groupLeaderTitleId);

                if(groupLeaderTitleStatus == 1){
                    $("#paragraphChangeStatus").text('Are you sure to Approve?');
                    $("#spanButtonLabel").text('Approve');
                    $("#buttonChangeStatus").removeClass('btn btn-danger');
                    $("#buttonChangeStatus").addClass('btn btn-success');
                }
            });


            $("#formChangeStatus").submit(function(event){
                event.preventDefault();
                approvedTitle();
            });
        });
    </script>
@endsection
