
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    @include('fm.css')--}}
{{--    @include('fm.scripts')--}}

</head>

{{--@include('fm.modal')--}}

<body>
{{--<div id="content-container">--}}
    <div id="page-content p-0">
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
                        @include('fm.contents')
                        <div>
                            <input  id="input-id" name="file" type="file" multiple>
                        </div>
                    </div>
                    @include('fm.download')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
