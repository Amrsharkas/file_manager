<!-- Button trigger modal -->
<button style="display: none" type="button" class="btn btn-primary ie_open_modal" data-toggle="modal" data-target="#exampleModalCenter">
    Launch demo modal
</button>

<!-- Modal -->
<div id="modal_parent" class="file_manager_preview_modal_wrapper_style">

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qu_title">Modal title</h5>
                    <button id="custom_close_modal" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body qu_editor">
                </div>
                <input hidden id="path_modal" name="path" >
                <input hidden id="path_contents" name="contents">
                <div class="modal-footer hidden">

                    {{--                <button hidden id="close_modal" type="button" class="btn btn-secondary">Close</button>--}}
                    <button type="button" class="btn btn-primary qu_write_file">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>