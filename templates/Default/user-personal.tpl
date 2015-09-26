<style>body{background: rgba(189, 195, 199, 0.4);}</style> 
<div class="col-md-3 col-sm-4 col-xs-6">
<div class="unit-head">Персональные данные</div>
<div class="img-link widget-line">
    <a class="widget-line">
        <div>
            <div>
                <div class="unit-avatar pointer" onclick="addUseravatarPicture(this);">
                    <img id="useravatarImage" src="{AVATAR}" class="img-responsive" alt="oFight.ru">
                </div> <!-- http://www.iconarchive.com/download/i85566/graphicloads/100-flat/download-2.ico -->
            </div>
        </div>
    </a>
    <img src="/uploads/sys/profile/userProfile-bg-hs-{PROFILEIMG_1_COUNT}.jpg" class="img-responsive" alt="Аватар пользователя oFight.ru">
</div>

<div class="block unit">
    <div>
        <!-- add avatar -->
        <div class="unit-v1">
            <span class="fa fa-user fa-fw"></span>
            <span>Аватар</span>
            <span class="unit-btn-green pointer" id="addUseravatarPicture" onclick="addUseravatar(this);" name="close">&nbsp;&nbsp;&nbsp;Обновить&nbsp;&nbsp;&nbsp;</span>
            <div class="unit-v1-cancel pointer" style="display:none;" onclick="PP_attr_cancel(this, 'Обновить')"><span class="fui-cross"></span></div>
        </div>           
           
            <!-- show/hide -->
            <div id="addUseravatar" style="display:none;">
                <p>Аватар должен быть формата .jpg, разрешения 100 х 100 пикс. и не более 200кб</p>
                <div class="form-group">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn btn-primary btn-embossed btn-file">					  	
                            <span class="fileinput-new"><span class="fui-upload hide"></span>Выбрать файл</span>
                            <span class="fileinput-exists"><i class="fa fa-cog fa-spin"></i>&nbsp;&nbsp;Замена&nbsp;&nbsp;&nbsp;</span>
<form id="fileinfo" enctype="multipart/form-data" method="post" name="fileinfo">
<input type="file" name="file" required />
</form>
                        </span>
                        <span class="fileinput-filename"></span>

                    </div>
                </div>
                <div class="dialog dialog-danger"></div>
            </div>

        <!-- add new password -->                                             
        <div class="unit-v1" name="password">
            <span class="fa fa-unlock-alt fa-fw"></span>
            <span>Ваш пароль</span>
            <span class="unit-btn-green pointer" onclick="userAttr(this);" name="close">&nbsp;&nbsp;&nbsp;Обновить&nbsp;&nbsp;&nbsp;</span>
            <div class="unit-v1-cancel pointer" style="display:none;" onclick="PP_attr_cancel(this, 'Обновить')"><span class="fui-cross"></span></div>
        </div>                                                               
            <!-- show/hide -->
            <div style="display:none;">                                                                         
                <div class="form-group">
                    <input type="text" required="" placeholder="Введите новый пароль" class="form-control input-sm">
                </div>
                <div class="dialog dialog-danger"></div>                                                                                          
            </div> 
       
       
        <!-- add battle.net tag -->                                             
        <div class="unit-v1" name="bnettag">
            <span class="fa fa-pencil-square-o fa-fw"></span>
            <span>Battle.net</span>
            <span class="unit-btn-green pointer" onclick="userAttr(this);" name="close">&nbsp;&nbsp;&nbsp;Обновить&nbsp;&nbsp;&nbsp;</span>
            <div class="unit-v1-cancel pointer" style="display:none;" onclick="PP_attr_cancel(this, 'Обновить')"><span class="fui-cross"></span></div>
        </div>                                                               
            <!-- show/hide -->
            <div style="display:none;">                                                                         
                <div class="form-group">
                    <input type="text" value="{BTAG}" required="" placeholder="&nbsp;&nbsp;Введите Battle.net tag" class="form-control input-sm">
                </div>
                <div class="dialog dialog-danger"></div>                                                                                          
            </div>                                                                          

        <!-- add vk id -->                                                                                                  
        <div class="unit-v1" name="vkcom">
            <span class="fa fa-vk fa-fw"></span>
            <span>Vkontakte</span>
            <span class="unit-btn-green pointer" onclick="userAttr(this);" name="close">&nbsp;&nbsp;&nbsp;Обновить&nbsp;&nbsp;&nbsp;</span>
            <div class="unit-v1-cancel pointer" style="display:none;" onclick="PP_attr_cancel(this, 'Обновить')"><span class="fui-cross"></span></div>
        </div>                                                                                                                                            
            <!-- show/hide -->
            <div style="display:none;">                                                                         
                <div class="form-group">
                    <input type="text" value="{VKCOM}" required="" placeholder="&nbsp;&nbsp;Vk.com id / ссылка на vk.com" class="form-control input-sm">
                </div>
                <div class="dialog dialog-danger"></div>                                                                                          
            </div>                                                                                                                                  


    </div>
</div>

<div class="block unit">
    <div class="unit-v3">Hearthstone</div>
    <div class="unit-v1">
        <span class="fa fa-shield fa-fw"></span>
        <span>Ранг</span>
        <span class="unit-stat-orange">&nbsp;&nbsp;&nbsp;{HSRANK}&nbsp;&nbsp;&nbsp;</span>
    </div>
    <div class="unit-v1">
        <span class="fa fa-star fa-fw"></span>
        <span>Всего игр</span>
        <span class="unit-stat-purpl">&nbsp;&nbsp;&nbsp;{HSGAMECOUNT}&nbsp;&nbsp;&nbsp;</span>
    </div>
    <div class="unit-v1">
        <span class="fa fa-trophy fa-fw"></span>
        <span>Процент побед</span>
        <span class="unit-stat-purpl">&nbsp;&nbsp;&nbsp;{HSWINRATE}&nbsp;&nbsp;&nbsp;</span>
    </div>
</div>
</div>
