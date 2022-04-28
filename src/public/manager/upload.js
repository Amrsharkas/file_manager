$(document).ready(function() {
    // initialize with defaults
    //   $("#input-id").fileinput();
    // with plugin options
    let path_to_upload
    $("#input-id").fileinput({
        uploadUrl: '/file-upload',
        uploadExtraData:  function() {
            let out ={}
            out['_token'] =$('meta[name="csrf-token"]').attr('content')
            out['path_to_upload']= $('#path_to_upload').attr('value')
            return  out
        },
        uploadAsync: false,
        enableResumableUpload: true,
        overwriteInitial: false,
        minFileCount: 1,
        showBrowse: true,
        showCaption: false,
        showUpload: false,
        showUploadStats: false,
        browseOnZoneClick: true,
        maxFileCount: 15,
        maxFileSize: 6053641, //in kb
        removeFromPreviewOnError: true,
        initialPreviewAsData: true // identify if you are sending preview data only and not the markup
    }).on("filebatchselected", function(event, files) {
        $("#input-id").fileinput("upload");
        $('.file-preview').show();
    })
        .on("filechunkbeforesend", function(event, files) {
          path_to_upload= $('#path_to_upload').attr('value')
        })

.on("filebatchuploadcomplete", function(event, files) {
    $('.file-preview').hide();
    $('.progress').hide();
    }).on('fileuploaderror', function(event, data, msg) {
        console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
    }).on("fileuploaded", function(event, previewId, index, fileId) {
    // let res= JSON.parse(response);
    // if (res.hasOwnProperty('code') && res.code==403){
    //     $('.close').click();
    //     swal({
    //         title: "Uncompleted operation",
    //         text: "you cant do this action",
    //         type: "danger",
    //         showCancelButton: false,
    //         confirmButtonClass: "btn-danger",
    //         closeOnConfirm: false
    //     });
    // }
    console.log(event, previewId, index, fileId)
    getDirectory($('#path_to_upload').attr('value'),true)});
    $('.fileinput-remove').addClass('fa fa-close');
   $('.fileinput-remove').remove();
    $('.btn.btn-primary.btn-file').hide();
    $('.file-preview').hide();
    //


    // $('#input-id').fileinput({
    //     uploadAsync: true,
    //     enableResumableUpload: true,
    //     uploadUrl: '/file-upload',
    //     uploadExtraData : {
    //         _token:  $('meta[name="csrf-token"]').attr('content'),
    //         filePath: "${decodeURIComponent(getUrlLocationParameter('path'))}/"
    //     },
    //     showCaption: true,
    //     showBrowse: true,
    //     showPreview: true,
    //     showRemove: true,
    //     showUpload: true,
    //     showUploadStats: true,
    //     showCancel: null,
    //     showPause: null,
    //     showClose: false,
    //     showUploadedThumbs: true,
    //     showConsoleLogs: true,
    //     browseOnZoneClick: false,
    //     autoReplace: false,
    //     autoOrientImage: false,
    //     autoOrientImageInitial: true,
    //     focusCaptionOnBrowse: true,
    //     focusCaptionOnClear: true,
    //     required: false,
    //     rtl: false,
    //     hideThumbnailContent: false,
    //     encodeUrl: true,
    //     generateFileId: null,
    //     previewClass: '',
    //     captionClass: '',
    //     frameClass: 'krajee-default',
    //     mainClass: 'file-caption-main',
    //
    //     theme: "krajee-explorer",
    //
    //     overwriteInitial: false,
    //     initialPreviewAsData: true,
    //     maxFileSize: 6053641, //in kb
    //     removeFromPreviewOnError: true,
    //     previewFileType: 'any',
    // });
});
