<form class="ajax_form j-forms call-lrgt" id="SubmitRenameForm" action="/post-create-file" method="post"  class="form-horizontal">
    @csrf
    <input hidden type="text" value="{{$path}}" id="path"  name="path">
    <input  hidden type="text" value="{{$type}}" id="type"  name="type">
    <div class="panel-body">
        <div class="input-group mar-btm">
            <input value="" id="new_name" name="new_name" type="text" placeholder="Create" class="form-control">
            <span class="input-group-btn">
                <button  id="SubmitRenamebtn" class="btn btn-mint" type="submit">Create</button>
            </span>
        </div>
    </div>
</form>

