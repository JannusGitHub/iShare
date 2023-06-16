function addLibrary(){
    let formData = new FormData($('#formAddLibrary')[0]);
    let sessionUserId = $('#sessionUserId').val();
	$.ajax({
        url: "add_library",
        method: "post",
        processData: false,
        contentType: false,
        data: formData,
        dataType: "json",
        beforeSend: function(){
            $("#iconAddLibrary").addClass('spinner-border spinner-border-sm');
            $("#buttonAddLibrary").addClass('disabled');
            $("#iconAddLibrary").removeClass('fa fa-check');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');
                if(response['error']['title'] === undefined){
                    $("#textAddTitle").removeClass('is-invalid');
                    $("#textAddTitle").attr('title', '');
                }
                else{
                    $("#textAddTitle").addClass('is-invalid');
                    $("#textAddTitle").attr('title', response['error']['title']);
                }
                if(response['error']['author'] === undefined){
                    $("#textAddAuthor").removeClass('is-invalid');
                    $("#textAddAuthor").attr('title', '');
                }
                else{
                    $("#textAddAuthor").addClass('is-invalid');
                    $("#textAddAuthor").attr('title', response['error']['author']);
                }
                if(response['error']['file_name'] === undefined){
                    $("#fileAddFileName").removeClass('is-invalid');
                    $("#fileAddFileName").attr('title', '');
                }
                else{
                    $("#fileAddFileName").addClass('is-invalid');
                    $("#fileAddFileName").attr('title', response['error']['file_name']);
                }

            }else {
                if(response['isGroupLeader'] == false){
                    toastr.warning(response['errorMessage']);
                }else{
                    dataTablesLibrary.draw();
                    $("#formAddLibrary")[0].reset();
                    $('#modalAddLibrary').modal('hide');
                    toastr.success('Succesfully saved!');
                }
            }

            $("#iconAddLibrary").removeClass('spinner-border spinner-border-sm');
            $("#buttonAddLibrary").removeClass('disabled');
            $("#iconAddLibrary").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function approvedStatus(){
    $.ajax({
        url: "approved_status",
        method: "post",
        data: $('#formChangeStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iconChangeStatus").removeClass('fa fa-check');
            $("#iconChangeStatus").addClass('fa fa-spinner fa-pulse');
            $("#buttonChangeStatus").addClass('disabled');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Edit status failed!');
            }else{
                if(response['hasError'] == 0){
                    if(response['status'] == 1){
                        toastr.success('Successfully Approved!');
                        dataTablesLibrary.draw();
                    }
                    else if(response['status'] == 2){
                        toastr.success('Successfully Rejected!');
                        dataTablesLibrary.draw();
                    }
                }
                $("#modalChangeStatus").modal('hide');
                $("#formChangeStatus")[0].reset();
            }
            
            $("#iconChangeStatus").removeClass('fa fa-spinner fa-pulse');
            $("#buttonChangeStatus").removeAttr('disabled');
            $("#iconChangeStatus").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iconChangeStatus").removeClass('fa fa-spinner fa-pulse');
            $("#buttonChangeStatus").removeAttr('disabled');
            $("#iconChangeStatus").addClass('fa fa-check');
        }
    });
}

function approvedTitle(){
    $.ajax({
        url: "approved_title",
        method: "post",
        data: $('#formChangeStatus').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iconChangeStatus").removeClass('fa fa-check');
            $("#iconChangeStatus").addClass('fa fa-spinner fa-pulse');
            $("#buttonChangeStatus").addClass('disabled');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Edit status failed!');
            }else{
                if(response['hasError'] == 0){
                    if(response['status'] == 1){
                        toastr.success('Successfully Approved!');
                        dataTablesTitle.draw();
                    }
                }
                $("#modalChangeStatus").modal('hide');
                $("#formChangeStatus")[0].reset();
            }
            
            $("#iconChangeStatus").removeClass('fa fa-spinner fa-pulse');
            $("#buttonChangeStatus").removeAttr('disabled');
            $("#iconChangeStatus").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iconChangeStatus").removeClass('fa fa-spinner fa-pulse');
            $("#buttonChangeStatus").removeAttr('disabled');
            $("#iconChangeStatus").addClass('fa fa-check');
        }
    });
}

function getLibraryById(libraryId){
    $.ajax({
        url: "get_library_by_id",
        method: "get",
        data: {
            libraryId : libraryId,
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let formAddLibrary = $('#formAddLibrary');
            let libraryDetails = response['libraryDetails'];
            if(libraryDetails.length > 0){
                $("#textAddTitle").val(libraryDetails[0].title);
                $("#textAddDetails").val(libraryDetails[0].details);
                $("#textAddImage").val(libraryDetails[0].image);

                /**
                 * For disabling past dates to be select
                */
                let dateNow = new Date(libraryDetails[0].date);
                console.log('dateNow ', dateNow);

                let today = new Date().getTimezoneOffset() * 60000; // offset in milliseconds
                console.log('today with getTimezoneOffset()',today);
                
                let localISOTime = (new Date(dateNow - today)).toISOString();
                console.log('localISOTime ',localISOTime);

                let fullLocalISOTime = localISOTime.slice(0, localISOTime.lastIndexOf(":")); // or .substring(0, 16)
                console.log('localISOTime ',fullLocalISOTime);
                
                $("#textAddDate").prop('min',fullLocalISOTime);
                $("#textAddDate").val(libraryDetails[0].date);
                

                if(libraryDetails[0].image != null){
                    $('#fileAddImage').addClass('d-none');
                    $('#textAddImage').removeClass('d-none');
                    $('#checkboxDivision').removeClass('d-none');
                }else{
                    $('#fileAddImage').removeClass('d-none');
                    $('#textAddImage').addClass('d-none');
                    $('#checkboxDivision').addClass('d-none');
                }

                $('#checkboxImage').on('click', function(){
                    if($('#checkboxImage').is(':checked')){
                        console.log('checked');
                        $('#fileAddImage').removeClass('d-none');
                        $('#textAddImage').addClass('d-none');
                    }else{
                        console.log('not checked');
                        $('#fileAddImage').addClass('d-none');
                        $('#textAddImage').removeClass('d-none');
                    }
                });
            }
            else{
                toastr.warning('No Library records found!');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}