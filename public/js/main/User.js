function sendOTP(){
	$.ajax({
        url: "send_otp",
        method: "post",
        // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: $('#formAddUser').serialize(),
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving user failed');
                if(response['error']['tupt_id_number'] === undefined){
                    $("#textTUPTIdNumber").removeClass('is-invalid');
                    $("#textTUPTIdNumber").attr('title', '');
                }
                else{
                    $("#textTUPTIdNumber").addClass('is-invalid');
                    $("#textTUPTIdNumber").attr('title', response['error']['tupt_id_number']);
                }
                if(response['error']['email'] === undefined){
                    $("#textEmail").removeClass('is-invalid');
                    $("#textEmail").attr('title', '');
                }
                else{
                    $("#textEmail").addClass('is-invalid');
                    $("#textEmail").attr('title', response['error']['email']);
                }
                if(response['error']['fullname'] === undefined){
                    $("#textFullname").removeClass('is-invalid');
                    $("#textFullname").attr('title', '');
                }
                else{
                    $("#textFullname").addClass('is-invalid');
                    $("#textFullname").attr('title', response['error']['fullname']);
                }
                if(response['error']['section'] === undefined){
                    $("#selectSection").removeClass('is-invalid');
                    $("#selectSection").attr('title', '');
                }
                else{
                    $("#selectSection").addClass('is-invalid');
                    $("#selectSection").attr('title', response['error']['section']);
                }
                if(response['error']['password'] === undefined){
                    $("#textPassword").removeClass('is-invalid');
                    $("#textPassword").attr('title', '');
                }
                else{
                    $("#textPassword").addClass('is-invalid');
                    $("#textPassword").attr('title', response['error']['password']);
                }
                if(response['error']['confirm_password'] === undefined){
                    $("#textConfirmPassword").removeClass('is-invalid');
                    $("#textConfirmPassword").attr('title', '');
                }
                else{
                    $("#textConfirmPassword").addClass('is-invalid');
                    $("#textConfirmPassword").attr('title', response['error']['confirm_password']);
                }
            }else{
                if(response['result'] == 1){
                    toastr.success('OTP Code has been sent to your email');
                    $('#modalAddUser').modal('show');
                    $("#textTUPTIdNumber").removeClass('is-invalid');
                    $("#textTUPTIdNumber").attr('title', '');
                    $("#textEmail").removeClass('is-invalid');
                    $("#textEmail").attr('title', '');
                    $("#textFullname").removeClass('is-invalid');
                    $("#textFullname").attr('title', '');
                    $("#textUsername").removeClass('is-invalid');
                    $("#textUsername").attr('title', '');
                    $("#textPassword").removeClass('is-invalid');
                    $("#textPassword").attr('title', '');
                    $("#textConfirmPassword").removeClass('is-invalid');
                    $("#textConfirmPassword").attr('title', '');
                }else{
                    toastr.warning('An error occured when sending email');
                }
            }
            
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Please check your internet connection');
        }
    });
}

