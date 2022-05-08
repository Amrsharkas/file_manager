<form class="ajax_form j-forms call-lrgt" id="SubmitRenameForm" action="/post-rename-file" method="post"  class="form-horizontal">
    @csrf
    <input hidden  type="text" value="{{$path}}" id="path"  name="path">
    <input hidden type="text" value="{{$oldName}}" id="old_name"  name="old_name">
    <input hidden type="text" value="{{$type}}" id="type"  name="type">
    <div class="panel-body">
        <div class="input-group mar-btm">
            <input value="{{$oldName}}"  id="newName" name="newName" type="text" placeholder="Rename" class="form-control">
            <span class="input-group-btn">
                <button  class="btn btn-mint" type="submit">Rename</button>
            </span>
        </div>
    </div>
</form>
