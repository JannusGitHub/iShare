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
                    <div class="col-md-12" style="margin-bottom: 50px !important;">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title fw-bold mt-2">Group List</h3>
                                <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#modalAddGroup"><i class="fa fa-plus fa-md"></i> New Group</button>
                            </div>
                            <div class="card-body">
                                <div class="text-center d-none" id="noGroupList">Groups will be shown here</div>
                                <div id="divGroup" class="mb-3">
                                    <div class="row row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-1 g-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <!-- Add Group Modal Start -->
    <div class="modal fade" id="modalAddGroup" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Group Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formAddGroup" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For Edit -->
                                    <input type="text" class="form-control" style="display: none" name="group_id">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 50% !important;">
                                            <span class="input-group-text w-100 text-left" id="inputGroup-sizing-default">Group Name</span>
                                        </div>
                                        <input type="text" class="form-control" name="group_name" id="textAddGroupName">
                                    </div>
                                    
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 50% !important;">
                                            <span class="input-group-text w-100 text-left" id="inputGroup-sizing-default">Group Code</span>
                                        </div>
                                        <input type="text" class="form-control" name="group_code" id="textAddGroupCode">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 50% !important;">
                                            <span class="input-group-text w-100 text-left" id="inputGroup-sizing-default">Group Leader</span>
                                        </div>
                                        
                                        <select class="form-control select2 select2-bs5" id="selectGroupLeader" name="group_leaders[]" multiple="true" style="width: 50%">
                                            <!-- Auto Generated -->
                                        </select>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 50% !important;">
                                            <span class="input-group-text w-100 text-left" id="inputGroup-sizing-default">Date Created</span>
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
                        <button type="submit" id="buttonAddGroup" class="btn btn-primary" title="On going module"><i id="iconAddGroup" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- Add Group Modal End -->

    <!-- Join Group Modal Start -->
    <div class="modal fade" id="modalJoinGroup" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Join Group</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="formJoinGroup" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For Edit -->
                                    <input type="text" class="form-control" style="display: none" name="group_id">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 50% !important;">
                                            <span class="input-group-text w-100 text-left" id="inputGroup-sizing-default">Group Code</span>
                                        </div>
                                        <input type="text" class="form-control" name="group_code" id="textJoinGroupCode">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonJoin" class="btn btn-primary" title="On going module"><i id="iconJoinGroup" class="fa fa-check"></i> Join</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Join Group Modal End -->

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
            getGroupList();
            
            $("#formAddGroup").submit(function(event){
                event.preventDefault();
                addGroup();
            });
            
            /**
             * Get all Group Leaders
            */
            $('select[name="group_leaders[]"]', $("#formAddGroup")).select2({
                placeholder: "Select a leader",
                minimumInputLength: 1,
                allowClear: true,
                ajax: {
                    url: "{{ route('get_users') }}",
                    // url: "{{ route('get_users_except_faculty_for_group') }}",
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
             * Join Group
            */
            $("#formJoinGroup").submit(function(event){
                event.preventDefault();
                joinGroup();
            });
            
            /**
             * Get Group Id that was clicked to be use in Join Group
            */
            $(document).on('click', '.buttonJoinGroup', function(){
                let groupId = $(this).attr('group-id');
                // console.log('groupId ', groupId);
                $("input[name='group_id'", $("#formJoinGroup")).val(groupId);
                // getGroupById(groupId);
            });
            
            // $("#formEditGroupStatus").submit(function(event){
            //     event.preventDefault();
            //     editGroupStatus();
            // });
        });
    </script>
@endsection
