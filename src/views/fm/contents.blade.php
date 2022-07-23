<div class="qu_file-manager-container">
    <input hidden id="directoriesPerTree" value="{{$directoriesPerTree??''}}">
    <div class="bord-btm pad-ver">
        <ol class="breadcrumb">
            @foreach($breadcrumbs as $index=>$breadcrumb)
            <li @if($index===array_key_last($breadcrumbs))class="active" @endif><a class="qu_breadcrumb" data-path="{{$breadcrumb['path']}}" href="javascript:void(0)">{{$breadcrumb['name']}}</a>
            </li>
            @endforeach
        </ol>
    </div>
    <div class="file-toolbar bord-btm">
        <div class="btn-file-toolbar">
            <a class="btn btn-icon add-tooltip" href="#" data-original-title="Home" data-toggle="tooltip"><i class="icon-2x demo-pli-home"></i></a>
            <a class="btn btn-icon add-tooltip" href="#" data-original-title="Refresh" data-toggle="tooltip"><i class="icon-2x demo-pli-reload-3 qu_refresh"></i></a>
        </div>
        <div class="btn-file-toolbar">
            <a class="btn btn-icon add-tooltip" href="#" data-original-title="New Folder" data-toggle="tooltip"><i
                    class="icon-2x demo-pli-folder demo-pli-folder-add"></i></a>
            <a class="btn btn-icon add-tooltip" href="#" data-original-title="New File" data-toggle="tooltip"><i
                    class="icon-2x demo-pli-file-add"></i></a>
            <a class="btn btn-icon add-tooltip" href="#" data-original-title="Paste" data-toggle="tooltip"><i
                    class="icon-2x pli-books-2 qu_mapping_past_button"></i></a>
                    <a class="btn btn-icon add-tooltip" href="#" data-original-title="Delete" data-toggle="tooltip"><i
                    class="icon-2x demo-pli-recycling qu_remove_many"></i></a>
            <a class="btn btn-icon add-tooltip" href="#" data-original-title="Download" data-toggle="tooltip"><i
                    class="icon-2x demo-pli-download-from-cloud qu_compress_many"></i></a>

        </div>
        <div class="btn-file-toolbar pull-right">
            <a class="btn btn-icon add-tooltip qu_grid_view" href="#" data-original-title="Grid View" data-toggle="tooltip"><i
                    class="icon-2x pli-chess-board"></i></a>
            <a class="btn btn-icon add-tooltip qu_list_view" href="#" data-original-title="List View" data-toggle="tooltip"><i
                    class="icon-2x pli-align-justify-all"></i></a>

        </div>
    </div>
    <input id="path_to_upload" hidden name="path_to_upload" value="{{$mainPath}}">
    <ul id="demo-mail-list" class="file-list file-manager-container-grids">
        @foreach($contents as $content)
        <li  draggable="true" class="qu_grand_parent" data-path="{{$content['path']}}" data-type="{{$content['type']}}" data-name="@if($content['type']=='dir') {{$content['filename']}} @elseif($content['type']=='file'){{array_key_exists('extension',$content)?$content['filename'].".".$content['extension']:''}}@endif">
            <div class="position-relative relative-container">

                <div class="file-control qu_file_item">
                    <input id="file-list-2" class="my-checkbox @if($content['type']!='back')qu_checkbox  @elseif($content['type']=='back') qu_check_all  @endif " type="checkbox">
                    <label class="" for="file-list-2"></label>
                </div>
                {{--            <div class="file-settings">--}}
                {{--                <a href="#"><i class="pci-ver-dots"></i>--}}
                @if($content['type']!='back')
                    <div class="file-settings input-group-btn dropdown">
                        <button data-toggle="dropdown" class="dropdownToggler"
                                type="button">
                            <i class="pci-ver-dots"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" >
                            <li><a class="@if($content['type']=='dir') qu_compress_single @else  qu_download @endif"
                                   data-name="{{$content['filename']}}@if($content['type']=='file'){{array_key_exists('extension',$content)?".".$content['extension']:''}}@endif"
                                   data-path="{{$content['path']}}" data-type="{{$content['type']}}"
                                   href="javascript:void(0)">Download</a></li>
                            <li><a class="qu_rename"
                                   data-name="{{$content['filename']}}@if($content['type']=='file'){{array_key_exists('extension',$content)?".".$content['extension']:''}}@endif"
                                   data-path="{{$content['path']}}" data-type="{{$content['type']}}"
                                   href="javascript:void(0)">Rename</a></li>
                            <li><a class="qu_copy"
                                   data-name="{{$content['filename']}}@if($content['type']=='file'){{array_key_exists('extension',$content)?".".$content['extension']:''}}@endif"
                                   data-path="{{$content['path']}}" data-type="{{$content['type']}}"
                                   href="javascript:void(0)">Copy</a></li>
                            <li><a class="qu_move"
                                   data-name="{{$content['filename']}}@if($content['type']=='file'){{array_key_exists('extension',$content)?".".$content['extension']:''}}@endif"
                                   data-path="{{$content['path']}}" data-type="{{$content['type']}}"
                                   href="javascript:void(0)">Move</a></li>
                            <li><a class="qu_remove"
                                   data-name="{{$content['filename']}}@if($content['type']=='file'){{array_key_exists('extension',$content)?".".$content['extension']:''}}@endif"
                                   data-path="{{$content['path']}}" data-type="{{$content['type']}}"
                                   href="javascript:void(0)">Remove</a></li>
                        </ul>
                    </div>
                @endif
                {{--                </a>--}}
                {{--            </div>--}}
                <div class="file-attach-icon"></div>
                <a href="#" data-type="{{$content['type']}}"
                   @if($content['type']=='file') data-extension="{{$content['extension']??''}}"
                   @endif  data-path="{{$content['path']}}"
                   class="file-details @if($content['type']=='dir' || $content['type']=='back')qu_folder @elseif($content['type']=='file')qu_file @endif">
                    <div class="media-block">
                        @if(array_key_exists('extension',$content)&&in_array($content['extension'],[
'jpg', 'jpeg' , 'jpe' , 'jif' , 'jfif' ,
'jfi','img' ,'png' ,'gif'   ,'webp'  ,'tiff'
,'tif'  ,'heif' ,
'heic'   ,'ind' , 'indd' ,'indt',
'svg', 'svgz'
]))
                            <img hidden class="preview_img_lazy" style="width:570px" id="editor" @if($disk=='s3') src="https://{{$disk}}.s3.{{$region}}.amazonaws.com/{{$content['path']}}" @else src="{{$content['path']}}" @endif>
                        @endif
                        <div class="media-left"><i class="demo-pli-file @if($content['type']=='dir' || $content['type']=='back') demo-psi-folder
