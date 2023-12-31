@php
    $userLevelId = session('session_user_level_id'); // Or $userLevelId = session()->get('session_user_level_id'); Or $userLevelId = Session::get('session_user_level_id');
    $userFullname = session('session_fullname'); // Or $userLevelId = session()->get('session_user_level_id'); Or $userLevelId = Session::get('session_user_level_id');
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
                    <div class="col-xl-9">
                        <div class="card" style="min-height: 330px;">
                            <div class="card-header">
                                <h3 class="card-title fw-bold mt-2">My Group</h3>
                                <button type="button" class="btn btn-primary float-right d-none" id="buttonAddTitle" data-bs-toggle="modal" data-bs-target="#modalAddTitle"><i class="fa fa-plus fa-md"></i> Add Title</button>
                            </div>
                            <div class="container-fluid">
                                <div class="text-center my-3" id="noGroupList">Your group will be shown here</div>
                                <div class="d-none m-3 mt-5" id="divGroup">
                                    <div class="table-responsive">
                                        <table id="tableTitle" class="table table-sm table-bordered table-hover display nowrap" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Group</th>
                                                    <th>Group Leader</th>
                                                    <th>Section</th>
                                                    <th>Title</th>
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
                    <div class="col-xl-3">
                        <div class="card" style="min-height: 330px;">
                            <div class="card-header">
                                <h3 class="card-title fw-bold mt-2">Group Details</h3>
                                <button type="button" class="btn btn-danger float-right d-none" id="buttonLeaveGroup" data-bs-toggle="modal" data-bs-target="#modalLeaveGroup"><i class="fa-solid fa-right-from-bracket"></i> Leave</button>
                            </div>
                            <div class="text-center my-3" id="noGroupDetails">Your group details will be shown here</div>
                            <div id="divGroupDetails" class="mx-3 d-none">
                                <div class="text-center">
                                    <img style="width: 100px; height: auto;" class="my-4" src="{{ asset('/images/img/networking.png') }}" alt="">
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
                                    <span><i class="fas fa-info-circle"></i>&nbsp;All of the titles that you submitted will also be deleted. Are you sure you want to leave?</span>
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

    <div class="modal fade" id="modalAddTitle" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Add Title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddTitle" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For Edit -->
                                    <input type="text" class="form-control" style="display: none" name="title_id">

                                    <div class="card">
                                        <div class="card-header">
                                            <i class="fas fa-info-circle"></i>&nbsp;Input your group details
                                        </div>
                                        <div class="card-body">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend" style="width: 50% !important;">
                                                    {{-- <span class="input-group-text w-100 text-left" id="inputLibrary-sizing-default">Group Number</span> --}}
                                                    <span class="input-group-text w-100 text-left" id="inputLibrary-sizing-default">Group</span>
                                                </div>
                                                <input type="text" class="form-control" name="group_number" id="textAddGroupNumber" placeholder="Group">
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend" style="width: 50% !important;">
                                                    <span class="input-group-text w-100 text-left" id="inputLibrary-sizing-default">Section</span>
                                                </div>
                                                <select class="form-control select2 select2-bs5" id="selectSection" name="section" placeholder="Section">
                                                    <!-- Auto Generated -->
                                                    {{-- <option value="0" disabled selected>Select One</option>
                                                    <option value="1">BTVTE-CH</option>
                                                    <option value="2">BTVTE-CP</option>
                                                    <option value="3">BTVTE-ELEXT</option>
                                                    <option value="4">BTVTE-IT</option> --}}
                                                </select>
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend" style="width: 50% !important;">
                                                    <span class="input-group-text w-100 text-left" id="inputLibrary-sizing-default">Group Member</span>
                                                </div>
                                                <select class="form-control select2 select2-bs5" id="selectGroupMember" name="group_members[]" multiple="true" style="width: 50%">
                                                    <!-- Auto Generated -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card">
                                        <div class="card-header">
                                            <i class="fas fa-info-circle"></i>&nbsp;Click <span class="text-primary"><i class="fa fa-plus fa-md"></i>Add Row</span> to add titles. Maximum 3 titles are allowed.
                                        </div>
                                        <div class="card-body">
                                            <div class="input-group mb-3 justify-content-end">
                                                <button type="button" class="btn btn-primary" style="min-width: 110px;" id="buttonAddRow"><i class="fa fa-plus fa-md"></i>&nbsp;Add Row</button>
                                            </div>
                                            <div id="divDynamicRow">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonSubmitTitle" class="btn btn-primary"><i id="iconAddTitle" class="fa fa-check"></i> Submit</button>
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
            $('.select2').select2();
            $('.select2-bs5').select2({
                theme: 'bootstrap-5'
            });

            /**
             * Get Sections
            */
            getSectionsForMyGroup($('#selectSection'));

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
                    url: "view_title",
                    data: function (param){
                        param.session_user_id = $('#sessionUserId').val();
                    },
                },
                "columns":[
                    { "data" : "action", orderable:false, searchable:false},
                    { "data" : "group_number"},
                    { "data" : "group_leader_name_info.fullname"},
                    { "data" : "section_info.section_name"},
                    { "data" : "title"},
                    { "data" : "group_member"},
                    { "data" : "status"},
                ],
                "columnDefs": [
                    { className: 'align-middle', targets: [0, 1, 2, 3, 4, 5, 6] },
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
             * Get all Group Leaders
            */
            $('select[name="group_members[]"]', $("#formAddTitle")).select2({
                placeholder: "Select Member",
                minimumInputLength: 1,
                allowClear: true,
                ajax: {
                    url: "{{ route('get_users') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        console.log('params',params);
                        return {
                            search: params.term,
                        };
                    },
                    processResults: function (data) {
                        // console.log(data);
                        // console.log(data['results'][0]['id']);
                        // console.log(data['results'][0]['text']);
                        return {
                            results: data['results']
                        };
                    },
                    cache: true
                },
            });

            /**
             * Add row for adding dynamic titles
            */
            let count = 1;
            function addRow(number){
                let html = "";
                html +=   ' <div class="input-group mb-3">';
                html +=        '<div class="input-group-prepend" style="width: 50% !important;">';
                html +=            '<span class="input-group-text w-100 text-left" id="inputLibrary-sizing-default">Title</span>';
                html +=        '</div>';
                html +=        '<input type="text" class="form-control" name="title[]" id="textAddTitle" placeholder="Title">';
                html +=        '<button type="button" class="btn btn-danger" style="min-width: 110px;" name="button_delete_row" id="buttonRemoveRow"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Remove</button>';
                html +=    '</div>';
                $('body #divDynamicRow').append(html);
            }
            addRow(count);

            /**
             * Add another row
            */
            $('#buttonAddRow').click(function (e) {
                if(count < 3){
                    count++;
                    addRow(count);
                }else{
                    toastr.warning('Maximum 3 titles only!');
                }
            });

            /**
             * Remove existing row
            */
            $(document).on('click','#buttonRemoveRow ',function () {
                if(count !== 1){
                    count--;
                    $(this).closest(".input-group").remove();
                }
            });

            $("#formAddTitle").submit(function(event){
                event.preventDefault();
                addTitle();
            });

            $(document).on('click','#textAddTitle', function (e) { 
                let arr = $('input[name="title[]"]').map(function (index, value) {
                    console.log('index ', index);
                    console.log('value ',  $(value).val());
                    console.log('asdasdsad ',  $('input[name="title[]"]')[index]);
                }).get();
            });
        });
    </script>
@endsection
