<div class="container">
    <div class="row">

        <div class="col-xs-12 col-sm-8 col-md-4 block unit">
            <div class="unit-head">Создание турниров на oFight</div>
           
            <div class="unit-card">
                
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <img class="img-responsive" src="/uploads/sys/ico_gear.png" alt="">
                    </div>
                    <div class="unit-card col-xs-10 col-sm-10 col-md-10">
                        Вы можете создать свой турнир на площадке oFight, участие в котором будет доступно всем желающим.
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="col-xs-2 col-sm-2 col-md-2">
                        <img class="img-responsive" src="/uploads/sys/ico_note.png" alt="">
                    </div>
                    <div class="unit-card col-xs-10 col-sm-10 col-md-10">
                        Заполните форму, постарайтесь максимально подробно написать и изложить все аспекты: что Вы хотите от портала, какие турниры, какие призовые и т.д.
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="col-xs-2 col-sm-2 col-md-2 clearfix">
                        <img class="img-responsive" src="/uploads/sys/ico_mail.png" alt="">
                    </div>
                    <div class="unit-card col-xs-10 col-sm-10 col-md-10">
                        Ну вот почти и все, останется только отправить форму и ждать 24 часа обратной связи от администратора <a href="http://ofight.ru/">oFight Tournaments</a>.                
                    </div>
                </div>
                
            </div>

            <div class="form-group">
                <input type="text" id="realName" required="" placeholder="&nbsp;&nbsp;Ваше прижизненное имя" class="form-control input-sm">
            </div>
            
            <div class="form-group">
                <input id="eMail" type="text" required="" placeholder="&nbsp;&nbsp;E-mail для ответа Вам" class="form-control input-sm">
            </div>

            <textarea id="textInfo" placeholder="Поле для ввода текста" class="unit-textarea"></textarea>

            <a class="btn btn-lg btn-block btn-primary button" onclick="sendTourCreateFrom(this);">Отправить заявку</a>
            <div class="dialog dialog-danger"></div>   

        </div>  

    </div>
</div>