function registerUser(){
	$.ajax({
        url: "register_user",
        method: "post",
        data: $('#formAddUser').serialize(),
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving user failed!');
                if(response['error']['tupt_id_number'] === undefined){
                    $("#textTUPTIdNumber").removeClass('is-invalid');
                    $("#textTUPTIdNumber").attr('title', '');
                }
                else{
                    $("#textTUPTIdNumber").addClass('is-invalid');
                    $("#textTUPTIdNumber").attr('title', response['error']['tupt_id_number']);
                }
                if(response['error']['email'] === undefined){
                    $("#textEmail").removeClass('is-invalid');
                    $("#textEmail").attr('title', '');
                }
                else{
                    $("#textEmail").addClass('is-invalid');
                    $("#textEmail").attr('title', response['error']['email']);
                }
                if(response['error']['fullname'] === undefined){
                    $("#textFullname").removeClass('is-invalid');
                    $("#textFullname").attr('title', '');
                }
                else{
                    $("#textFullname").addClass('is-invalid');
                    $("#textFullname").attr('title', response['error']['fullname']);
                }
                if(response['error']['username'] === undefined){
                    $("#textUsername").removeClass('is-invalid');
                    $("#textUsername").attr('title', '');
                }
                else{
                    $("#textUsername").addClass('is-invalid');
                    $("#textUsername").attr('title', response['error']['username']);
                }
                if(response['error']['password'] === undefined){
                    $("#textPassword").removeClass('is-invalid');
                    $("#textPassword").attr('title', '');
                }
                else{
                    $("#textPassword").addClass('is-invalid');
                    $("#textPassword").attr('title', response['error']['password']);
                }
                if(response['error']['confirm_password'] === undefined){
                    $("#textConfirmPassword").removeClass('is-invalid');
                    $("#textConfirmPassword").attr('title', '');
                }
                else{
                    $("#textConfirmPassword").addClass('is-invalid');
                    $("#textConfirmPassword").attr('title', response['error']['confirm_password']);
                }
            }else if(response['hasError'] == 0){
                $("#formAddUser")[0].reset();
                $('#modalAddUser').modal('hide');
                window.location = 'dashboard';
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function verifyOTP(){
	$.ajax({
        url: "verify_otp",
        method: "post",
        data: $('#formVerifyOTP').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iconVerifyOTP").addClass('spinner-border spinner-border-sm');
            $("#buttonVerifyOTP").addClass('disabled');
            $("#iconVerifyOTP").removeClass('fa fa-check');
        },
        success: function(response){
            if(response['data'].length > 0){
                toastr.success('OTP Code successfully verified');
                registerUser();
            }else{
                toastr.error('Error OTP Code');
            }
            $("#iconVerifyOTP").removeClass('spinner-border spinner-border-sm');
            $("#buttonVerifyOTP").removeClass('disabled');
            $("#iconVerifyOTP").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function signIn(){
    $.ajax({
        url: 'sign_in',
        method: 'get',
        dataType: 'json',
        data: $("#formSignIn").serialize(),
        beforeSend: function(){
            $("#buttonLoginIcon").addClass('spinner-border spinner-border-sm');
            $("#buttonLogin").addClass('disabled');
            $("#buttonLoginIcon").removeClass('fa fa-check');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Please fill required fields');
                if(response['error']['tupt_id_number'] === undefined){
                    $("#textTUPTIdNumber").removeClass('is-invalid');
                    $("#textTUPTIdNumber").attr('title', '');
                }
                else{
                    $("#textTUPTIdNumber").addClass('is-invalid');
                    $("#textTUPTIdNumber").attr('title', response['error']['tupt_id_number']);
                }

                if(response['error']['password'] === undefined){
                    $("#textPassword").removeClass('is-invalid');
                    $("#textPassword").attr('title', '');
                }
                else{
                    $("#textPassword").addClass('is-invalid');
                    $("#textPassword").attr('title', response['error']['password']);
                }
            }
            else {
                if(response['hasError'] == 1){
                    toastr.error(response['error_message']);
                }
                else if(response['inactive'] == 0){
                    toastr.error(response['error_message']);
                }
                else{
                    toastr.success('Success!');
                    setTimeout(() => {
                        window.location = "dashboard";
                    }, 600);
                }
            }
            $("#buttonLoginIcon").removeClass('spinner-border spinner-border-sm');
            $("#buttonLogin").removeClass('disabled');
            $("#buttonLoginIcon").addClass('fa fa-check');
        }
    });
}

function getUsers(selectElement){
	let result = '';
	$.ajax({
		url: 'get_users',
		method: 'get',
		dataType: 'json',
		success: function(response){
			let disabled = '';
			if(response['users'].length > 0){
				for(let index = 0; index < response['users'].length; index++){
                    result += '<option value="' + response['users'][index].id + '">' + response['users'][index].fullname + '</option>';
				}
			}
			else{
				result = '<option value="0" disabled>No User Level found</option>';
			}
			selectElement.html(result);
		},
		error: function(data, xhr, status){
			result = '<option value="0" disabled>Reload Again</option>';
			selectElement.html(result);
        }
	});
}

function getCustomerById(userId){
    $.ajax({
        url: "get_user_by_id",
        method: "get",
        data: {
            userId : userId,
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let formAddUser = $('#formAddUser');
            let userDetails = response['userDetails'];
            if(userDetails.length > 0){
                $("#textFirstname", formAddUser).val(userDetails[0].firstname);
                $("#textLastname", formAddUser).val(userDetails[0].lastname);
                $("#textMiddleInitial", formAddUser).val(userDetails[0].middle_initial);
                $("#textSuffix", formAddUser).val(userDetails[0].suffix);
                $("#textEmail", formAddUser).val(userDetails[0].email);
                $("#textContactNumber", formAddUser).val(userDetails[0].contact_number);
                $('select[name="user_level"]', formAddUser).val(userDetails[0]['user_levels'].id).trigger('change');
                $("#textUsername", formAddUser).val(userDetails[0].username);
                console.log('id ',userDetails[0].id);
                console.log('id ',userDetails[0].password);
            }
            else{
                toastr.warning('No Customer Classification records found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function editUserStatus(){
    $.ajax({
        url: "edit_user_status",
        method: "post",
        data: $('#formEditUserStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnAddUserIcon").addClass('fa fa-spinner fa-pulse');
            $("#buttonEditUserStatus").prop('disabled', 'disabled');
        },
        success: function(response){

            if(response['validationHasError'] == 1){
                toastr.error('Edit user status failed!');
            }else{
                if(response['hasError'] == 0){
                    if(response['status'] == 0){
                        toastr.success('User deactivation success!');
                        dataTablesUsers.draw();
                        dataTablesPendingUsers.draw();
                    }
                    else{
                        toastr.success('User activation success!');
                        dataTablesUsers.draw();
                        dataTablesPendingUsers.draw();
                    }
                }
                $("#modalEditUserStatus").modal('hide');
                $("#formEditUserStatus")[0].reset();
            }

            $("#iBtnAddUserIcon").removeClass('fa fa-spinner fa-pulse');
            $("#buttonEditUserStatus").removeAttr('disabled');
            $("#iBtnAddUserIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnChangeUserStatIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnChangeUserStat").removeAttr('disabled');
            $("#iBtnChangeUserStatIcon").addClass('fa fa-check');
        }
    });
}

/**
 * For Profile update
 */
function getUserBySessionId(userId){
    $.ajax({
        url: "get_user_by_session_id",
        method: "get",
        data: {
            userId : userId,
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let formEditUser = $('#formEditUser');
            let userDetails = response['userDetails'];
            if(userDetails.length > 0){
                $("#textFirstname", formEditUser).val(userDetails[0].firstname);
                $("#textLastname", formEditUser).val(userDetails[0].lastname);
                $("#textMiddleInitial", formEditUser).val(userDetails[0].middle_initial);
                $("#textEmail", formEditUser).val(userDetails[0].email);
                $("#textContactNumber", formEditUser).val(userDetails[0].contact_number);
                $('select[name="user_level"]', formEditUser).val(userDetails[0]['user_levels'].id).trigger('change');
                $("#textUsername", formEditUser).val(userDetails[0].username);
                console.log('id ',userDetails[0].id);
                console.log('id ',userDetails[0].password);
            }
            else{
                toastr.warning('No Customer Classification records found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function editUser(){
	$.ajax({
        url: "edit_user",
        method: "post",
        data: $('#formEditUser').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#btnAddUserIcon").addClass('spinner-border spinner-border-sm');
            $("#btnAddUser").addClass('disabled');
            $("#btnAddUserIcon").removeClass('fa fa-check');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving user failed!');
                if(response['error']['firstname'] === undefined){
                    $("#textFirstname").removeClass('is-invalid');
                    $("#textFirstname").attr('title', '');
                }
                else{
                    $("#textFirstname").addClass('is-invalid');
                    $("#textFirstname").attr('title', response['error']['firstname']);
                }
                if(response['error']['lastname'] === undefined){
                    $("#textLastname").removeClass('is-invalid');
                    $("#textLastname").attr('title', '');
                }
                else{
                    $("#textLastname").addClass('is-invalid');
                    $("#textLastname").attr('title', response['error']['lastname']);
                }
                if(response['error']['middle_initial'] === undefined){
                    $("#middle_initial").removeClass('is-invalid');
                    $("#middle_initial").attr('title', '');
                }
                else{
                    $("#middle_initial").addClass('is-invalid');
                    $("#middle_initial").attr('title', response['error']['middle_initial']);
                }
                if(response['error']['email'] === undefined){
                    $("#textEmail").removeClass('is-invalid');
                    $("#textEmail").attr('title', '');
                }
                else{
                    $("#textEmail").addClass('is-invalid');
                    $("#textEmail").attr('title', response['error']['email']);
                }
                if(response['error']['contact_number'] === undefined){
                    $("#textContactNumber").removeClass('is-invalid');
                    $("#textContactNumber").attr('title', '');
                }
                else{
                    $("#textContactNumber").addClass('is-invalid');
                    $("#textContactNumber").attr('title', response['error']['contact_number']);
                }
                if(response['error']['user_level'] === undefined){
                    $("#userLevel").removeClass('is-invalid');
                    $("#userLevel").attr('title', '');
                }
                else{
                    $("#userLevel").addClass('is-invalid');
                    $("#userLevel").attr('title', response['error']['user_level']);
                }
                if(response['error']['username'] === undefined){
                    $("#textUsername").removeClass('is-invalid');
                    $("#textUsername").attr('title', '');
                }
                else{
                    $("#textUsername").addClass('is-invalid');
                    $("#textUsername").attr('title', response['error']['username']);
                }
                if(response['error']['password'] === undefined){
                    $("#textPassword").removeClass('is-invalid');
                    $("#textPassword").attr('title', '');
                }
                else{
                    $("#textPassword").addClass('is-invalid');
                    $("#textPassword").attr('title', response['error']['password']);
                }
                if(response['error']['confirm_password'] === undefined){
                    $("#textConfirmPassword").removeClass('is-invalid');
                    $("#textConfirmPassword").attr('title', '');
                }
                else{
                    $("#textConfirmPassword").addClass('is-invalid');
                    $("#textConfirmPassword").attr('title', response['error']['confirm_password']);
                }

            }else if(response['hasError'] == 0){
                $("#formEditUser")[0].reset();
                $("#modalEditUser").modal('hide');
                toastr.success('Succesfully saved!');

                /**
                 * Force to logout the current session after the user updated Profile
                 */
                $('#modalLogout').modal('hide');
                $('#modalSpinner').modal('show');
                setTimeout(() => {
                    UserLogout();
                    console.log("Logging out...")
                }, 600);
            }else{
                toastr.error('Saving user failed!');
            }

            $("#btnAddUserIcon").removeClass('spinner-border spinner-border-sm');
            $("#btnAddUser").removeClass('disabled');
            $("#btnAddUserIcon").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            // toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            toastr.error('An error occured!');
        }
    });
}