function hideShowDownloader(show_or_hidden,msg='',progress=false){
    if (show_or_hidden==1){
        $('#downloader-container').removeClass('hidden');
        $('#download_status').html(msg+'...')
        $('#inner_status').html(msg+' Files ...')
        if (progress!=true){
            $('#downloader').addClass('hidden');
        }
        else{
            $('#downloader').removeClass('hidden');
        }
    }
    else{
        $('#downloader-container').addClass('hidden');
        $('#download_status').html('')
        $('#inner_status').html('')
    }
}
var pusher,channel;
function initPusher() {
    Pusher.logToConsole = false;
    pusher = new Pusher($('#real_brodcast').attr('value'), {
        cluster: 'eu'
    });
    channel = pusher.subscribe($('#real_brodcast').attr('data-channel'));
    channel.bind('Ie\\FileManager\\App\\Events\\DownloadingStatusEvent', function(data) {
        hideShowDownloader(1,'Downloading & Zipping',true);
        downloadProgressBar(data);
    })
}
var bar;
function  preperePrgressBar(){
    bar = new ProgressBar.Circle(downloader, {
        color: '#aaa',
        strokeWidth: 4,
        trailWidth: 1,
        easing: 'easeInOut',
        duration: 1400,
        text: {
            autoStyleContainer: false
        },
        from: {
            color: '#aaa',
            width: 1
        },
        to: {
            color: '#333',
            width: 4
        },
        // Set default step function for all animate calls
        step: function(state, circle) {
            circle.path.setAttribute('stroke', state.color);
            circle.path.setAttribute('stroke-width', state.width);
            var value = Math.round(circle.value()*100);
            circle.setText(value);
        }
    });
    bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar.text.style.fontSize = '2rem';
}
function downloadProgressBar(msg) {
    bar.animate(msg);
}
function initInputFile(){
    let path_to_upload
    $("#input-id").fileinput({
        uploadUrl: '/file-upload',
        uploadExtraData:  function() {
            let out ={}
            out['_token'] =$('meta[name="csrf-token"]').attr('content')
            out['path_to_upload']= $('#path_to_upload').attr('value')
            return  out
        },
        uploadAsync: true,
        enableResumableUpload: true,
        overwriteInitial: true,
        minFileCount: 1,
        showBrowse: true,
        showCaption: false,
        showUpload: false,
        showUploadStats: false,
        browseOnZoneClick: true,
        maxFileCount: 15,
        maxFileSize: 6053641, //in kb
        removeFromPreviewOnError: true,
        mainClass: 'custom-file-uploader-style',
        frameClass: 'krajee-default',
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
            // getDirectory($('#path_to_upload').attr('value'),true)
            $('#input-id').fileinput('clear');
            $('#input-id').fileinput('reset');
        }).on('fileuploaderror', function(event, data, msg) {
        // // // console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
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
        // // // console.log(event, previewId, index, fileId)
        getDirectory($('#path_to_upload').attr('value'),true)
        $('.file-preview').show();
    });
    $('.fileinput-remove').addClass('fa fa-close');
    $('.fileinput-remove').remove();
    $('.btn.btn-primary.btn-file').hide();
    $('.file-preview').hide();
}

function assignUrlToNodes() {
    $($('#jstree').jstree().get_json($('#jstree'), {
        flat: true
    })).each(function(index, value) {
        var node = $("#jstree").jstree().get_node(this.id);
        // var lvl = node.parents.length;
        // var idx = index;
        // console.log('node id and url');
        $('#'+this.id).find('.jstree-anchor').attr('data-custom-url',node.data)
        // console.log(this.id);
        // console.log(node.data);
    });
}

function refreshTreeWhenAddOrRemoveDir(path) {
    // console.log('in refreshTreeWhenAddOrRemoveDir')
    // console.log(path)
    $('.jstree-anchor').each(function () {
        let nested_path=$(this).attr('data-custom-url');
        // console.log('nested_path')
        // console.log(nested_path)
        if (nested_path==path){
            // console.log('condition done')
            $(this).click();
            return;
        }
    })
}

