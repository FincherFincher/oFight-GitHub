    <div>
        <div class="unit-v1" name="{ID}">
            <span class="fa fa-list fa-fw"></span>
            <span>{NAME}</span>
            <span class="unit-btn-green pointer" name="close" onclick="PP_tourdata_open(this, 'hide');">&nbsp;&nbsp;&nbsp;Show&nbsp;&nbsp;&nbsp;</span>
        </div> 
        <div style="display:none;">
                <div class="form-group">
                    <input type="text" maxlength="40" id="news_titlename" required="" value="{NAME}" placeholder="&nbsp;&nbsp;Заголовок статьи" class="form-control input-sm">
                </div>

                <div class="form-group">
                    <input type="text" id="news_picture" required="" placeholder="&nbsp;&nbsp;Основная картинка&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;url" class="form-control input-sm" value="{PIC}">
                </div>

                <div class="unit-head-sm"><p>SEO оптимизация</p></div>
                <div class="unit-text-sm">
                  Нужно найти ключевые слова через яндекс wordstat, а далее правильно составить опсание и загловок для поисковых ботов, вот тут можно ознакомиться подробнее <a href="http://shpargalkablog.ru/2012/10/optimizacija-stati-saita.html">ссылка</a>.
                </div>

                <div class="form-group">
                    <input type="text" id="news_title" required="" placeholder="&nbsp;&nbsp;Title" class="form-control input-sm" value="{TITLE}">
                </div>

                <div class="form-group">
                    <input type="text" id="news_description" required="" placeholder="&nbsp;&nbsp;Description" class="form-control input-sm" value="{DESCR}">
                </div>

                <div class="form-group">
                    <input type="text" id="news_keywords" required="" placeholder="&nbsp;&nbsp;Keywords" class="form-control input-sm" value="{KEYW}">
                </div>

                <div class="form-group">
                    <input type="text" id="news_urlname" required="" placeholder="&nbsp;&nbsp;URL&nbsp;&nbsp;транслитом" class="form-control input-sm" value="{URL}">
                </div>

                <div class="unit-head-sm"><p>Основная часть</p></div>
                <div class="unit-text-sm">
                  Краткое описание для preview и сама статья. Просим внимательно писать тэги, указывать и составлять структуру из заголовков, а всем картинкам присаивать класс class="img-responsive news-img-center"
                </div>

                <textarea id="news_prevtext" placeholder="&nbsp;&nbspПредварительный текст" class="unit-textarea">{PREV}</textarea>   
                <textarea id="news_maintext" placeholder="&nbsp;&nbsp;Основной текст" class="unit-textarea">{MAIN}</textarea>   

                <div class="unit-head-sm"><p>Технический блок</p></div>
                <div class="unit-text-sm">
                  техническая часть, кто что , зачем и так далее.
                </div>

                <div class="form-group">
                    <input type="text" id="news_author" required="" placeholder="&nbsp;&nbsp;Автор материала" class="form-control input-sm" value="{AUTHOR}">
                </div>

                <div class="form-group">
                  <select class="form-control" id="news_category">
                    <option selected="selected" disabled="disabled">Select&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Category</option>
                    <option selected value="{CATEGORY}">{CATEGORY}</option>       
                    <option value="Hearhstone">Hearhstone</option> 
                  </select>
                </div>

                <a class="btn btn-lg btn-block btn-primary button" onclick="moderateNews(this);">Запостить новость</a>
                <div class="dialog dialog-danger"></div>   
        </div>
    </div>
