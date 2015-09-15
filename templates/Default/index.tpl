<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{TITLE}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{THEME}/ckeditor/ckeditor.js" type="application/javascript"></script>
    {HEAD}  
</head>
<body>



    
<!-- !BLOCK Tourney Menu -->
<div class="header-top-tourney">
    <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-5 col-xs-6 tourney-block-head">
            <div class="block">
               <!--
                <div class="table tourney-div" onclick="window.open('/tourney/1' ,'_self');">
                   <div class="cell tstatus-live"><img src="/uploads/sys/up-1.jpg" class="img-responsive" alt="Hearthstone турнир"></div>
                   <div class="cell pointer">
                        <span>UPgrade.ru</span>
                        <span>Дата: 29 Aug, Призовые: от спонсора</span>
                   </div>
                   <div class="cell">
                       <img src="/uploads/icon-hearthstone.png" class="img-responsive" alt="Hearthstone турнир">
                   </div>
                </div>   
                --> 
                
                {TOPTOURSPECIAL}
                
                <div class="table tourney-div" onclick="window.open('/tour-create' ,'_self');">
                    <div class="cell tstatus-new">NEW</div>
                   <div class="cell pointer">
                        <span>Создай свой турнир</span>
                        <span>Пользовательские турниры</span>
                   </div>
                   <div class="cell">
                       <img src="/uploads/icon-hearthstone.png" class="img-responsive" alt="Hearthstone турнир">
                   </div>
                </div>
                  
                <br> 
                      
                {TOPTOUR}
                    
                 
                       
                       
            <!--<a class="tourney-bottom-header" href="">Создать свой турнир</a>-->               
            </div>
          </div>
         <div class="col-xs-12 col-sm-12 col-md-4">&nbsp;</div>

          <div class="col-xs-12 col-sm-12 col-md-4 hidden-sm hidden-xs">
<!--
                 <div class="block">

                    <div class="table tourney-div" onclick="window.open('/tour-create' ,'_self');">
                        <div class="cell tstatus-new">NEW</div>
                        <div class="cell pointer">
                        <span>Создай свой турнир</span>
                        <span>Пользовательские турниры</span>
                        </div>
                    </div>

                  </div>-->
          </div>
        </div>
    </div>
</div>


