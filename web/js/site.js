function triggerUpload($tab) { $("#"+$tab).click(); $(".error-"+$tab).html(''); }
function cancelUpload($tab) { $("#"+$tab).val(''); $("#"+$tab+"-label").html(''); $(".error-"+$tab).html(''); }
function changeName($tab) { 
    nama = $("#"+$tab).val().split('\\')[$("#"+$tab).val().split('\\').length-1];
    $("#"+$tab+"-label").html(nama);
    ext = nama.split('.')[1];
    // if(ext != 'xlsx' && ext != 'csv')
    //     $("#upload-help-"+$tab).html('File must be .xlsx or .csv');
    // else 
    //     $("#upload-help-"+$tab).html('');
}