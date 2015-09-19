<div class="col-xs-6 col-sm-6">

    <div class="unit-head">Создание турнира</div>
    <div class="block unit">
        <div class="form-group">
            <input type="text" maxlength="20" id="tname" required="" placeholder="&nbsp;&nbsp;Tournament name" class="form-control input-sm">
        </div>

        <div class="form-group">
            <input type="text" maxlength="10" id="tprize" required="" placeholder="&nbsp;&nbsp;Tournament prize" class="form-control input-sm">
        </div>

        <div class="form-group">
            <input type="text" id="timg" required="" placeholder="&nbsp;&nbsp;Tournament picture&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;url" class="form-control input-sm">
        </div>

        <div class="unit-head-sm"><p>Выбор игры, мода и типа</p></div>
        <div class="unit-text-sm">
          Чем интересснее мод, тем более впечетляющим для игроков и зрителей удается и сам турнир. С подробным описанием турнирных модов и типов можно ознакомиться по <a href="#">ссылке</a>.
        </div>

        <div class="form-group">
          <select class="form-control" id="tgame">
            <option selected="selected" disabled="disabled">Select&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Game</option>
            <option value="Hearthstone">Hearthstone</option> 
            <option value="Hearthstone">Starcraft</option> 
          </select>
        </div>

        <div class="form-group">
          <select class="form-control" id="tmod">
            <option selected="selected" disabled="disabled">Select&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Mod</option>    
            <option value="Spartan">Spartan</option>
            <option value="Olympia">Olympia</option>  
          </select>
        </div> 

        <div class="form-group">
          <select class="form-control" id="ttype">
            <option selected="selected" disabled="disabled">Select&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Type</option>
            <option value="Regular">Regular</option> 
            <option value="Random">Random</option> 
          </select>
        </div>

        <div class="unit-head-sm"><p>Дата и время проведения <font style="color: red; font-weight:normal;">[время указывается по Москве]</font></p></div>
        <div class="unit-text-sm">
          Выбирайте дату турнира взвешенно, ведь менять / переносить эвент после объявления, дело не ловкое. Дата начала турнира, - тот самый час икс, начало итоговой регистрации устанавливается за 2 часа до начала автоматически.
        </div>

        <div class="form-group" name="tdate">
            <input type="text" value="" required="" id="datetimepicker" placeholder="&nbsp;&nbsp;Tournament date and time" class="form-control input-sm">
            <script>
                $('#datetimepicker').datetimepicker({dayOfWeekStart : 1, lang:'en', disabledDates:['','',''], startDate:new Date(), timepickerScrollbar:false}); 
                /* http://xdsoft.net/jqplugins/datetimepicker/ */
                $('#datetimepicker').datetimepicker({value:'',step:30});
            </script>  
        </div>

        <div class="unit-head-sm"><p>Администраторы и правила</p></div>
        <div class="unit-text-sm">
          Выберите турнирные правила и укажите пользователей oFight.ru, которые будут администраторами
        </div>
        <div class="form-group" id="tadmin">
          <select class="form-control" id="trule">
            <option selected="selected" disabled="disabled">Select&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Rules type</option>
            <option value="Regular-mainBO2-finalBO3">Regular games BO3, final`s BO5</option> 
            <!--<option value="Random-mainBO2-finalBO3">Random games BO2, final`s BO3</option>-->
          </select>
        </div>
        <input name="tagsinput" class="tagsinput" value="OMG,Rinyuaru, RenniHS, Yodes" />

        <div class="unit-head-sm"><p>Содержание турнирой страницы</p></div>
        <div class="unit-text-sm">
          В "Middle Block" обычно отражается информация о турнире, о призах, об именитых стримерах и прочая описательная информация. В "Right Block" выводятся данные об организаторе турнира, логотипах спонсоров, а также информация о приуроченных конкурсах. Более подробная тнформация о структуре, разметке и способов вставки ссылок и изображений по <a href="#">ссылке</a>.
        </div>
        <textarea id="tmblock" placeholder="Middle Block&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;description" class="unit-textarea"></textarea>
        <textarea id="trblock" placeholder="Right Block&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;sponsor" class="unit-textarea"></textarea>   

        <a class="btn btn-lg btn-block btn-primary button" onclick="createTour(this);">Создать турнир</a>
        <div class="dialog dialog-danger"></div>       
    </div>                             

</div> 

       
       