<nav class="navbar navbar-default navbar-main-menu" role="navigation">
		<div class="container"><!-- Wrap navbar in a responsive container -->
			<div class="navbar-header"><!-- Brand and toggle get grouped for better mobile display -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">oFight</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse"><!-- Collect the nav links and other content for toggling -->
				<ul class="nav navbar-nav" id="mainNav"><!-- Align to the left nav links, forms and other content -->
					<li name="chat"><a href="/chat">Чат</a></li>
					<li><a href="/vacancy">Вакансии<!--<span class="navbar-new nav-menu-status">N!</span>--></a></li>
					<li><a href="/page-all-tournaments">Турниры</a></li>
					<li><a href="/page-ranking">Рейтинг</a></li>
					<li><a href="/upcup">Серия UPCUP<span class="navbar-new navbar-new-custom">&nbsp;new&nbsp;</span></a></li>
					
					<!--
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
							<li><a href="#">One more separated link</a></li>
							<li class="divider"></li>
							<li role="presentation" class="dropdown-header">Dropdown header</li>
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li class="divider"></li>
							<li><a href="#">Regular link</a></li>
							<li class="disabled"><a href="#">Disabled link</a></li>
							<li class="dropdown-submenu"><a href="#">Options <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
								</ul>
							</li>
						</ul>
					</li>
				    -->
					
				</ul>
				<ul class="nav navbar-nav navbar-right nav-block-right-enter"><!-- Align to the right nav links, forms and other content -->
					{login}
				</ul>
			</div>
		</div>
	</nav>

   

    
    
    <!-- Modal Login -->
    <div class="modal fade block-modal" id="myModal_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
                <img src="/uploads/reg-2.jpeg" class="img-responsive" alt="Авторизация на сайте oFight.ru">
               
                <div class="unit-head">Войти в систему</div>
                <div class="reg-rules">Нажав кнопку "Войти", вы подтверждаете, что ознакомлены с <a href="">правилами системы oFight</a></div>
                <div class="block unit"> 
                    <div>
                        <div class="form-group">
                            <input autocomplete="on" type="text" id="pswreslogin" required placeholder="Login  |  latin letters and numeric" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <input autocomplete="on" type="password" id="pswrespsw" maxlength="12" placeholder="Password" class="form-control input-sm" >
                        </div>                        
                        <a class="btn btn-lg btn-block btn-primary button" onclick="logWebsite(this);">Войти</a>
                        <div class="dialog dialog-danger"></div>
                        
                        <a class="unit-link pointer" onclick="pswresWebsite_op(this);">Забыли логин или пароль?</a>
                    </div>
                </div>
                
                <div style="display:none;">
                    <div class="unit-head">Восстановить пароль</div>
                    <div class="reg-rules">Пароль будет изменен и направлен вам на e-mail</div>
                    <div class="block unit"> 
                        <div>
                            <div class="form-group">
                                <input type="email" id="pswresmail" placeholder="E-mail" class="form-control input-sm" required>
                            </div>

                            <a class="btn btn-lg btn-block btn-primary button" onclick="pswresWebsite(this);">Восстановить</a>
                            <div class="dialog dialog-danger"></div>
                        </div>
                    </div>  
                </div>
        	</div>
        </div>  
    </div>
    
    <!-- Modal Registration -->
    <div class="modal fade block-modal" id="myModal_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        	<div class="modal-content">
        	    <img src="/uploads/reg-1.jpeg" class="img-responsive" alt="Регистрация на сайте oFight.ru">
                <div class="unit-head">Регистрация в системе</div>
                <div class="reg-rules">Нажав кнопку "Регистрация", вы подтверждаете, что ознакомлены с <a href="">правилами системы oFight</a></div>
                <div class="block unit"> 
                    <div>
                        <div class="form-group">
                            <input type="text" maxlength="12" id="reglogin" required placeholder="Login  |  latin letters and numeric" class="form-control input-sm" onkeyup="validator_lat(this)">
                        </div>
                        <div class="form-group">
                            <input type="email" id="regmail" placeholder="E-mail" class="form-control input-sm" required>
                        </div>
                        <div class="form-group">
                            <input type="password" id="regpsw" maxlength="12" placeholder="Password" class="form-control input-sm" onkeyup="validator_lat(this)">
                        </div>
                        
                        <!-- news checkbox -->
                        <label class="checkbox" for="rsubsc">
                            <span class="icons">
                                <span class="first-icon fui-checkbox-unchecked"></span>
                                <span class="second-icon fui-checkbox-checked"></span>
                            </span>
                            <input type="checkbox" id="regsubsc" data-toggle="checkbox" checked>
                            Уведомлять о турнирах по почте
                        </label>
                        
                        <a class="btn btn-lg btn-block btn-primary button" onclick="regWebsite(this);">Регистрация</a>
                        <div class="dialog dialog-danger"></div>
                    </div>
                </div>
        	</div>
        </div>  
    </div>
    


