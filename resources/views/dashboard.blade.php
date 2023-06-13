@php
    $userLevelId = session('session_user_level_id'); // Or $userLevelId = session()->get('session_user_level_id'); Or $userLevelId = Session::get('session_user_level_id');
    if($userLevelId == 1){
        $layouts = 'layouts.admin_layout';
    }elseif ($userLevelId == 2) {
        $layouts = 'layouts.faculty_layout';
    }else{
        $layouts = 'layouts.student_layout';
    }
@endphp

@extends($layouts)
@section('title', 'Dashboard')
@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <h2 class="my-3">Dashboard</h2>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title-dashboard">USER</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <span><i class="fa-solid fa-users"></i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3" id="totalUsers">0</h1>
                                <div class="mb-0">
                                    <span class="text-muted-dashboard">Total Users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="card card-dashboard">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title-dashboard">LIBRARY</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <span><i class="fa-solid fa-users"></i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3" id="totalUploaded">0</h1>
                                <div class="mb-0">
                                    <span class="text-muted-dashboard">Total Uploads</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js_content')
    <script type="text/javascript">
        $(document).ready(function () {
            function getDataForDashboard(){
                $.ajax({
                    url: "get_data_for_dashboard",
                    method: "get",
                    dataType: "json",
                    success: function(response){
                        console.log('response ', response['totalUsers']);
                        $('#totalUsers').text(response['totalUsers']);
                        $('#totalUploaded').text(response['totalUploaded']);

                    },
                });
            }
            getDataForDashboard();
        });
    </script>
@endsection
