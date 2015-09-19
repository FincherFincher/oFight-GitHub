 <div class="container">
    <div class="row">
        <div class="col-xs-6 col-md-4 hidden-xs hidden-sm">
           
            <!-- Streamers -->
            <div id="obj-twitch">
                <div class="title-header" id="stream-block-head"><h5>Стример's</h5><hr></div>
                <div class="block">
                    <div class="stream-block" id="stream-block-main"></div>    
                </div>
            </div>
            <!-- Short news -->
            <div class="title-header"><h5>Новости</h5><hr></div>
            {SHORTNEWSPREVIEWBOX}


        </div>
        <div class="col-xs-6 col-md-5">
           
            <!-- Live Stream -->
            <div id="obj-twitch-live" class="hidden-xs"></div>
            
            <!-- Chat message -->
            <div class="title-header"><h5>Чат</h5><hr></div>
            <div class="block chat-box">
                <div class="chat-box-main" id="chat-message"  onscroll="chatScroll()">
                   <!-- <table>
                        <tr>
                            <td><img src="http://th06.deviantart.net/fs71/200H/f/2013/266/1/9/portrait_01_by_absinthe_girl-d6ni5y6.jpg" alt="Правила игрового портала" class="img-circle"></td>
                            <td>
                                <span class="user-login">От проекта</span>
                                <p>Настоятельно просим ознакомиться с <a href="">правилами</a> поведения на сайте.</p>
                            </td>
                        </tr>
                    </table> -->
                    <table id="chat-box-msg-fromproject">
                        <tr>
                            <td><img src="/uploads/sys/avatar_system.jpg" alt="Набор в проект игрового портала" class="img-circle"></td>
                            <td>
                                <span class="user-login">Сообщение администрации</span>
                                <p>Проводим набор в команду сайта <a href="/vacancy">в специальном разделе</a></p>
                            </td>
                        </tr>
                    </table>
                   
                   
                    
                    <!--<div class="pointer" id="chat-box-users-newmsg" onclick="chatScrollShow();">Перейти к последнему сообщению</div>-->
                </div>
                <div class="chat-block-message-input">
                    <div><input type="text" class="form-control input-sm" id="message" placeholder="Сообщение ..." onkeyup="inputValTags(this)"></div>
                    <div id="sendmsg"><div><span class="glyphicon glyphicon-send"></span></div></div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-3 hidden-xs hidden-sm">
            <!-- Chat users -->
            <div class="title-header" id="chat-ucount"><h5></h5><hr></div>
            <div class="block chat-box-users">
                <div class="chat-box-main" id="chat-users"></div>
            </div>
            
            <div class="title-header"><h5>Аналитика карт</h5><hr></div>
            
            <div class="obj-widget-card">
                <div class="img-link">
                    <a href="/news/analitika-legendarnyh-kart-varian-rinn" class="overlay"><div><div><span class="fui-link"></span></div></div></a>
                    <img src="http://ofight.ru/uploads/974a2f21489ea379b3df647979c5192f.jpg" class="img-responsive" alt="">
                </div>
            </div>
            <div class="obj-widget-card">
                <div class="img-link">
                    <a href="/news/stoit-li-sozdavat-kartu-mariehl-chistoserdechnaya" class="overlay"><div><div><span class="fui-link"></span></div></div></a>
                    <img src="http://ofight.ru/uploads/97b59e4b468b6c433a5e2916d2622b95.jpg" class="img-responsive" alt="">
                </div>
            </div>
            <!-- 
            <div class="obj-widget-card">
                <div class="img-link">
                    <a href="/news/analitika-karty-silvana-opisanie-razlichnyh-klassov" class="overlay"><div><div><span class="fui-link"></span></div></div></a>
                    <img src="http://ofight.ru/uploads/5a045de98b128ca4d9e102a35b2702a8.jpg" class="img-responsive" alt="">
                </div>
            </div>
            --> 
            <!-- VK Widget
            <div class="hidden-xs">
                <div class="title-header"><h5>Вконтакте</h5><hr></div>
                <div class="block">
                    <div id="vk_groups" name="0:250"></div>
                </div>   
            </div>
            --> 
        </div>
    </div>
</div>
<script defer src="{THEME}/js/socket.io-1.2.0.js"></script>
