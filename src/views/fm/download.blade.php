<div id="downloader-container" hidden class="downloader-container d-flex flex-column">
    <input hidden id="real_brodcast" value="{{env('PUSHER_APP_KEY')}}" data-channel="my-channel-{{auth()->id()}}"/>
    <div class="download-header">
        <span id="download_status" class="download-stats">Downloading...</span>
        <a  href="#" data-toggle="tooltip">
{{--            <i class="pli-arrow-down-2 mr-2"></i>--}}
        </a>
    </div>
    <div class="downloader-body d-flex flex-row align-items-center justify-content-around">
        <span id="inner_status">Downloading Files ...</span>
        <div id="downloader"></div>
    </div>
</div>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
</script>