// function syncClickedDirWithTree(path) {
//     $('.jstree-anchor').each(function () {
//         let nested_path=$(this).attr('data-custom-url');
//         if (nested_path==path ){
//             $(this).addClass('jstree-clicked')
//             $(this).click();
//             return;
//         }
//     })
// }

function buildTree() {
    let jsonData = getJsonForTree(true);
    // console.log('islamemam');
    // console.log(jsonData);
    $('#jstree')
        .jstree({
            core: {
                "check_callback": function (operation, node, node_parent, node_position, more) {
                    // if (operation=="move_node"){
                    // //  console.log(operation)
                    // //   console.log(node)
                    // // console.log(node.data)
                    // //  console.log(node_parent)
                    // //   console.log(node_position)
                    // //    console.log(more)
                    // }
                },
                data: jsonData
            },
            types: {
                "dir": {
                    "icon" : "demo-pli-folder icon-lg icon-xs"
                },
                // "dir": {
                //     "icon" : "demo-pli-folder icon-lg icon-xs"
                // },
            },
            plugins: ["search", "themes", "types","dnd"],
        }).on('ready.jstree',function (event, data) {
        assignUrlToNodes()

    }).on('open_node.jstree', function (e, data) {
            data.instance.set_icon(data.node, "demo-pli-folder icon-lg icon-xs");
            assignUrlToNodes();
        }
    ).on('close_node.jstree', function (e, data) {
        data.instance.set_icon(data.node, "demo-pli-folder icon-lg icon-xs");
    }).on('changed.jstree', function (e, data) {
        if (data.node!=undefined){
            getDirectory(data.node.data)
            $('#jstree').jstree(true).delete_node(data.node.children)
            let children=getJsonForTree();
            children.map(function (item) {
                // // console.log('is')
                // // console.log(item)
                // // console.log(data.node.id)
                $('#jstree').jstree().create_node(data.node.id, item);
                // $('#jstree').jstree().create_node(data.node, {
                //         li_attr: { "path": "islamemam" },"text": "name" },
                //     "last", function () { }, true);
            });
            if (!data.node.state.opened){
                // console.log('is1')
                $('#jstree').jstree().toggle_node(data.node)
            }
        }
        assignUrlToNodes();
    }).on('hover_node.jstree', function (e, data) {
        // // // // console.log(data.node.data)
        // // // // console.log($('#from_input').attr('value'))
        // if ($('#from_input').attr('value')!=''){
        //     moveFile('/post-move-file',{'paths':$('#from_input').attr('value') },data.node.data);
        //     getDirectory($('#path_to_upload').attr('value'))
        // }
    });
}

function refreshTree() {
    let jsonData = getJsonForTree();
    $('#jstree')
        .jstree({
            core: {
                "check_callback": function (operation, node, node_parent, node_position, more) {
                },
                data: jsonData
            },
            types: {
                "dir": {
                    "icon" : "demo-pli-folder icon-lg icon-xs"
                },
            },
            plugins: ["search", "themes", "types","dnd"],
        });
    $('#jstree').jstree(true).refresh();
}

function getJsonForTree(make_home=false) {
    let jsonData= JSON.parse($('#directoriesPerTree').attr('value'));
    let path=$('#path_to_upload').attr('value');
    jsonData=Object.values(jsonData)
    jsonData.map(function (o) {
        o.data = o.path;
        delete o.path;
        o.text = o.filename;
        delete o.filename;
        o.parent = path;
    });
    let tree;
    if (make_home==false){
        tree=jsonData
    }
    else{
        tree= [
            {
                'text' : 'Folders',
                'type' : 'dir',
                'data' : path,
                'state' : {
                    'opened' : true,
                },
                'children' : jsonData
            }
        ]
    }
    return  tree
}
function getDirectory(path,cache=true) {
    let container='.qu_file-manager-container';
    let url='/get-dir'
    let data={'dir': path ,'cache':cache }
    let last_style;
    if ($('#demo-mail-list').hasClass('file-manager-container-grid'))
    {
        last_style='file-manager-container-grid'
    }
    $('#path_to_upload').attr('value',path)
    const urlSearchParams = new URLSearchParams(window.location.search);
    const params = Object.fromEntries(urlSearchParams.entries());
    let query_params='';
    for (const property in params) {
        if (property!='dir'){  // buildin package
            query_params+=`&${property}=${params[property]}`;
        }
    }
    url=url+'?dir='+path+query_params;
    $.ajax({
        url: url,
        method: 'get',
        data: data,
        async :false,
        success: function (response) {
            if (container) {
                $(container).html('');
                $(container).html(response);
                if (last_style!=undefined){
                    $('#demo-mail-list').addClass(last_style)
                }
                // // // console.log(window.location.pathname);
                history.pushState(null, null, getURL()+'?dir='+path+query_params);
            }
            sortList() ;
            initInputFile();
            if (cache==false){
                refreshTree();
            }
        },

    });

}

