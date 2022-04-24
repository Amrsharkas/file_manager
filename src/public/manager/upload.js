$(document).ready(function() {
    setLocalStorage();

    function setLocalStorage(){
        localStorage.setItem('path_to_upload',$('#path_to_upload').attr('value'))
    }
    // initialize with defaults
    //   $("#input-id").fileinput();
    // with plugin options
    let path_to_upload
    $("#input-id").fileinput({
        uploadUrl: '/file-upload',
        uploadExtraData:  function() {
            let out ={}
            out['path_to_upload']= localStorage.getItem('path_to_upload')
            return  out
        },
        uploadAsync: true,
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
          path_to_upload=  localStorage.getItem('path_to_upload')
        })

.on("filebatchuploadcomplete", function(event, files) {
    $('.file-preview').hide();
    $('.progress').hide();
    })
.on("fileuploaded", function(event, files) {
    console.log(files)
    console.log(event)
    getDirectory(localStorage.getItem('path_to_upload'))});
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