@elseif($content['type']=='file')

                            @if(array_key_exists('extension',$content))
                            @if(in_array($content['extension'],['mp3','wav','ogg','FLAC','WMA','AAC']))
                                demo-pli-file-music
@elseif(in_array($content['extension'],['mp4','MOV','WMV','AVI','AVCHD','FLV','F4V', 'SWF' ,'MKV','WEBM']))
                                demo-pli-video
@elseif(in_array($content['extension'],[
    'jpg', 'jpeg' , 'jpe' , 'jif' , 'jfif' ,
               'jfi','img' ,'png' ,'gif'   ,'webp'  ,'tiff'
                ,'tif'  ,'heif' ,
                'heic'   ,'ind' , 'indd' ,'indt',
                'svg', 'svgz'
]))
                                demo-pli-file-pictures
                            @elseif(in_array($content['extension'],['pdf']))
                                demo-pli-file-excel
                                             @elseif(in_array($content['extension'],['zip','tar']))
                                demo-pli-file-zip
@else
                                demo-pli-file
@endif
                            @endif
                            @endif
                        "></i>
                        </div>
                    <div class="media-body-d">
                        <p class="file-name">{{$content['filename']}}
{{--                            {{array_key_exists('extension',$content)?'.'.$content['extension']:''}}--}}
                        </p>
                        <small>{{ isset($content['timestamp']) ?'Created at  '.date(" Y-M-d h:i:s A ", $content['timestamp']):''}}</small>
                    </div>
                </div>
            </a>
        </li>
        @endforeach


        <!--File list item-->

    </ul>
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            setLocalStorage();--}}
{{--            function setLocalStorage(){--}}
{{--                localStorage.setItem('path_to_upload',$('#path_to_upload').attr('value'))--}}
{{--            }--}}
{{--            // initialize with defaults--}}
{{--            //   $("#input-id").fileinput();--}}
{{--            // with plugin options--}}
{{--            let path_to_upload--}}
{{--            $("#input-id").fileinput({--}}
{{--                uploadUrl: '/file-upload',--}}
{{--                uploadExtraData: {--}}
{{--                    'path_to_upload': localStorage.getItem('path_to_upload')--}}

{{--                },--}}
{{--                uploadAsync: true,--}}
{{--                enableResumableUpload: true,--}}
{{--                overwriteInitial: false,--}}
{{--                minFileCount: 1,--}}
{{--                showBrowse: true,--}}
{{--                showCaption: false,--}}
{{--                showUpload: false,--}}
{{--                showUploadStats: false,--}}
{{--                browseOnZoneClick: true,--}}
{{--                maxFileCount: 15,--}}
{{--                maxFileSize: 6053641, //in kb--}}
{{--                removeFromPreviewOnError: true,--}}
{{--                initialPreviewAsData: true // identify if you are sending preview data only and not the markup--}}
{{--            }).on("filebatchselected", function(event, files) {--}}
{{--                //$("#input-id").fileinput("upload");--}}
{{--                $('.file-preview').show();--}}
{{--            })--}}
{{--                .on("filechunkbeforesend", function(event, files) {--}}
{{--                    path_to_upload=  localStorage.getItem('path_to_upload')--}}
{{--                })--}}

{{--                .on("filebatchuploadcomplete", function(event, files) {--}}
{{--                    $('.file-preview').hide();--}}
{{--                    $('.progress').hide();--}}
{{--                })--}}
{{--                .on("fileuploaded", function(event, files) {--}}
{{--                    getDirectory(localStorage.getItem('path_to_upload'))});--}}
{{--            $('.fileinput-remove').addClass('fa fa-close');--}}
{{--            $('.fileinput-remove').remove();--}}
{{--            $('.btn.btn-primary.btn-file').hide();--}}
{{--            $('.file-preview').hide();--}}
{{--        });--}}

{{--    </script>--}}
</div>