<!-- Tournament -->
<div class="tournament-frame">
    <div class="container"> 
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="block unit unit-toptour">
                            <div>
                                <div>
                                    <a class="unit-toptour-v1">
                                        <div class="cell tstatus-live">LIVE!</div>
                                        <div id="tBlock-data-name"></div>
                                    </a>

                                    <div class="unit-toptour-v2 table">
                                       <a href="" target="_blank" class="cell" id="tBlock-data-bracket">Сетка</a>
                                       <a href=""></a>
                                       <a href="" target="_blank" class="cell" id="tBlock-data-rule">Правила</a>
                                    </div>
                                    
                                    <div class="unit-toptour-v3 table">
                                      <div class="cell" id="tBlock-data-round"></div>
                                    </div>
                                    
                                    <div class="system-msg-yellow table">
                                      <div class="cell" id="tBlock-data-round-type"></div>
                                    </div>
                                    
                                    <p id="tBlock-data-user-heroes"></p>
                                    <p id="tBlock-data-status"></p>

                                    <div onclick="accDuel(this);" href="#fakelink" class="btn btn-lg btn-block btn-primary button unit-btn-red unit-toptour-v4" id="tBlock-data-confirm">
                                        Подтвердить участие&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;&nbsp;&nbsp;<font id="tmain-timer">546</font>
                                    </div>
                                </div>
                            </div>
                    </div>
       
                    <div id="uTour-2">
                            <div class="obj-uLogo">
                                <img id="tBlock-data-en-avatar" src="" class="img-circle">  
                            </div>
                            <a href="#" class="obj-uName" id="tBlock-data-en-name"></a>
                    </div>


                    <div class="unit-toptour-v5" id="uTour-3">
                            <p id="tBlock-data-en-btag"></p>
                            <p id="tBlock-data-en-vk"></p>
                            <p id="tBlock-data-en-race"></p>
                            <hr>

                            <div id="uTour-4">
                                <div onclick="tourbtn();" href="#fakelink" class="btn btn-lg btn-block btn-primary button">Ввести результат игр</div>
                            </div>


                            <div id="uTour-5">
                                <div onclick="tourbtnrezMy();" href="#fakelink" class="btn btn-lg btn-block btn-primary button trez-rez" name="Win">Победил</div>
                                <div onclick="tourbtnrezEn();" class="btn btn-lg btn-block btn-primary button unit-btn-red" name="Defeat">Проиграл</div>
                            </div>

                            <div id="uTour-6">
                                <p>Укажите итоговый счет:</p>
                                <div class="input-group trez-rezn">
                                    <span class="input-group-btn"><button class="btn btn-default" type="button">Вы</button></span>
                                    <input type="text" maxlength="1" value="2" class="form-control" onkeyup="validator_num(this)" id="uTour-6-My">
                                </div>
                                <div class="input-group trez-rezn">
                                    <span class="input-group-btn"><button class="btn btn-default" type="button">Противник</button></span>
                                    <input type="text" maxlength="1" value="0" class="form-control" onkeyup="validator_num(this)" id="uTour-6-En">
                                </div>  
                                <div onclick="tourbtnscore(this);" class="btn btn-lg btn-block btn-primary button">Подтвердить счет</div>
                                <p onclick="tourbtncancel();" id="trez-cl">Отменить ввод</p> 
                            </div> 

                            <div id="uTour-7"></div>
                    </div>


               
               

          </div>
          <div class="col-xs-6 col-sm-6 col-md-4">

            <div class="system-msg-red table tBlock-data-bold">
              <div class="cell">Частые вопросы</div>
            </div>
            <div class="system-msg-white table">
              <div class="cell" id="tBlock-data-faq"></div>
            </div>
             
              
          </div>
          <div class="col-xs-6 col-sm-6 col-md-2">&nbsp;</div>
          <div class="col-xs-6 col-sm-6 col-md-3 hidden-xs hide" style="displey: none;">
              <div class="block unit" id="uTour-9"></div>
          </div>

        </div>
    </div> 
</div>    



                            



{CONTENT}
     
<!-- !BLOCK Footer -->
<div class="bottom-menu bottom-menu-inverse footerfix">
      <div class="container">
        <div class="row">
         <!--
          <div class="col-md-2 navbar-brand">
            <a href="#fakelink" class="fui-flat"></a>
          </div>

          <div class="col-md-8">
            <ul class="bottom-links">
              <li><a href="#fakelink">About Us</a></li>
              <li><a href="#fakelink">Store</a></li>
              <li class="active"><a href="#fakelink">Jobs</a></li>
              <li><a href="#fakelink">Privacy</a></li>
              <li><a href="#fakelink">Terms</a></li>
              <li><a href="#fakelink">Follow Us</a></li>
              <li><a href="#fakelink">Support</a></li>
              <li><a href="#fakelink">Links</a></li>
            </ul>
          </div>

          <div class="col-md-2">
            <ul class="bottom-icons">
              <li><a href="#fakelink" class="fui-pinterest"></a></li>
              <li><a href="#fakelink" class="fui-facebook"></a></li>
              <li><a href="#fakelink" class="fui-twitter"></a></li>
            </ul>
          </div>
          -->
        </div>
      </div>
    </div>
    <!-- Load JS here for greater good =============================-->
    

    <script src="{THEME}/js/underscore.js"></script>
    <script src="{THEME}/js/backbone-min.js"></script> 
    
    <script defer src="{THEME}/js/main.js"></script>
    <script src="{THEME}/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="{THEME}/js/jquery.ui.touch-punch.min.js"></script>
    <script src="{THEME}/js/bootstrap.min.js"></script>
    <script src="{THEME}/js/bootstrap-select.js"></script>
    <script src="{THEME}/js/bootstrap-switch.js"></script>
    <script src="{THEME}/js/flatui-checkbox.js"></script>
    <script src="{THEME}/js/flatui-radio.js"></script>
    <script src="{THEME}/js/holder.js"></script>
    <script src="{THEME}/js/flatui-fileinput.js"></script>
    <script src="{THEME}/js/jquery.tagsinput.js"></script>
    <script src="{THEME}/js/jquery.placeholder.js"></script>
    <script src="{THEME}/js/typeahead.js"></script>
    <script src="{THEME}/js/application.js"></script>


    <!-- Datepicker -->

  </body>
</html>