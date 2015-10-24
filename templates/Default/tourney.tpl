<style>body{background: rgba(189, 195, 199, 0.4);}</style> 
<!-- Tournament page -->

<div class="container"> 
    <div class="row">
        <div class="col-xs-6 col-sm-4 col-md-3">
          
            <div class="unit-toptour-v2 table unit-pTour-tBtn">
               <a href="/bracket/{TOURID}" target="_blank" class="cell unit-btn-red">Сетка</a>
               <a href=""></a>
               <a href="{TOURRULES}" target="_blank" class="cell">Правила</a>
            </div>
          
           <div class="unit-head unit-head-tourney">{TOURNAME}</div>
           
           <img src="{TOURLOGO}" class="img-responsive" alt="">
           
           
            <div class="block unit" name="{TOURID}">
                <div>
                    <div class="unit-v1">
                        <span class="fa fa-calendar fa-fw"></span>
                        <span>Дата</span>
                        <span>&nbsp;&nbsp;&nbsp;{TOURDATE}&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
                <div>
                    <div class="unit-v1">
                        <span class="fa fa-clock-o fa-fw"></span>
                        <span>Начало (мск)</span>
                        <span>&nbsp;&nbsp;&nbsp;{TOURTIMESTART}&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
                <div>
                    <div class="unit-v1">
                        <span class="fa fa-clock-o fa-fw"></span>
                        <span>Регистрация (мск)</span>
                        <span>&nbsp;&nbsp;&nbsp;{TOURTIMEREG}&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
                <div>
                    <div class="unit-v1">
                        <span class="fa fa-shield fa-fw"></span>
                        <span>Мод турнира</span>
                        <span>&nbsp;&nbsp;&nbsp;{TOURMOD}&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
                
                <div class="unit-v2">{TOURMODINFO}</div>
                
                {ADMINS}
                
                <div>
                    <div class="unit-v1">
                        <span class="fa fa-diamond fa-fw"></span>
                        <span>Призовые</span>
                        <span>&nbsp;&nbsp;&nbsp;{TOURPRIZE}&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
               
                {TOURSTATUS}

                {TOURSTATUSOPTION}

                <div class="dialog dialog-danger" id="">Заполните все поля</div>
 
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="block unit hidden-xs hidden-sm">
               
                <!-- Live Stream -->
                <div id="obj-twitch-live" class="hidden-xs"></div>
               
                <div>
                    <div class="unit-v1">
                        <span class="fa fa-weixin fa-fw"></span>
                        <span>Ждем всех в нашем чате! </span>
                        <span><a href="/chat">&nbsp;&nbsp;&nbsp;Войти в чат&nbsp;&nbsp;&nbsp;</a></span>
                    </div>
                </div>
            </div>
                
            <div class="block unit news-fl tourpagestyle">
                <img src="/uploads/sys/gamePic-Hearthstone.jpg" class="img-responsive" alt="Турниры по oFight.ru">
                {TOURBLOCKMID}

                <div class="social-btn"><script type="text/javascript">document.write(VK.Share.button(false,{type: "round", text: "Я в турнире"}));</script></div>
                
                <div><p>{TOURPLAYERS}</p></div>
            </div>

            
            

        
        </div>
        
        
        <div class="col-xs-6 col-sm-3 col-md-3">
            
            <div class="unit-head">Спонсоры</div>
            <div class="block unit">
                {TOURBLOCKRIGHT}
            </div>
            
        </div>

    </div>
</div>