function getURL() {
    return window.location.pathname ;
}

function sortList() {
    var result = $('.qu_grand_parent').sort(function (a, b) {
        var contentA = $(a).data('type');
        var contentB =$(b).data('type');
        return (contentA < contentB) ? -1 : (contentA > contentB) ? 1 : 0;
    });

    $('#demo-mail-list').html(result);
}


$(document).ready(function () {
    function getTypeOfExtension(extension) {
        var extensions =
            {
                'mp3':'audio','wav':'audio','ogg':'audio','FLAC':'audio','WMA':'audio','AAC':'audio',
                'mp4':'video','MOV':'video','WMV':'video','AVI':'video','AVCHD':'video','FLV':'video',
                'F4V':'video', 'SWF':'video' ,'MKV':'video','WEBM':'video',
                'pdf' : 'docs',
                'jpg':'img', 'jpeg'  : 'img', 'jpe'  : 'img', 'jif'  : 'img', 'jfif'  : 'img',
                'jfi':'img' ,'png'  : 'img','gif'   : 'img' ,'webp'  : 'img' ,'tiff' : 'img'
                ,'tif'  : 'img' ,'heif'  : 'img',
                'heic'  : 'img'  ,'ind'  : 'img', 'indd' : 'img' ,'indt' : 'img',
                'svg' : 'img', 'svgz'  : 'img'
            };
        return extensions[extension]
    }

    $(document).on('click','.qu_list_view',function () {
        if ($('#demo-mail-list').hasClass('file-manager-container-grid'))
        {
            $('#demo-mail-list').removeClass('file-manager-container-grid')
        }
    });

    $(document).on('click','.qu_grid_view',function () {
        if (!$('#demo-mail-list').hasClass('file-manager-container-grid'))
        {
            $('#demo-mail-list').addClass('file-manager-container-grid')
        }
    });

    // $(document).on('change','#file_upload',function () {
    // // // //     console.log("sss")
    //     $('.input-group').hide();
    //     // $('.kv-file-remove').hide();
    //     // $('.kv-file-upload').hide();
    //    $('.fileinput-upload').click();
    // });

    // function uploadFiles() {
    //     $("#file_upload").fileinput({
    //         uploadUrl: "/file-upload",
    //         enableResumableUpload: true,
    //         initialPreviewAsData: true,
    //         // allowedFileTypes: ['image'],
    //         showCancel: true,
    //         // resumableUploadOptions: {
    //         //     testUrl: "/site/test-file-chunks",
    //         //     chunkSize: 1024, // 1 MB chunk size
    //         // },
    //         maxFileCount: 5,
    //         theme: 'fa',
    //         deleteUrl: '/site/file-delete',
    //         overwriteInitial: false,
    //         uploadExtraData: function() {
    //
    //             return {
    //
    //                 _token:  $('meta[name="csrf-token"]').attr('content'),
    //
    //             };
    //
    //         },
    //         fileActionSettings: {
    //             showZoom: function(config) {
    //                 if (config.type === 'pdf' || config.type === 'image') {
    //                     return true;
    //                 }
    //                 return false;
    //             }
    //         }
    //     });
    // }
    function renameFile(path,old_name,type) {
        let url='/rename-file';
        // // // console.log(path)
        let data={'path':path ,'old_name':old_name,'type' :type }
        $.ajax({
            url: url,
            method: 'get',
            data: data,
            success: function (response) {
                $('.qu_editor').html('')
                $('.qu_editor').append(response);
                $('.ie_open_modal').click();
            },
        });
    }

    function createNew(path,type) {
        // $('#modal_parent').removeClass('hidden')
        let url='/create-new';
        let data={'path':path ,'type' :type }
        $.ajax({
            url: url,
            method: 'get',
            data: data,
            success: function (response) {
                if (type=='dir'){
                    $('#qu_title').html('Create Folder');
                }
                else if (type=='file'){
                    $('#qu_title').html('Create File');
                }
                $('.qu_editor').html('')
                $('.qu_editor').addClass('text-reader')
                $('.qu_editor').removeClass('image-reader')
                $('.qu_editor').removeClass('pdf-reader')
                $('.qu_editor').append(response);
                $('.modal-footer').addClass('hidden')
                $('.ie_open_modal').click();
                $('.file_manager_preview_modal_wrapper_style').show()
            },
        });
    }

    $(document).on('click','#SubmitRenamebtn',function (e) {
        e.preventDefault();
        if ($('#newName').val()==''){
            alert('Name Cant be Blank')
            return false;
        }
        else{
            $('#SubmitRenameForm').submit();
        }
    })

    $(document).on('click','.demo-pli-home',function () {
        getDirectory($('#myhome').val());
    })

    $(document).on('click','#browseFile',function () {
        $('#input-id').trigger('click');
    })
    let valuePerForm;
    $(document).on('input','#newName',function (e) {
        valuePerForm=$(this).val();
    });


    $(document).on('submit','#SubmitRenameForm',function (e) {
        let action=$(this).attr('action');
        if (action==='/post-create-file'){
            hideShowDownloader(1,'Creating ')
        }
        else if (action==='/post-rename-file'){
            hideShowDownloader(1,'Renaming')
        }
        e.preventDefault();
        // $('#close_modal').click();
        let data={};
        $(this).find('input').each(function(){
            let name=$(this).attr('name');
            let value=$(this).attr('value');
            if (name == 'newName'){
                value=valuePerForm;
                // // // console.log(name)
                // // // console.log(value)
            }
            data[name] =value;
        });
        // // // console.log(data)
        $.ajax({
            url: $(this).attr('action'),
            method: 'post',
            data: data,
            success: function (response) {
                let success=1
                if (response!=''){
                    let  res=JSON.parse(response);
                    if (res.hasOwnProperty('code') && res.code==403){
                        success=0;
                        // $('#close_modal').click();
                        swal({
                            title: "Uncompleted operation",
                            text: "you cant do this action",
                            type: "danger",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            closeOnConfirm: false
                        });
                    }
                }
                if (success==1){
                    let path_to_upload=$('#path_to_upload').attr('value');
                    getDirectory(path_to_upload)
                    // console.log('before refreshTreeWhenAddOrRemoveDir')
                    refreshTreeWhenAddOrRemoveDir(path_to_upload)
                    hideShowDownloader(0)
                }
            },
        });
        $('#custom_close_modal').click();
        // $('#modal_parent').addClass('hidden')
        // $('.modal-backdrop').remove();
    });


    $(document).on('click','.qu_folder',function () {
        // // // console.log("sssss")
        let path =$(this).attr('data-path')
        $('#path_to_upload').attr('value',path)
        getDirectory(path);
        // syncClickedDirWithTree(path);
    });

    $(document).on('click','.qu_rename',function () {
        let path =$(this).attr('data-path')
        let type =$(this).attr('data-type')
        let old_name =$(this).attr('data-name')
        $('#qu_title').html('Rename File');
        $('.modal-footer').addClass('hidden');
        renameFile(path,old_name,type)
    });

    function removeFiles(data) {
        hideShowDownloader(1,'Removing')
        let path_to_upload=$('#path_to_upload').attr('value');
        $.ajax({
            url: '/remove',
            method: 'get',
            data: {'paths' : data ,'main_path':path_to_upload },
            success: function (response) {
                let success=1
                if (response!=''){
                    let  res=JSON.parse(response);
                    if (res.hasOwnProperty('code') && res.code==403){
                        success=0;
                        // $('#close_modal').click();
                        swal({
                            title: "Uncompleted operation",
                            text: "you cant do this action",
                            type: "danger",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            closeOnConfirm: false
                        });
                    }
                }
                if (success==1){
                    //  hideProgressbar();
                    swal(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    getDirectory(path_to_upload);
                }
                hideShowDownloader(0)
                refreshTreeWhenAddOrRemoveDir(path_to_upload);
            },
        });
    }

    $(document).on('click','.qu_remove',function () {
        let path =$(this).attr('data-path')
        let type =$(this).attr('data-type')
        let name =$(this).attr('data-type')
        let data =[{"type": type, "path": path, "name": name }]
        if (data.length>0){
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (flag) {
                // swal(
                //     'Deleted!',
                //     'Your file has been deleted.',
                //     'success'
                // )
                if (flag){
                    removeFiles(data)
                }
            })
        }
    });

    $(document).on('click','.qu_move',function () {
        let path =$(this).attr('data-path')
        let type =$(this).attr('data-type')
        let name =$(this).attr('data-name')
        let data = [{"from_path":path,"type":type,"file_name":name,"operator":"Move"}];
        $('#from_input').attr('value',JSON.stringify(data));
        $('#past_button').attr('disabled',false);
        $('#past_button').attr('data-operation','Move');
        $('#past_button').attr('data-type',type);
        $('#past_button').attr('data-name',name);
    });
    $(document).on('click','.qu_copy',function () {
        // // // console.log("Ssss")
        let path =$(this).attr('data-path')
        let type =$(this).attr('data-type')
        let name =$(this).attr('data-name')
        let to=$('#path_to_upload').attr('value');
        let data = [{"from_path":path,"type":type,"file_name":name,"operator":"Copy"}];
        $('#from_input').attr('value',JSON.stringify(data));
        $('#past_button').attr('disabled',false);
        $('#past_button').attr('data-operation','Copy');
        $('#past_button').attr('data-type',type);
        $('#past_button').attr('data-name',name);
    });

    $(document).on('click','.qu_mapping_past_button',function () {
        // // // console.log("Sss")
        $('#past_button').click();
    });

    function showProgressbar(message) {
        $('.qu_progress_container').attr('hidden',false);
        $('.qu_progress_container').find('.progress-bar').html(message)
    }

    function hideProgressbar() {
        $('.qu_progress_container').attr('hidden',true);
    }

    $(document).on('click','.qu_check_all',function (e) {
        $('.qu_check_all').removeClass('qu_check_all_removed_one')
        let checked=$(this).is(":checked");
        $('.qu_checkbox').each(function () {
            $(this).prop('checked',checked)
        })
    })

    $(document).on('click','.qu_checkbox',function (e) {
        let checkUnselect=true;
        $('.qu_checkbox').each(function () {
            if ($(this).prop('checked')===false){
                checkUnselect=false;

            }
        })
        // // // console.log(checkUnselect)
        if (checkUnselect==true){
            $('.qu_check_all').removeClass('qu_check_all_removed_one')
            $('.qu_check_all').prop('checked',true)
        }
        else if (checkUnselect ==false ){
            $('.qu_check_all').prop('checked',true)
            $('.qu_check_all').addClass('qu_check_all_removed_one')
        }
        if ($('.qu_checkbox:checked').length==0){
            $('.qu_check_all').removeClass('qu_check_all_removed_one')
            $('.qu_check_all').prop('checked',false)
        }
    })
    // })

    $(document).on('click','#past_button',function () {
        $('#past_button').attr('disabled',true);
        let from=$('#from_input').attr('value')
        let to=$('#path_to_upload').attr('value');
        let operation =$('#past_button').attr('data-operation');
        let type=$('#past_button').attr('data-type');
        let name= $('#past_button').attr('data-name');
        let url;
        if (operation=='Copy'){
            url='/post-copy-file';
            //   showProgressbar('Copying...')
        }
        if (operation=='Move'){
            url='/post-move-file';
            //  showProgressbar('Moving...')
        }
        let data = {'paths':from };
        // // // console.log(url,data);
        moveFile(url,data,$('#path_to_upload').attr('value'),operation);
    })

    $(document).on('click','.qu_move_many',function () {
        let operation=$(this).attr('data-operation');
        let data = [];
        $('.qu_checkbox input:checked').each(function() {
            let from=$(this).closest('.qu_file_item').find('.qu_item').attr('data-path');
            let type=$(this).closest('.qu_file_item').find('.qu_item').attr('data-type');
            let name=$(this).closest('.qu_file_item').find('.qu_item').attr('data-name');
            let to=$('#path_to_upload').attr('value');
            let item ={'from_path':from ,'type':type,'file_name':name ,'operator':operation}
            data.push(item);
        })
        if (data.length>0){
            $('#from_input').attr('value',JSON.stringify(data));
            $('#past_button').attr('disabled',false);
            $('#past_button').attr('data-operation',operation);
        }
        else{
            alert('Select To '+operation)
        }
    })

    function moveFile(url,data,to_path,op) {
        if (op=='Move')
            hideShowDownloader(1,'Moving')
        else if (op=='Copy')
            hideShowDownloader(1,'Copying')
        $.ajax({
            url: url,
            method: 'post',
            data:
                { _token:  $('meta[name="csrf-token"]').attr('content'), 'data':data ,'to_path':to_path},
            success: function (response) {
                let success=1
                if (response!=''){
                    let  res=JSON.parse(response);
                    if (res.hasOwnProperty('code') && res.code==403){
                        success=0;
                        // $('#close_modal').click();
                        swal({
                            title: "Uncompleted operation",
                            text: "you cant do this action",
                            type: "danger",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            closeOnConfirm: false
                        });
                    }
                }
                if (success==1){
                    $('#past_button').attr('disabled',true);
                    $('#past_button').attr('data-operation','');
                    $('#past_button').attr('data-type','');
                    $('#past_button').attr('data-name','');
                    $('#past_button').val('');
                    getDirectory($('#path_to_upload').attr('value'))
                }
                hideShowDownloader(0)
                // hideProgressbar();
            },
        });
    }


    $(document).on('click','.demo-pli-file-add',function () {
        let path_to_upload=$('#path_to_upload').attr('value');
        createNew(path_to_upload,'file')
    });
    $(document).on('click','.demo-pli-folder-add',function () {
        let path_to_upload=$('#path_to_upload').attr('value');
        createNew(path_to_upload,'dir')
    });
    $(document).on('click','.qu_download',function () {
        let type =$(this).attr('data-type')
        let path =$(this).attr('data-path')
        let name =$(this).attr('data-name')
        hideShowDownloader(1,'Downloading');
        // // // console.log(type,path,name)
        downloadSingle(path,type,name)
    });
    $(document).on('click','.qu_breadcrumb',function () {
        // // // console.log($(this).attr('data-path'))
        getDirectory($(this).attr('data-path'))
    });

    $(document).on('click','.qu_compress_many',function () {
        let data = [];
        $('.qu_checkbox').each(function() {
            // // // console.log($)
            if ($(this).prop('checked')===true){
                let path=$(this).closest('.qu_grand_parent').attr('data-path');
                let type=$(this).closest('.qu_grand_parent').attr('data-type');
                let name=$(this).closest('.qu_grand_parent').attr('data-name');
                let item ={"type": type, "path": path, "name": name }
                data.push(item);
            }
        })
        if (data.length>0){
            downloadProgressBar(0.01);
            hideShowDownloader(1,'Download & Zipping',true);
            downloadZip(data,'many')
        }
        else{
            alert('select to Download')
        }
    });
    $(document).on('click','.qu_remove_many',function () {
        let data = [];
        $('.qu_checkbox').each(function() {
            // // // console.log($)
            if ($(this).prop('checked')===true){
                let path=$(this).closest('.qu_grand_parent').attr('data-path');
                let type=$(this).closest('.qu_grand_parent').attr('data-type');
                let name=$(this).closest('.qu_grand_parent').attr('data-name');
                let item ={"type": type, "path": path, "name": name }
                data.push(item);
            }
        })
        // // // console.log(data)
        if (data.length>0){
            // showProgressbar('Removing...')
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (flag) {
                // swal(
                //     'Deleted!',
                //     'Your file has been deleted.',
                //     'success'
                // )
                if (flag){
                    removeFiles(data)
                }
            })
        }
        else{
            alert('Select To Remove')
        }
    });
    $(document).on('click','.qu_refresh',function () {
        let path_to_upload=$('#path_to_upload').attr('value');
        getDirectory(path_to_upload,false)
    });
    $(document).on('click','.qu_compress_single',function () {
        let type =$(this).attr('data-type')
        let path =$(this).attr('data-path')
        let name =$(this).attr('data-name')
        let data= [{"type": type, "path": path, "name": name }];
        $('#downloader-container').removeClass('hidden');
        downloadProgressBar(0.01);
        showProgressbar('Zipping...')
        downloadZip(data,'dir')
    });
    function downloadZip(data,type) {
        let url='/download-single';
        $.ajax({
            url: url,
            method: 'get',
            data: {'paths':data ,'type':type},
            success: function (link) {
                //window.location.href='/get-compressed-link?uniqid='+link;
                // hideProgressbar();
                // // // // console.log(link);
                setTimeout(function () {
                    hideShowDownloader(0)
                },3000)
                // // // console.log(link);
                download('archive',link,false)
            },
        });
    }
    function downloadSingle(path,type,name) {
        // if (type=='dir'){
        //     downloadZip(data,'dir')
        // }
        let download_url ='download-single?path='+path+'&type='+type+'&name='+name;
        download(name,download_url)
    }

    function download(filename, link,new_tab=false) {
        var element = document.createElement('a');
        element.setAttribute('href', '/'+link);
        // element.setAttribute('download',filename);
        if (new_tab==true){
            element.setAttribute('target', '_blank');
        }
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
        hideShowDownloader(0);
    }

    $(document).on('click','.qu_write_file',function () {
        let contents=$('#contents').html();
        let path =$('#path_modal').val();
        // $('#close_modal').click();
        $.ajax({
            url: '/write-file',
            method: 'post',
            data: { _token:  $('meta[name="csrf-token"]').attr('content'), 'path': path , 'contents' : contents},
            success: function (response) {
                let res= JSON.parse(response);
                if (res.hasOwnProperty('code') && res.code==403){
                    // $('#close_modal').click();
                    swal({
                        title: "Uncompleted operation",
                        text: "you cant do this action",
                        type: "danger",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        closeOnConfirm: false
                    });
                }
            },

        });
        $('#custom_close_modal').click();
    })

    $(document).on('click','.qu_file',function () {
        let type = $(this).attr('data-type');
        let path = $(this).attr('data-path');
        let extension = $(this).attr('data-extension');
        let mimetype = getTypeOfExtension(extension)
        // // // console.log(mimetype)
        $('.modal-footer').addClass('hidden')
        $('.qu_editor').html('')
        if (mimetype == undefined) {
            let url = '/preview-text'
            let data = {'type': type, 'path': path, 'mimetype': mimetype}
            $.ajax({
                url: url,
                method: 'get',
                data: data,
                success: function (response) {
                    try{
                        response = JSON.parse(response);
                    }
                    catch (e) {
                        // $('#close_modal').click();
                        swal({
                            title: "Unsupported file type",
                            text: "file cannot be previewed",
                            type: "danger",
                            showCancelButton: false,
                            confirmButtonClass: "btn-danger",
                            closeOnConfirm: false
                        });
                    }
                    $('#qu_title').html('Preview File')
                    $('.qu_editor').html('')
                    $('.modal-footer').removeClass('hidden')
                    $('#path_modal').attr('value', '')
                    $('#path_contents').attr('value', '')
                    $('#path_modal').val(response.path)
                    $('.qu_editor').removeClass("image-reader")
                    $('.qu_editor').addClass("text-reader")
                    $('#path_contents').val(response.contents)
                    //$('.editor.code_editor').html(response.contents)
                    $('.qu_editor').append(
                        `
<pre class="line-numbers"   onPaste="setTimeout(function() {onPaste();}, 0)"
  id="contents"
  contenteditable>
  <code id="contents" className="language-css" >
    ${response.contents}
  </code>
  </pre>

`);
                }
            });
            $('.qu_modal_text').click();
        }
        else if (mimetype=='img'){
            let src =$(this).find('.preview_img_lazy').attr('src')
            $('#qu_title').html('Preview image')
            $('.qu_editor').removeClass("text-reader")
            $('.qu_editor').addClass("image-reader")
            $('.qu_editor').append(`<img id="editor" src="${src}"/>`);
        }
        else {
            let url = '/preview-media-url'
            let data = {'path': path}
            $.ajax({
                url: url,
                method: 'get',
                data: data,
                success: function (link) {
                    let download_url=link
                    // if (isValidHttpUrl(link)) {
                    //     download_url = link;
                    // } else {
                    //     download_url = `/preview-media?path=${path}`
                    // }
                    $('.qu_editor').html('')
                    if (mimetype == 'audio') {
                        $('#qu_title').html('Play audio')
                        $('.qu_editor').removeClass("image-reader")
                        $('.qu_editor').removeClass("pdf-reader")
                        $('.qu_editor').append(
                            `<audio id="player" controls>\n' +
                            '  <source src=${download_url} />\n' +
                            '' +
                            '  </audio>`);
                        plyr.setup("#player");
                    } else if (mimetype == 'video') {
                        $('#qu_title').html('Play video')
                        $('.qu_editor').removeClass("text-reader")
                        $('.qu_editor').removeClass("pdf-reader")
                        $('.qu_editor').addClass("image-reader")
                        $('.qu_editor').append(` <video width="100%" id="plyr-video">\n' +
                            '                        <source  src="${download_url}" >\n' +
                            '                    </video>`);
                        plyr.setup("#plyr-video");
                    } else if (mimetype == 'docs') {
                        // // // console.log(download_url);
                        $('#qu_title').html('Preview  PDF')
                        $('.qu_editor').addClass("pdf-reader")
                        $('.qu_editor').removeClass("image-reader")
                        $('.qu_editor').removeClass("text-reader")
                        $('.qu_editor').append(`<iframe width="500px"  height="400px" allowfullscreen src="${download_url}">
                    </iframe>`);
                        // plyr.setup("#plyr-video");
                    }
                }
            });
        }
        $('.ie_open_modal').click();
    });
    function onPaste() {
        const editable = document.getElementById("editable");
        const dockerCompose = editable.innerText;
        editable.innerHTML = '<code id="yaml" class="language-yaml"></code>';
        const yaml = document.getElementById("yaml");
        // // // console.log(dockerCompose, Prism.languages.yaml);
        yaml.innerHTML = Prism.highlight(
            dockerCompose,
            Prism.languages.yml,
            "yaml"
        );
    }

    function isValidHttpUrl(string) {
        let url;

        try {
            url = new URL(string);
        } catch (_) {
            return false;
        }

        return url.protocol === "http:" || url.protocol === "https:";
    }

    $(document).on('dragstart','.qu_grand_parent',function (ev) {
        let path =$(this).attr('data-path')
        let type =$(this).attr('data-type')
        let name =$(this).attr('data-name')
        let data = [{"from_path":path,"type":type,"file_name":name.trim(),"operator":"Move"}];
        $('#from_input').attr('value',JSON.stringify(data));
    })

    $(document).on('drop','.qu_grand_parent',function (ev) {
        ev.preventDefault();
        let type=$(this).attr('data-type');
        if (type=='dir' || type=='back'){
            let from=$('#from_input').attr('value')
            let data = {'paths':from };
            // let from_path=JSON.parse(from)[0].from_path;
            // //  // console.log(from_path)
            moveFile('/post-move-file',data,$(this).attr('data-path'),'Move');
        }
        else{
            alert('cant move into file')
        }
    });

});

$(document).on('click','#close_modal',function (ev) {
    $('.qu_editor ').html('')
    $(".qu_editor").modal("hide")
})

$(document).on('click','#custom_close_modal',function (ev) {
    $("#exampleModalCenter").modal("hide")
})



// initInputFile();
// buildTree()
// sortList()
// preperePrgressBar();
// initPusher();

