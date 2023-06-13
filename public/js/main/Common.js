function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function resetAddGroupFormValues() {
    // Reset input values
    $("#formAddGroup")[0].reset();
    
    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');

    $('div').find('select').removeClass('is-invalid');
    $("div").find('select').attr('title', '');

    $(".select2-selection--multiple").attr('title', '');
    $(".select2-selection--multiple").css({ "border": "1px solid #aaa", "borderRadius":"4px"})

    $('div').find('textarea').removeClass('is-invalid');
    $("div").find('textarea').attr('title', '');

    $('select[name="group_leaders[]"]').val(null).trigger('change');
}

$("#modalAddGroup").on('hidden.bs.modal', function () {
    console.log('resetAnnouncementFormValues is closed');
    resetAddGroupFormValues();
});

function resetAddLibraryFormValues() {
    // Reset input values
    $("#formAddLibrary")[0].reset();
    
    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');

    $('div').find('select').removeClass('is-invalid');
    $("div").find('select').attr('title', '');

    $('div').find('textarea').removeClass('is-invalid');
    $("div").find('textarea').attr('title', '');

    $('select[name="group_leaders[]"]').val(null).trigger('change');
}

$("#modalAddLibrary").on('hidden.bs.modal', function () {
    console.log('resetAddLibraryFormValues is closed');
    resetAddLibraryFormValues();
});