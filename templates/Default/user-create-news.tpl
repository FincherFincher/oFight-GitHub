<div class="col-md-8 col-xs-12 col-sm-12">

    <div class="unit-head">Создание статьи</div>
    <div class="block unit">
        <div class="form-group">
            <input type="text" maxlength="40" id="news_titlename" required="" placeholder="&nbsp;&nbsp;Заголовок статьи" class="form-control input-sm">
        </div>

        <div class="form-group">
            <input type="text" id="news_picture" required="" placeholder="&nbsp;&nbsp;Основная картинка&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;url" class="form-control input-sm">
        </div>


       
        <div class="unit-head-sm"><p>SEO оптимизация</p></div>
        <div class="unit-text-sm">
          Нужно найти ключевые слова через яндекс wordstat, а далее правильно составить опсание и загловок для поисковых ботов, вот тут можно ознакомиться подробнее <a href="http://shpargalkablog.ru/2012/10/optimizacija-stati-saita.html">ссылка</a>.
        </div>
        
        <div class="form-group">
            <input type="text" id="news_title" required="" placeholder="&nbsp;&nbsp;Title" class="form-control input-sm">
        </div>
        
        <div class="form-group">
            <input type="text" id="news_description" required="" placeholder="&nbsp;&nbsp;Description" class="form-control input-sm">
        </div>
        
        <div class="form-group">
            <input type="text" id="news_keywords" required="" placeholder="&nbsp;&nbsp;Keywords" class="form-control input-sm">
        </div>
        
        <div class="form-group">
            <input type="text" id="news_urlname" required="" placeholder="&nbsp;&nbsp;URL&nbsp;&nbsp;транслитом" class="form-control input-sm">
        </div>
        
        
        <div class="unit-head-sm"><p>Основная часть</p></div>
        <div class="unit-text-sm">
          Краткое описание для preview и сама статья. Просим внимательно писать тэги, указывать и составлять структуру из заголовков, а всем картинкам присаивать класс class="img-responsive news-img-center"
        </div>
        
        <textarea id="news_prevtext" placeholder="&nbsp;&nbspПредварительный текст" class="unit-textarea"></textarea>   
        <textarea id="news_maintext" placeholder="&nbsp;&nbsp;Основной текст" class="unit-textarea"></textarea>   
        

        <div class="unit-head-sm"><p>Технический блок</p></div>
        <div class="unit-text-sm">
          техническая часть, кто что , зачем и так далее.
        </div>
        
        <div class="form-group">
            <input type="text" id="news_author" required="" placeholder="&nbsp;&nbsp;Автор материала" class="form-control input-sm">
        </div>

        <div class="form-group">
          <select class="form-control" id="news_category">
            <option selected="selected" disabled="disabled">Select&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Category</option>
            <option value="Hearhstone">Hearhstone</option> 
          </select>
        </div>


        <a class="btn btn-lg btn-block btn-primary button" onclick="createNews(this);">Отправить на модерацию</a>
        <div class="dialog dialog-danger"></div>       
    </div>                             

</div> 

       
       
