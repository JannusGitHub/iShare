{{-- @if(session('session_user_id'))
    <script type="text/javascript">
        window.location = "{{ url('dashboard') }}";
    </script>
@else --}}
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>iShare</title>
        @include('shared.css_links.css_links')
    </head>
    <body>
        <div class="container d-flex align-items-center min-vh-100" style="background-color: lightblue;">
            <div class="row mx-auto align-items-center">
                <div class="d-flex justify-content-center py-4">
                    <a href="#" class="logo d-flex align-items-center w-auto">
                        <img src="{{ asset('/images/img/ishare.png') }}" alt="">
                        <span class="d-none d-lg-block">iSHARE</span>
                    </a>
                </div>

                <div class="col-lg-10 mx-auto shadow p-4 rounded" style="background-color: beige; background-position: center;">
                    <h3 class="fw-bold text-center">Login to Your Account</h3>
                    <form id="formSignIn">
                        <div class="mb-3">
                            <label for="textTUPTIdNumber" class="form-label">TUPT ID Number<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tupt_id_number" id="textTUPTIdNumber" placeholder="Username">
                        </div>
                        <div class="mb-3">
                            <label for="textPassword" class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="textPassword" placeholder="Password">
                        </div>
                        <div class="submit-button text-right">
                            <button class="btn btn-primary w-100" id="buttonLogin" type="submit"><i id="buttonLoginIcon" class="fa fa-check"></i> Login</button>
                        </div>
                        <div class="d-flex justify-content-between pt-3">
                            <p class="mb-0">Don't have account? <a href="{{ route('register') }}">Create an account</a></p>
                            <a href="{{ route('forgot_password') }}">Forgot password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </body>
    </html>

    @include('shared.js_links.js_links')

    <script>
        $(document).ready(function(){
            $("#formSignIn").submit(function(event){
                event.preventDefault();
                signIn();
            });

        });
        
    </script>
{{-- @endif --}}