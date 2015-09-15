<div class="container"> 
    <div class="row">
        <div class="col-xs-6 col-sm-3 hidden-xs"><img src="https://s-media-cache-ak0.pinimg.com/736x/e1/73/dc/e173dc015ddb6b0565c2efa996022d81.jpg" class="img-responsive" alt="Участие в старт ап проекте"></div>
        <div class="col-xs-6 col-sm-4">
            <div class="unit-head">Участие в проекте oFight</div>
            <div class="block unit">
               
                <div class="form-group">
                    <input type="text" id="realName" required="" placeholder="&nbsp;&nbsp;Ваше прижизненное имя" class="form-control input-sm">
                </div>
               
                <div class="unit-head-sm"><p>Краткая вводная</p></div>
                <div class="unit-text-sm">
                    Есть желание и горят руки? Самореализация? Есть время? Умеешь хоть что-то делать и готов брать задачу в ней разбираться, учиться, развиваться? Ты уже на правильном направлении, осталось только заполнить форму и ждать обратной связи в течении 24 часов.
                </div>
                
                <div class="form-group">
                    <input id="eMail" type="text" required="" placeholder="&nbsp;&nbsp;E-mail для ответа Вам" class="form-control input-sm">
                </div>
            
                <div class="form-group">
                    <select class="form-control" id="topic">
                        <option selected="selected" disabled="disabled">Выберите&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;направление</option>
                        <option value="Вэб программирование">Вэб программирование</option>   
                        <option value="Статьи и группа ВК">Статьи и группа ВК</option>    
                        <option value="Вэб дизайн">Вэб дизайн</option>         
                        <option value="Не вэб, но дизайн">Не вэб, но дизайн</option>       
                        <option value="Турниры, пиар, продажи">Турниры, пиар, продажи</option>       
                    </select>
                </div>
            
                <div class="unit-head-sm"><p>Дополнительная информация</p></div>
                <div class="unit-text-sm">
                    В поле ниже просим написать немного о себе, а также осветить 3 простых вопроса: зачем Вам это нужно, что Вы можете дать проекту, что Вы хотите получить от участие в <a href="http://ofight.ru/">oFight Tournaments</a>.
                </div>
                <textarea id="textInfo" placeholder="Поле для ввода текста" class="unit-textarea"></textarea>
            
                <a class="btn btn-lg btn-block btn-primary button" onclick="sendVacancy(this);">Отправить заявку</a>
                <div class="dialog dialog-danger"></div>   

            </div>  
        </div>
        
        
        
        
        <div class="col-xs-6 col-sm-3"></div>
    </div>
</div>