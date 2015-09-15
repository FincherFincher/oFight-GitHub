
<div>
    <div class="unit-v1" name="{ID}">
        <span class="fa fa-list fa-fw"></span>
        <span>{NAME}</span>
        <span class="{STATUSCLASS}" name="close" onclick="{STATUSCLICK}">&nbsp;&nbsp;&nbsp;{STATUS}&nbsp;&nbsp;&nbsp;</span>
        <div style="display:none;">
            <div>
                <div class="unit-head-sm"><p>Продвижение по турниру</p></div>
                <div class="unit-text-sm">Введите кто победил, кого победил и в каком раунде</div>

                <div class="form-group" >
                    <input id="winner" type="text" value="" required="" placeholder="&nbsp;&nbsp;Победитель" class="form-control input-sm">
                </div>
                <div class="form-group" >
                    <input id="loser" type="text" value="" required="" placeholder="&nbsp;&nbsp;Проигравший" class="form-control input-sm">
                </div>

                <div class="form-group" >
                    <input id="round" type="text" value="" required="" placeholder="&nbsp;&nbsp;Раунд" class="form-control input-sm">
                </div>


                <a class="btn btn-lg btn-block btn-primary button" onclick="setWinnerByAdmin(this);">Продвинуть вперед</a>
                <div class="dialog dialog-danger"></div>  
            </div>                     
            <div>
                <div class="unit-head-sm"><p>Данные участника</p></div>
                <div class="unit-text-sm">Введите логин пользователя, участника турнира</div>

                <div class="form-group" >
                    <input id="getInfoAboutUser" type="text" value="" required="" placeholder="&nbsp;&nbsp;Логин игрока" class="form-control input-sm">
                </div>

                <a class="btn btn-lg btn-block btn-primary button" onclick="getInfoAboutUser(this);">Инфо об игроке</a>
                <div class="dialog dialog-danger"></div>    

                <div id="getInfoAboutUser_data"></div>
            </div> 
            
         
            <div>
                <div class="unit-head-sm"><p>Статус в первом раунде</p></div>
                <div class="unit-text-sm">Выводятся все игроки раунда и их результаты. Пара будет убрана из резульаттов во втором или третьем раунде, если она не сформирована (один из игроков играет предыдущий раунд) </div>
            
                
                
                <div class="form-group" >
                    <input id="getRoundOneAnalytic_round" type="text" value="" required="" placeholder="&nbsp;&nbsp;Раунд проверки" class="form-control input-sm">
                </div>
                <a class="btn btn-lg btn-block btn-primary button" onclick="getRoundOneAnalytic(this);">Получить информацию</a>
                <div class="dialog dialog-danger"></div>    
                <div class="unit-head-sm" id="getRoundOneAnalytic_info"></div>
                
                <table class="table unit-table">
                <thead>
                  <tr>
                    <th>Пара</th>
                    <th>Логин</th>
                    <th>Результат</th>
                    <th>Статус</th>
                  </tr>
                </thead>
                <tbody id="getRoundOneAnalytic_data"></tbody>
                </table>

            </div>
   
        </div>
    </div>
</div>