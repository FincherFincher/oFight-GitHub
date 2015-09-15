<div class="col-xs-6 col-sm-3">
    <div class="unit-head">Загрузка файлов</div>
    <div class="block unit">
        <div class="form-group unit-fupl-v1">
          <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 100%; height: 150px;">
              <img data-src="holder.js/100%x100%" alt="...">
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
            <div>
              <span class="btn btn-primary btn-embossed btn-file">
                <span class="fileinput-new"><span class="fui-image"></span>&nbsp;&nbsp;&nbsp;Select image</span>
                <span class="fileinput-exists"><span class="fui-gear"></span>&nbsp;&nbsp;&nbsp;Change</span>
                <form id="fileinfo" enctype="multipart/form-data" method="post" name="fileinfo">
                <input type="file" name="file" required />
                </form>
              </span>
              <a href="#" class="btn btn-primary btn-embossed fileinput-exists" data-dismiss="fileinput"><span class="fui-trash"></span>  Remove</a>
            </div>
          </div>
        </div>  
        <a class="btn btn-lg btn-block btn-primary button" onclick="userUploadPicture(this);">Загрузить файл</a>
        <div class="dialog dialog-danger"></div>  
        <a class="pointer" style="display:none;" id="userUploadPictureCopyLink" name="" onclick="userUploadPictureCopyLink(this);">Скопировать ссылку</a>
    </div> 
</div>