@php
    $sessionUserId = session('session_user_id');
@endphp

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>iShare | @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- CSS LINKS -->
        @include('shared.css_links.css_links')
        <style>
            .modal-xl-custom{
                width: 95% !important;
                min-width: 90% !important;
            }
            table.dataTable.display tbody tr.odd>.sorting_1, table.dataTable.order-column.stripe tbody tr.odd>.sorting_1 {
                background-color: none !important;
            }

            select[readonly]{
                pointer-events: none;
                touch-action: none;
                background: #e9ecef;
                /* color: #6c757d; */
            }

            /* For Dashboard */
            .stat{
                align-items: center;
                background: #d3e2f7;
                border-radius: 50%;
                color: #3b7ddd;
                display: flex;
                height: 40px;
                justify-content: center;
                width: 40px;
            }

            .card-dashboard {
                box-shadow: 0 0 0.875rem 0 rgb(33 37 41 / 5%);
            }
            
            .card-title-dashboard {
                color: #939ba2;
                font-size: .925rem;
                font-weight: 600;
            }

            .text-muted-dashboard{
                color: #6c757d!important;
            }
        </style>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            @include('shared.pages.admin_header')
            @include('shared.pages.faculty_nav')
            @include('shared.pages.admin_footer')

            <!-- Global Session Id -->
            <input type="hidden" id="sessionUserId" value="{{ $sessionUserId }}">

            <!-- Global Spinner -->
            <div class="modal fade" id="modalSpinner">
                <div class="modal-dialog">
                    <div class="modal-content pt-3">
                        <p class="spinner-border spinner-border-xl text-center mx-auto"></p>
                        <p class="mx-auto">Logging out...</p>
                    </div>
                </div>
            </div>

            @yield('content_page')
        </div>

        <!-- JS LINKS -->
        @include('shared.js_links.js_links')
        @yield('js_content')

        <script type="text/javascript">
            $(document).ready(function(){
                function UserLogout(){
                    $.ajax({
                        url: "logout",
                        method: "get",
                        dataType: "json",
                        beforeSend: function(){

                        },
                        success: function(reponse){
                            if(reponse['result'] == 1){
                                window.location = '/';
                            }
                            else{
                                alert('Logout error!');
                            }
                        }
                    });
                }

                $("#btnLogout").click(function(event){
                    $('#modalLogout').modal('hide');
                    $('#modalSpinner').modal('show');
                    setTimeout(() => {
                        UserLogout();
                        console.log("Logging out...")
                    }, 500);
                    
                });
            });
        </script>
    </body>
</html>