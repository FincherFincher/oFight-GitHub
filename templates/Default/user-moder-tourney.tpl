
    <!-- typical tourney panel -->
    <div>
        <div class="unit-v1" name="{ID}">
            <span class="fa fa-list fa-fw"></span>
            <span>{NAME}</span>
            <span class="unit-btn-green pointer" name="close" onclick="PP_tourdata_open(this, 'hide');">&nbsp;&nbsp;&nbsp;Show&nbsp;&nbsp;&nbsp;</span>
        </div> 
        <div style="display:none;">
            <div>
                <div class="form-group">
                    <input type="text" value="{NAME}" maxlength="20" id="tname" required="" placeholder="&nbsp;&nbsp;Tournament name" class="form-control input-sm">
                </div>
                <div class="form-group">
                    <input type="text" value="{PRIZE}" maxlength="10" id="tprize" required="" placeholder="&nbsp;&nbsp;Tournament prize" class="form-control input-sm">
                </div>
                <div class="form-group">
                    <input type="text" value="{LOGO}" id="timg" required="" placeholder="&nbsp;&nbsp;Tournament picture&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;url" class="form-control input-sm">
                </div>
                <div class="unit-head-sm"><p>Выбор игры, мода и типа</p></div>
                <div class="unit-text-sm">
                Чем интересснее мод, тем более впечетляющим для игроков и зрителей удается и сам турнир. С подробным описанием турнирных модов и типов можно ознакомиться по <a href="#">ссылке</a>.
                </div>
                <div class="form-group">
                    <select class="form-control" id="tgame">
                    <option selected="selected" value="{GAME}">{GAME}</option> 
                    <option value="Hearthstone">Hearthstone</option> 
                    <option value="Hearthstone">Starcraft</option> 
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="tmod">
                    <option selected="selected" value="{MOD}">{MOD}</option>      
                    <option value="Spartan">Spartan</option>
                    <option value="Olympia">Olympia</option>  
                    </select>
                </div> 
                <div class="form-group">
                    <select class="form-control" id="ttype">
                    <option value="{TYPE}">{TYPE}</option> 
                    <option value="Regular">Regular</option> 
                    <option value="Random">Random</option> 
                    <option value="Random heroes" disabled>Random heroes&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Premium</option> 
                    </select>
                </div>
                <div class="unit-head-sm"><p>Дата и время проведения <font style="color: red; font-weight:normal;">[время указывается по Москве]</font></p></div>
                <div class="unit-text-sm">
                Выбирайте дату турнира взвешенно, ведь менять / переносить эвент после объявления, дело не ловкое. Дата начала турнира, - тот самый час икс, начало итоговой регистрации устанавливается за 2 часа до начала автоматически.
                </div>
                <div class="form-group" name="tdate">
                <input type="text" value="{DATE}" required="" id="datetimepicker-{ID}" placeholder="&nbsp;&nbsp;Tournament date and time" class="form-control input-sm">
                <script>
                $('#datetimepicker-{ID}').datetimepicker({dayOfWeekStart : 1, lang:'ru', disabledDates:['','',''], value:'{DATE}', format:'d.m.Y H:i', timepickerScrollbar:false}); 
                </script>  
                </div>
                <div class="unit-head-sm"><p>Администраторы и правила</p></div>
                <div class="unit-text-sm">
                Выберите турнирные правила и укажите пользователей oFight.ru, которые будут администраторами
                </div>
                <div class="form-group" id="tadmin">
                    <select class="form-control" id="trule">
                    <option selected="selected" value="{RULES}">{RULES}</option> 
                    <option value="Regular-mainBO2-finalBO3">Regular games BO2, final`s BO3</option> 
                    <option value="Random-mainBO2-finalBO3">Random games BO2, final`s BO3</option> 
                    </select>
                </div>
                <input name="tagsinput" class="tagsinput" value="{ADMIN}" />
                <div class="unit-head-sm"><p>Содержание турнирой страницы</p></div>
                <div class="unit-text-sm">
                В "Middle Block" обычно отражается информация о турнире, о призах, об именитых стримерах и прочая описательная информация. В "Right Block" выводятся данные об организаторе турнира, логотипах спонсоров, а также информация о приуроченных конкурсах. Более подробная тнформация о структуре, разметке и способов вставки ссылок и изображений по <a href="#">ссылке</a>.
                </div>
                <textarea id="tmblock" placeholder="Middle Block&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;description" class="unit-textarea">{MIDBLOCK}</textarea>
                <textarea id="trblock" placeholder="Right Block&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;sponsor" class="unit-textarea">{RIGHTBLOCK}</textarea>   
                <div id="tauthor" name="dada" stle="display:none;"></div>
                <a class="btn btn-lg btn-block btn-primary button" onclick="acceptTour(this);">Одобрить турнир</a>
                <div class="dialog dialog-danger"></div>       
            </div>  
        </div>
    </div>


