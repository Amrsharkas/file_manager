
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <link href="{{asset('manager/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('manager/css/nifty.min.css')}}" rel="stylesheet">
    <link href="{{asset('manager/css/demo/nifty-demo-icons.min.css')}}" rel="stylesheet">
    <link href="{{asset('manager/css/demo/nifty-demo-icons.ttf')}}" rel="stylesheet">
    <link href="{{asset('manager/plugins/pace/pace.min.css')}}" rel="stylesheet">
    <link href="{{asset('manager/css/demo/nifty-demo.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <link rel="stylesheet" href="https://cdn.plyr.io/2.0.15/plyr.css">
    <link href="{{asset('manager/contents.css')}}" rel="stylesheet">
    <script src="{{asset('manager/plugins/pace/pace.min.js')}}"></script>
    <script src="{{asset('manager/js/jquery.min.js')}}"></script>
    <script src="{{asset('manager/progressbar.js')}}"></script>
    <script src="{{asset('manager/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('manager/js/nifty.min.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset('manager/file_manager.js')}}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.7/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.7/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.7/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.7/js/fileinput.min.js"></script>
    <script src="{{asset('manager/upload.js')}}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <script src="https://cdn.plyr.io/2.0.15/plyr.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.21.0/prism.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.21.0/components/prism-yaml.min.js"
        integrity="sha512-W4sEi2+rNDpN545yJfRasMUfjSy9qdc2gQaTJnpGAFowiMP90oajSg6Xubi8SdOfsUwUaR296lQ1WOj8aU9J2A=="
        crossorigin="anonymous"
    ></script>

</head>

@include('modal')
<!--Dropdowns Addons-->
<!--===================================================-->
<!--===================================================-->
<!--End Dropdowns Addons-->

<body>
{{--<div id="content-container">--}}
    <div id="page-content">

        <div class="panel">
            <div class="pad-all file-manager">
                <div class="fixed-fluid">
                    <div class="fixed-sm-200 pull-sm-left file-sidebar">
                        <div class="bord-btm pad-btm">
                            <a href="#" id="browseFile" class="btn btn-block btn-lg btn-info v-middle input-id">Upload Files</a>
                        </div>


                        <p class="pad-hor mar-top text-main text-bold text-sm text-uppercase">Folders Structure</p>
                        <div class="list-group bg-trans pad-btm bord-btm">
                            <div id="jstree">
                            </div>

                        </div>
                    </div>
                    <div class="fluid file-panel">
                        <button hidden disabled id="past_button" value="" >Paste </button>
                        <input hidden id="from_input" value="" />
                        <input  hidden id="myhome" value="{{$root}}" />
                        @include('contents')
                        <div  style="width: 1000px">
                            <input  id="input-id" name="file" type="file" multiple>
                        </div>
                    </div>
                    @include('download')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
