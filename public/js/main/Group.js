function hashedId(value){
    // console.log('hashedId orig value ',value);
    let hashids = new Hashids("f1nd1ngn3m0", 10);
    let encodedHashedId = hashids.encode(value)
    // console.log('encodedHashedId ',encodedHashedId);
    return encodedHashedId;
}

function decodeHashedId(value){
    // console.log('hashedId orig value ',value);
    let hashids = new Hashids("f1nd1ngn3m0", 10);
    let decodedHashedId = hashids.decode(value);
    // console.log('decodedHashedId ',decodedHashedId);
    return decodedHashedId;
}

function getGroupId(callback){
    return hashedId(callback);
}

function getGroupList(){
    console.log('getGroupList()');
    $.ajax({
        url: "get_group_list",
        method: "get",
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let getGroupListArray = response['getGroupList'];
            if(getGroupListArray.length > 0){
                for (let index = 0; index < getGroupListArray.length; index++) {
                    let groupId = getGroupListArray[index].id;
                    let groupName = getGroupListArray[index].group_name;
                    let groupCode = getGroupListArray[index].group_code;
                    let groupCreatedAt = getGroupListArray[index].created_at;
                    let groupCreatedBy = getGroupListArray[index]['group_creator_info'].fullname;
                    let hashedGroupId = getGroupId(groupId);
                    let html = "";
                    html +=`<div class="col">`;
                    html +=    `<div class="card h-100 text-center">`;
                    html +=        `<div class="card-body">`;
                    html +=            `<div class="mb-5"></div>`;
                    html +=            `<span><i class="fa-solid fa-users-rectangle fa-2xl" style="font-size: 3em"></i></span>`;
                    html +=            `<h4 class="fw-bold my-3">${groupName}</h4>`;
                    html +=        `</div>`;
                    html +=        `<div class="card-footer">`;
                    html +=            `<p class="card-text"><small class="text-muted">${moment(groupCreatedAt).format("dddd, MMM Do YYYY")} at ${moment(groupCreatedAt).format("h:mm A")}</small></p>`;
                    html +=            `<footer class="blockquote-footer">Owner <strong>${groupCreatedBy}</strong></footer>`;
                    html +=            `<button type="button" class="btn btn-outline-primary buttonJoinGroup" group-id="${hashedGroupId}" data-bs-toggle="modal" data-bs-target="#modalJoinGroup">Join Group</button>`;
                    html +=        `</div>`;
                    html +=    `</div>`;
                    html +=`</div>`;
                    $('#divGroup .row').append(html);
                }
            }
            else{
                $('#noGroupList').removeClass('d-none');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function getOneLatestGroup(){
    console.log('getOneLatestGroup()');
    $.ajax({
        url: "get_one_latest_group",
        method: "get",
        dataType: "json",
        beforeSend: function(){
        },
        success: function(response){
            let getOneLatestGroupArray = response['getOneLatestGroup'];
            if(getOneLatestGroupArray.length > 0){
                for (let index = 0; index < getOneLatestGroupArray.length; index++) {
                    let groupId = getOneLatestGroupArray[index].id;
                    let groupName = getOneLatestGroupArray[index].group_name;
                    let groupCode = getOneLatestGroupArray[index].group_code;
                    let groupCreatedAt = getOneLatestGroupArray[index].created_at;
                    let groupCreatedBy = getOneLatestGroupArray[index]['group_creator_info'].fullname;
                    let hashedGroupId = getGroupId(groupId);
                    let html = "";
                    html +=`<div class="col">`;
                    html +=    `<div class="card h-100 text-center">`;
                    html +=        `<div class="card-body">`;
                    html +=            `<div class="mb-5"></div>`;
                    html +=            `<span><i class="fa-solid fa-users-rectangle fa-2xl" style="font-size: 3em"></i></span>`;
                    html +=            `<h4 class="fw-bold my-3">${groupName}</h4>`;
                    html +=        `</div>`;
                    html +=        `<div class="card-footer">`;
                    html +=            `<p class="card-text"><small class="text-muted">${moment(groupCreatedAt).format("dddd, MMM Do YYYY")} at ${moment(groupCreatedAt).format("h:mm A")}</small></p>`;
                    html +=            `<footer class="blockquote-footer">Owner <strong>${groupCreatedBy}</strong></footer>`;
                    html +=            `<button type="button" class="btn btn-outline-primary buttonJoinGroup" group-id="${hashedGroupId}" data-bs-toggle="modal" data-bs-target="#modalJoinGroup">Join Group</button>`;
                    html +=        `</div>`;
                    html +=    `</div>`;
                    html +=`</div>`;
                    $('#divGroup .row').prepend(html);
                }
                $('#noGroupList').addClass('d-none')
            }
            else{
                $('#noGroupList').removeClass('d-none');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function addGroup(){
    let groupName = $('#textAddGroupName').val();
    let qwe = hashedId(groupName);
    let formData = $('#formAddGroup').serialize()+'&hashed='+qwe;
    console.log('qwe', qwe);
	$.ajax({
        url: "add_group",
        method: "post",
        data: formData,
        dataType: "json",
        beforeSend: function(){
            $("#iconAddGroup").addClass('spinner-border spinner-border-sm');
            $("#buttonAddGroup").addClass('disabled');
            $("#iconAddGroup").removeClass('fa fa-check');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');

                if(response['error']['group_name'] === undefined){
                    $("#textAddGroupName").removeClass('is-invalid');
                    $("#textAddGroupName").attr('title', '');
                }
                else{
                    $("#textAddGroupName").addClass('is-invalid');
                    $("#textAddGroupName").attr('title', response['error']['group_name']);
                }
                
                if(response['error']['group_code'] === undefined){
                    $("#textAddGroupCode").removeClass('is-invalid');
                    $("#textAddGroupCode").attr('title', '');
                }
                else{
                    $("#textAddGroupCode").addClass('is-invalid');
                    $("#textAddGroupCode").attr('title', response['error']['group_code']);
                }
                
                if(response['error']['group_leader_name'] === undefined){
                    $(".select2-selection--multiple").attr('title', '');
                    $(".select2-selection--multiple").css({ "border": "1px solid #aaa", "borderRadius":"4px"})
                }
                else{
                    $(".select2-selection--multiple").attr('title', response['error']['group_leader_name']);
                    $(".select2-selection--multiple").css({ "border": "1px solid red", "borderRadius":"4px"})
                }
            }else{
                if(response['isGroupCodeExist'] === true){
                    $("#textAddGroupName").removeClass('is-invalid');
                    $("#textAddGroupName").attr('title', '');

                    $(".select2-selection--multiple").css({ "border": "1px solid #aaa", "borderRadius":"4px"})
                    $(".select2-selection--multiple").attr('title', '');

                    $("#textAddGroupCode").addClass('is-invalid');
                    $("#textAddGroupCode").attr('title', response['errorMessage']);
                }else{
                    if(response['isGroupLeaderExist']){
                        toastr.warning(response['errorMessage']);
                    }
                    else if(response['hasError'] == 0){
                        getOneLatestGroup()
                        $('#modalAddGroup').modal('hide');
                        toastr.success('Succesfully saved!');
                    }
                }
            }
            
            $("#iconAddGroup").removeClass('spinner-border spinner-border-sm');
            $("#buttonAddGroup").removeClass('disabled');
            $("#iconAddGroup").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function joinGroup(){
    let hashedGroupId = $("input[name='group_id'", $("#formJoinGroup")).val();
    let decodedHashedGroupId = decodeHashedId(hashedGroupId);
    let groupLeader = $('#sessionUserId').val();
    console.log('group leader ', groupLeader);
    let formData = $('#formJoinGroup').serialize();
    $.ajax({
        url: "join_group",
        method: "post",
        data: `${formData}&decoded_hashed_group_id=${decodedHashedGroupId}&group_leader=${groupLeader}`,
        dataType: "json",
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Please fill required fields');
                
                if(response['error']['group_code'] === undefined){
                    $("#textJoinGroupCode").removeClass('is-invalid');
                    $("#textJoinGroupCode").attr('title', '');
                }
                else{
                    $("#textJoinGroupCode").addClass('is-invalid');
                    $("#textJoinGroupCode").attr('title', response['error']['group_code']);
                }
            }else{
                if(response['isGroupCodeExist'] === false){
                    toastr.error(response['errorMessage']);
                }
                else{
                    if(response['isGroupLeaderExist'] === true){
                        toastr.warning(response['errorMessage']);
                    }else{
                        toastr.success(response['successMessage']);
                        setTimeout(() => {
                            window.location = "my_group";
                        }, 600);
                    }
                }
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function getMyGroup(sessionUserId){
    console.log('getMyGroup()');
    $.ajax({
        url: "get_my_group",
        method: "get",
        data: {
            session_user_id: sessionUserId,
        },
        dataType: "json",
        beforeSend: function(){

        },
        success: function(response){
            let getMyGroupArray = response['getMyGroup'];
            let getGroupLeaderMemberDetailsArray = response['getGroupLeaderMemberDetails'];
            if(getMyGroupArray != null){
                console.log('getMyGroupArray not null');
                let groupId = getMyGroupArray.id;
                let groupName = getMyGroupArray['group_info'].group_name;
                let groupCode = getMyGroupArray['group_info'].group_code;
                let groupCreatedAt = getMyGroupArray.created_at;
                let groupCreatedBy = getMyGroupArray['group_info']['group_creator_info'].fullname;
                let hashedGroupId = getGroupId(groupId);
                let html = "";
                html +=`<div class="text-center">`;
                html +=    `<h3 class="fw-bold mt-2">${groupName}</h3>`;
                html +=    `<p class="card-text"><small class="text-muted">${moment(groupCreatedAt).format("dddd, MMM Do YYYY")}</small></p>`;
                html +=    `<footer class="blockquote-footer">Owner <strong>${groupCreatedBy}</strong></footer>`;
                html +=`</div>`;
                html +=`<div class="card mx-3 text-center">`;
                html +=     `<div class="card-body">`;
                html +=         `Group Code: <span class="fw-bold">${groupCode}</span>`;
                html +=     `</div>`;
                html +=`</div>`;
                $('#divGroupDetails').append(html);
                $('#buttonLeaveGroup').removeClass('d-none');
                if(getGroupLeaderMemberDetailsArray == null){
                    console.log('getGroupLeaderMemberDetailsArray null');
                    $('#buttonAddTitle').removeClass('d-none');
                }else{
                    console.log('getGroupLeaderMemberDetailsArray not null');
                    $('#buttonAddTitle').addClass('d-none');
                }
                $('#divGroup').removeClass('d-none');
                $('#divGroupDetails').removeClass('d-none');
                $('#noGroupList').addClass('d-none');
                $('#noGroupDetails').addClass('d-none');
            }else{
                console.log('null');console.log('not null');
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function leaveGroup(){
    let sessionUserId = $('#sessionUserId').val();
    console.log('sessionUserId ', sessionUserId);
    let formData = $('#formLeaveGroup').serialize();
    $.ajax({
        url: "leave_group",
        method: "post",
        data: `${formData}&session_user_id=${sessionUserId}`,
        dataType: "json",
        success: function(response){
            if(response['groupLeaderDeleted'] === true){
                toastr.success(response['successMessage']);
                location.reload();
            }else{
                toastr.error("Can't leave meeting right now");
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        },
    });
}

function addTitle(){
    let formData = $('#formAddTitle').serialize();
	$.ajax({
        url: "add_title",
        method: "post",
        data: formData,
        dataType: "json",
        beforeSend: function(){
            $("#iconAddTitle").addClass('spinner-border spinner-border-sm');
            $("#buttonSubmitTitle").addClass('disabled');
            $("#iconAddTitle").removeClass('fa fa-check');
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!');
                if(response['error']['group_number'] === undefined){
                    $("#textAddGroupNumber").removeClass('is-invalid');
                    $("#textAddGroupNumber").attr('title', '');
                }
                else{
                    $("#textAddGroupNumber").addClass('is-invalid');
                    $("#textAddGroupNumber").attr('title', response['error']['group_number']);
                }
                if(response['error']['section'] === undefined){
                    $("#selectSection").removeClass('is-invalid');
                    $("#selectSection").attr('title', '');
                }
                else{
                    $("#selectSection").addClass('is-invalid');
                    $("#selectSection").attr('title', response['error']['section']);
                }

                if(response['error']['group_members'] === undefined){
                    $(".select2-selection--multiple").attr('title', '');
                    $(".select2-selection--multiple").css({ "border": "1px solid #C3D4DA", "borderRadius":"4px"})
                }
                else{
                    $(".select2-selection--multiple").attr('title', response['error']['group_leader_name']);
                    $(".select2-selection--multiple").css({ "border": "1px solid red", "borderRadius":"4px"})
                }

                if(response['error']['title.0'] === undefined){
                    $('input[name="title[]"]')[0].classList.remove('is-invalid');
                    $('input[name="title[]"]')[0].setAttribute('title', '');
                }
                else{
                    $('input[name="title[]"]')[0].classList.add('is-invalid');
                    $('input[name="title[]"]')[0].setAttribute('title', response['error']['title.0']);
                }

                if(response['error']['title.1'] === undefined){
                    if($('input[name="title[]"]')[1]){
                        $('input[name="title[]"]')[1].classList.remove('is-invalid');
                        $('input[name="title[]"]')[1].setAttribute('title', '');
                    }
                }
                else{
                    $('input[name="title[]"]')[1].classList.add('is-invalid');
                    $('input[name="title[]"]')[1].setAttribute('title', response['error']['title.1']);
                }

                if(response['error']['title.2'] === undefined){
                    if($('input[name="title[]"]')[2]){
                        $('input[name="title[]"]')[2].classList.remove('is-invalid');
                        $('input[name="title[]"]')[2].setAttribute('title', '');
                    }
                }
                else{
                    $('input[name="title[]"]')[2].classList.add('is-invalid');
                    $('input[name="title[]"]')[2].setAttribute('title', response['error']['title.2']);
                }
            }else {
                if(response['isSubmittedTitles'] === true){
                    toastr.warning(response['errorMessage']);
                }else if(response['hasError'] === 0){
                    toastr.success(response['successMessage']);
                    $('#formAddTitle')[0].reset();
                    $('#modalAddTitle').modal('hide');
                    dataTablesTitle.draw();
                }
            }

            $("#iconAddTitle").removeClass('spinner-border spinner-border-sm');
            $("#buttonSubmitTitle").removeClass('disabled');
            $("#iconAddTitle").addClass('fa fa-check');
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}