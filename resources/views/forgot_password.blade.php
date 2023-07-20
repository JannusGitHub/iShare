<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>iShare System</title>
    @include('shared.css_links.css_links')

</head>
<body>
    <div class="modal fade" id="modalVerifyResetPasswordCode"  tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content" style="background-color: beige;">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Verification</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formVerifyResetPasswordCode" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="textOTPCode" class="form-label">Check your email for Reset Password Code<span class="text-danger" title="Required">*</span></label>
                                        <input type="text" class="form-control" name="reset_password_code" id="textResetPasswordCode" maxlength="6" placeholder="Ex: 123456">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonVerifyResetPasswordCode" class="btn btn-primary" title="On going module"><i id="iconVerifyResetPasswordCode" class="fa fa-check"></i> Verify</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container d-flex align-items-center min-vh-100" style="background-color: lightblue;">
        <div class="row mx-auto align-items-center">
            <div class="d-flex justify-content-center py-4">
                <a href="#" class="logo d-flex align-items-center w-auto">
                    <img src="{{ asset('/images/img/ishare.png') }}" alt="">
                    <span class="d-none d-lg-block">iSHARE</span>
                </a>
            </div>

            <div class="col-lg-12 shadow p-4 rounded" style="background-color: beige; background-position: center;">
                <h3 class="fw-bold text-center">Forgot Password</h3>
                <form id="formForgotPassword">
                    {{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}
                    @csrf
                    <div class="mb-3">
                        <label for="textEmail" class="form-label">Email<span class="text-danger" title="Required">*</span></label>
                        <input type="email" name="email" class="form-control" id="textEmail" placeholder="ishare@tup.edu.ph">
                    </div>
                    <div class="submit-button text-center">
                        <button class="btn btn-primary w-100" id="buttonSubmit" type="submit"><i id="buttonSubmitIcon" class="fa fa-check"></i> Submit</button>
                    </div>
                    <div class="col-12 pt-3">
                        <a href="{{ route('login') }}">Remember password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalChangePassword"  tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content" style="background-color: beige;">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Change Password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formChangePassword" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="textFullname" class="form-label">Email<span class="text-danger" title="Required">*</span></label>
                                        <input type="text" name="email" class="form-control" readonly id="textEmail">
                                    </div>
                                    <div class="mb-3">
                                        <label for="textFullname" class="form-label">Name<span class="text-danger" title="Required">*</span></label>
                                        <input type="text" name="fullname" class="form-control" readonly id="textFullname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="textPassword" class="form-label">Password<span class="text-danger" title="Required">*</span></label>
                                        <input type="password" class="form-control" name="password" id="textPassword" placeholder="Password">
                                    </div>
                                    <div class="mb-3">
                                        <label for="textConfirmPassword" class="form-label">Confirm Password<span class="text-danger" title="Required">*</span></label>
                                        <input type="password" class="form-control" name="confirm_password" id="textConfirmPassword" placeholder="Confirm Password">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonChangePassword" class="btn btn-primary" title="On going module"><i id="iconChangePassword" class="fa fa-check"></i> Submit</button>
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
        $('.select2').select2();
        $('.select2-bs5').select2({
            theme: 'bootstrap-5'
        });

        /**
         * Get Sections
        */
        getSections($('#selectSection'));
        
        /**
         * Add user
        */
        $("#formForgotPassword").submit(function(event){
            event.preventDefault();
            sendResetPasswordCode();
        });
        
        $("#formVerifyResetPasswordCode").submit(function(event){
            event.preventDefault();
            verifyResetPasswordCode();
        });

        $("#modalChangePassword").submit(function(event){
            event.preventDefault();
            formChangePassword();
        });
    });
</script>