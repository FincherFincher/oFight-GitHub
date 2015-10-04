    var sitePath = window.location.pathname.split('/');
    var domain = document.domain;






    /***********************
              Перезагрузка страницы
                                ***********************/

    function pagerefresh(){
        window.location.reload(1);
    }


    /***********************
           Регистрация на турнир
                                ***********************/

    function tourUserRegistration(elem){
        var error = new Array( 'Вы зарегистрированы, ожидайте начала', 'Нужна регистрация на сайте', 'Неверный Battle.net tag', 'Все поля обязательные', 'Выберите разных героев', 'Турнир уже начался' );
        var answer = $(elem).parent().find('.dialog');
        var id = $(elem).parent().attr('name');
        var VK = $(elem).parent().find('#argVK').val();
        var Btag = $(elem).parent().find('#argBtag').val();
        var arg1 = $(elem).parent().find('#arg1').val();
        var arg2 = $(elem).parent().find('#arg2').val(); 
        var arg3 = $(elem).parent().find('#arg3').val();
        answer.slideUp(350, function(){
        //------> check VK + Btag
            if(VK == '' || Btag == ''){
                answer.html(error[3]).slideDown(600);
                return false;
            }
            
            if(VK.indexOf('vk.com/') >= 0){
                $('#argVK').val(VK.split('vk.com/')[1]);
            }  
            if(Btag.indexOf('#') < 1){
                answer.html(error[2]).slideDown(600);
                return false;
            }
            
            if(VK == '' || Btag == ''){
                answer.html(error[3]).slideDown(600);
                return false;   
            }

            $.post('/ajax.php', {type:'tour', mod:'tourReg', id:id, VK:VK, Btag:Btag, arg1:arg1, arg2:arg2, arg3:arg3}, function(data){
                if(data == 0){
                    answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350);  
                }else{
                    answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350);  
                }
            });   
        });  
    }









    function tourPreRegistration(elem){
        var error = new Array( 'Вы записаны', 'Нужна регистрация на сайте' );
        var answer = $(elem).parent().find('.dialog');
        var type = 'tour';
        var mod = 'tourPreReg';
        var id = $(elem).parent().attr('name');
        answer.slideUp(350, function(){
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, id:id},
                success: function(data){
                    if(data == 0){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350);  
                        //setTimeout('pagerefresh()', 2000);
                    }else{
                        answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350);  
                    }
                },
            });
        });
    }







                      


function testAjax(){
        var type = 'tour';
        var mod = 'tourSetResult';
        var result = 'W';
        $.ajax({
            type: "POST", 
            url: "/ajax.php",
            data:{type:type, mod:mod, id:id, result:result},
            success: function(data){

            },
        });
}








// Login website
    function logWebsite(elem){
        var error = new Array( 'Заполните все поля', 'Логин/пароль не правильный' );
        var login = $('#pswreslogin').val();
        var password = $('#pswrespsw').val();
        var answer = $(elem).parent().find('.dialog');
        var type = 'user';
        var mod = 'login';
        answer.slideUp(350, function(){
            if(login == '' || password == ''){
                answer.removeClass().addClass("dialog dialog-danger").html(error[0]).slideDown(350);  
                return false;
            }
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, uname:login, upass:password},
                success: function(data){
                    if(data == 'ok'){
                        location.reload();
                    } else {
                        answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350);  
                    }
                },
            });
        }); 
    }

// Password reset
    function pswresWebsite(elem){
        var error = new Array( 'Пароль отправлен на e-mail', 'E-mail не зарегистрирован', 'Укажите e-mail', 'Неверный e-mail' );
        var mail = $('#pswresmail').val();
        var answer = $(elem).parent().find('.dialog');
        var type = 'user';
        var mod = 'preset';
        answer.slideUp(350, function(){
            if(mail == ''){
                answer.removeClass().addClass("dialog dialog-danger").html(error[2]).slideDown(350);  
                return false;
            }
            var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if(!re.test(mail)){  
                answer.removeClass().addClass("dialog dialog-danger").html(error[3]).slideDown(350);  
                return false;
            }
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, uemail:mail},
                success: function(data){
                    if(data == 'ok'){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350);  
                        return false;
                    } else {
                        answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350);  
                        return false;
                    }
                },
            });
        });  
    }
    function pswresWebsite_op(elem){
        $(elem).parent().parent().next().slideDown(800);
    }

// Registration on the website
    function regWebsite(elem){
        var error = new Array( 'Не все поля заполнены', 'Логин и / или e-mail занят', 'Неверный e-mail' );
        var answer = $(elem).parent().find('.dialog');
        var login = $('#reglogin').val();
        var mail = $('#regmail').val();
        var password = $('#regpsw').val();
        var type = 'user';
        var mod = 'reg';
        var subsc = document.getElementById('regsubsc').checked;
        answer.slideUp(350, function(){
            if(login == '' || mail == '' || password == ''){
                answer.removeClass().addClass("dialog dialog-danger").html(error[0]).slideDown(350);  
                return false;
            }
            var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if(!re.test(mail)){  
                answer.removeClass().addClass("dialog dialog-danger").html(error[2]).slideDown(350);  
                return false;
            }
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, uname:login, uemail:mail, upass:password, usubsc:subsc},
                success: function(data){
                    if(data == 'ok'){
                        location.reload();
                    }else{
                        answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350);  
                        return false;
                    }
                },
            });
        });  
    }

// latin letters and numbers validator
    function validator_lat(x){
        x.value = x.value.replace(/[^a-z,0-9]/i, "");
    }

//  numbers validator
    function validator_num(x){
        x.value = x.value.replace(/[^0-9.]/g, "");
    }

//  latin letters and numbers validator and "_"
    function validator_url(x){
       
    }
// VK login field check
    function vkcheck(rvk){
        var vklogin = $('#' + rvk).val();    
        if(vklogin.indexOf('vk.com/') >= 0){
            array = vklogin.split('vk.com/');
            var vklogin = array[1];
            $('#' + rvk).val(vklogin);
        }       
    }
// Tourney buttons
    function tourbtn(){
        $('#uTour-4').slideUp(400, function() {
             $('#uTour-5').slideDown(500); 
        });
    }



    function tourbtncancel(){
        $('#uTour-6').slideUp(800, function() {
             $('#uTour-4').slideDown(400); 
        });
    }

    function timer(){
        var obj=document.getElementById('tmain-timer');
        obj.innerHTML--;
        if(obj.innerHTML==0){
            setTimeout(function(){
                userTourStatus();
            },1000);
        }else{
            setTimeout(timer,1000);
        }
    }






    function admin_editnews(elem){
        var id = elem.getAttribute("name");
        
    }



/*********************
    Panel ---> END
**********************/


/*********************
    CHAT ---> START
*********************/



    function chatScroll(){
        var scroll = $('#chat-message')[0].scrollHeight - 600 - $('#chat-message').scrollTop();
        $('#chat-box-users-newmsg').slideDown(400, function(){
            if(scroll > 200){
                $('#chat-box-users-newmsg').slideDown(400);
            }else{
                $('#chat-box-users-newmsg').slideUp(400); 
            }
        }); 
    }

    function chatScrollShow(){
        var scroll = $('#chat-message')[0].scrollHeight - 600 - $('#chat-message').scrollTop();
        if(scroll < 200){
            $("#chat-message").animate({ scrollTop: $('#chat-message')[0].scrollHeight+1600}, 1000); 
        }
    }

    function takeusername(elem){
        $('#message').val($('#message').val() + ' ' + $(elem).html() + ' ').focus();
    }

    function inputValTags(elem){
        elem.value = elem.value.replace(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/, "");   
    }


    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    }

    function sendMsg(uname, img){
        if(uname != ''){
            if($('#message').val() != ''){
                //scroll
                var scroll_max = $('#chat-message')[0].scrollHeight;
                var scroll_cur = $('#chat-message').scrollTop();
                var scroll_rez = $('#chat-message')[0].scrollHeight - $('#chat-message').scrollTop();
                if(($('#chat-message')[0].scrollHeight - $('#chat-message').scrollTop()) < 700){
                    $("#chat-message").animate({ scrollTop: $('#chat-message')[0].scrollHeight+1600}, 1000);
                }
                socket.emit('chat message', $('#message').val(), uname, img);  
            }
        }
        $('#message').val('');
        return false;
    }
    
    var uname = getCookie('username');
    var img = getCookie('img').replace(/%3A/g, ':').replace(/%2F/g, '/');
    if(sitePath[1] == 'chat'){
        var socket = io('backend-1.ofight.ru');
            $('#sendmsg').on('click', function(){
                sendMsg(uname, img);
            });

            $('#message').keypress(function (e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if (code == 13) {
                    sendMsg(uname, img);
                }
            });

            $(document).ready(function(){
                if(uname != ''){
                    socket.emit('add user', uname, img);
                }
                socket.on('add user', function(data){
                    $('#chat-ucount > h5').html('На канале (' + data.numUsers + ')');
                    if($('#chat-users table[name="'+ data.uname +'"]').length == 0){
                            if(data.img == '')
                            {
                                data.img = 'defaultavatar.jpg';
                            }
                        $('#chat-users').append('<table name="' + data.uname + '"><tr><td><img src="/uploads/avatars/' + data.img + '" class="img-circle"></td><td><a href="/user/profile/'+ data.uname +'" target="_blank" class="user-login">'+ data.uname +'</a></td></tr></table>');  
                    }
                });


                socket.on('users', function(data){
                    $('#chat-ucount > h5').html('На канале (' + data.numUsers + ')');
                    var array = data.uname;
                    var img = data.images;
                    for(var item in array){
                        var val = array[item];
                        if($('#chat-users table[name="'+ val +'"]').length == 0){
                            if(img[val] == '')
                            {
                                img[val] = 'defaultavatar.jpg';
                            }
                            $('#chat-users').append('<table name="' + val + '"><tr><td><img src="/uploads/avatars/' + img[val] + '" class="img-circle"></td><td><a href="/user/profile/'+ val +'" target="_blank" class="user-login">'+ val +'</a></td></tr></table>'); 
                        }
                    }   
                    }); 


                socket.on('user left', function(data){
                    $('#chat-ucount').html('На канале (' + data.numUsers + ')');
                    $('#chat-users table[name="'+ data.uname +'"]').remove();
                });
            });
            socket.on('chat message', function(msg, uname, img){
                            if(img == '')
                            {
                                img = 'defaultavatar.jpg';
                            }
                $('#chat-message').append('<table name="' + uname + '"><tr><td><img src="/uploads/avatars/' + img + '" class="img-circle"></td><td><span onclick="takeusername(this);" class="user-login">'+ uname +'</span><p>' + msg + '</p></td></tr></table>'); 
                chatScrollShow();
            });
    }

/*****************
    Chat ---> End
*****************/





/*****************
    NAVIGATION
*****************/
    if(sitePath[1] != ''){
        $('#mainNav>li[name="'+ sitePath[1] +'"]').addClass('active');
    }

/*****************
    COMMENTS
*****************/

    function addComment(){
        var type = 'news';
        var mod = 'addComment';
        var uname = $('#uname').val();
        var comment = $('#comment').val();
        var url = sitePath[2];
        if(comment != '' && uname != ''){
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, uname:uname, comment:comment, url:url},
                success: function(data){
                        data = JSON.parse(data);
                        if(data[0] == 'ok') {
                            $('#comments').prepend('<tr><td><div><img src="/uploads/avatars/'+data[1]['avatar']+'" class="img-circle"></div></td><td><a href="/user/'+data[1]['username']+'" class="user-login">'+data[1]['username']+'</a><p>'+comment+'</p></td></tr>');
                            $('#comment').val('');
                        }
                },
            });
        }
    }

/*****************
    USER
*****************/

    /***********************
                Общее для атрибутов
                                ***********************/

    function PP_attr_cancel(elem, buttonname){
        
        $(elem).parent().next().slideUp(600);
        $(elem).prev().animate({width:'hide'},450, function(){
            $(elem).prev().removeClass().addClass("unit-btn-green pointer").attr('name', 'close').html('&nbsp;&nbsp;&nbsp;'+buttonname+'&nbsp;&nbsp;&nbsp;').animate({width:'show'},450);
        });    
        $(elem).animate({width:'hide'},150);
        
    }

    function PP_attr_open(elem, buttonname){
        
        $(elem).removeAttr('name');
        $(elem).parent().next().slideDown(600); 
        $(elem).animate({width:'hide'},450, function(){
            $(elem).removeClass().addClass("unit-btn-red pointer").html('&nbsp;&nbsp;&nbsp;'+buttonname+'&nbsp;&nbsp;&nbsp;').animate({width:'show'},450);
            $(elem).next().animate({width:'show'},150);
        }); 
        
    }

    function PP_attr_success(elem, buttonname){
        
        $(elem).parent().next().slideUp(600);
        $(elem).next().animate({width:'hide'},150);
        $(elem).animate({width:'hide'},450, function(){
            $(elem).removeClass().addClass("unit-btn-green pointer").attr('name', 'close').html('&nbsp;&nbsp;&nbsp;'+buttonname+'&nbsp;&nbsp;&nbsp;').animate({width:'show'},450);
        }); 
        
    }

    /***********************
                        Поплавки турнир
                                ***********************/

    function PP_tour_open(elem, buttonname){
        $(elem).removeAttr('name');
        $(elem).next().slideDown(600); 
        $(elem).animate({width:'hide'},450, function(){
            $(elem).removeClass().addClass("unit-btn-red pointer").html('&nbsp;&nbsp;&nbsp;'+buttonname+'&nbsp;&nbsp;&nbsp;').animate({width:'show'},450);
            $(elem).next().animate({width:'show'},150);
        }); 
    }
    function PP_tour_close(elem, buttonname){
        $(elem).next().slideUp(600); 
        $(elem).animate({width:'hide'},450, function(){
            $(elem).removeClass().addClass("unit-btn-green pointer").attr('name', 'close').html('&nbsp;&nbsp;&nbsp;'+buttonname+'&nbsp;&nbsp;&nbsp;').animate({width:'show'},450);
            $(elem).parent().find('input').val('');
        });  
        $(elem).next().animate({width:'hide'},150); 
    }
    function PP_tour_push(elem){
        if($(elem).attr('name') == 'close'){
            PP_tour_open(elem, 'Hide');
        } else {
            
            PP_tour_close(elem, 'Show');
        }
    }
    function start_tourney(elem){
        var type = 'tour';
        var mod = 'tourstart';
        var tourid = $(elem).parent().parent().attr('name');
        var answer = $(elem).next();
        var error = new Array( 'Турнир создан', 'Время начала не пришло', 'Турнир уже начался' );
        $.ajax({
            type: "POST", 
            url: "/ajax.php",
            data:{type:type, mod:mod, tourid:tourid},
            success: function(data){
                if(data == 'ok'){
                    answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350).delay(3000).slideUp(350); 
                }else{
                    answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350).delay(3000).slideUp(350); 
                }
            },
        }); 
    }

    /***********************
                        Добавить VK
                                ***********************/

    function userAttr(elem, attrName){
        var type = 'user';
        var mod = 'userparam';
        var attrValue = $(elem).parent().next().find('input').val();  
        var attrName = $(elem).parent().attr('name');
        var error = new Array( 'Данные обновлены', 'Неверный vk id', 'Заполните поле', 'Неверный Battle.net tag');
        var answer = $(elem).parent().next().find('.dialog');
        answer.slideUp(350, function(){
            if($(elem).attr('name') == 'close'){
                PP_attr_open(elem, 'Установить');
            } else {
                var attrValue = $(elem).parent().next().find('input').val();  
                
                    if(attrName == 'bnettag'){
                        var re = /^[^0-9]*#[0-9]/;
                        if(!re.test(attrValue)){  
                            answer.html(error[3]).slideDown(600); 
                            return false;
                        }  
                    }

                    if(attrName == 'vkcom'){
                        if(attrValue.indexOf('vk.com/') >= 0){
                            array = attrValue.split('vk.com/');
                            var attrValue = array[1];
                        }
                    }
                
                if(attrValue == ''){
                    answer.removeClass().addClass("dialog dialog-danger").html(error[2]).slideDown(350); 
                } else {

                    $.ajax({
                        type: "POST", 
                        url: "/ajax.php",
                        data:{type:type, mod:mod, attrValue:attrValue, attrName:attrName},
                        success: function(data){
                            if(data == 'ok'){
                                answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350).delay(2000).slideUp(350, function(){
                                    PP_attr_success(elem, 'Обновить');
                                }); 
                            }
                        },
                    }); 
                }
            }
        });
    }

    /***********************
                    Добавить Battle.net
                                ***********************/
/*
    function PP_attr_btag(elem){
        var type = 'user';
        var mod = 'bnettag';
        var error = new Array( 'Данные обновлены', 'Неверный Battle.net tag' );
        var answer = $(elem).parent().next().find('.dialog');
        
        answer.slideUp(350, function(){
            if($(elem).attr('name') == 'close'){
                PP_attr_open(elem, 'Установить');
            } else{   
                var btag = $(elem).parent().next().find('input').val();
                var re = /^[^0-9]*#[0-9]/;
                if(!re.test(btag)){  
                    answer.html(error[1]).slideDown(600); 
                } else {
                    $.ajax({
                        type: "POST", 
                        url: "/ajax.php",
                        data:{type:type, mod:mod, btag:btag},
                        success: function(data){
                            if(data == 'ok'){
                                answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350).delay(2000).slideUp(350, function(){
                                    PP_attr_success(elem, 'Обновить');
                                }); 
                            }
                        },
                    });  
                }
            }
        });
    }

*/







/*****************
    TOURNEY
*****************/

    /***********************
                    Одобрить турнир
                                ***********************/
    function acceptTour(elem){
        var type = 'tour';
        var mod = 'accept';
        var error = new Array( 'Турнир успешно создан', 'Не все поля заполнены', 'Другие проверки', 'Такой турнир уже существует' ); 
        var answer = $(elem).parent().find('.dialog');
        answer.slideUp(350, function(){
            var id = $(elem).parent().parent().prev().attr('name');
            var name = $(elem).parent().find('#tname').val();     
            var prize =  $(elem).parent().find('#tprize').val();   
            var img = $(elem).parent().find('#timg').val();       
            var game =  $(elem).parent().find('#tgame').val();     
            var tourmod = $(elem).parent().find('#tmod').val();      
            var tourtype = $(elem).parent().find('#ttype').val();     
            var date = $(elem).parent().find('.form-group[name="tdate"]').find('input').val();   
            var rule = $(elem).parent().find('#trule').val();      
            var admin = $(elem).parent().find('#tadmin').next().val();    
            var mblock = $(elem).parent().find('#tmblock').val(); 
            var rblock  = $(elem).parent().find('#trblock').val(); 
            var author  = $(elem).parent().find('#tauthor').val();  
            if(name == '' || prize == '' || img == '' || game == null || tourmod == null || tourtype == null || date == '' || rule == null || admin == '' || mblock == '' || rblock == ''){
                answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
                return false;
            }
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, name:name, prize:prize, img:img, game:game, tourmod:tourmod, tourtype:tourtype, date:date, rule:rule, admin:admin, mblock:mblock, rblock:rblock, id:id, author:author},
                success: function(data){
                    if(data == 'ok'){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350, function(){
                            setTimeout('pagerefresh()', 1000);
                        });
                    }else{      
                        answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350); 
                    }
                },
            });
        });  
    }

    /***********************
                    Открыть турнир
                                ***********************/
    function PP_tourdata_open(elem){
        var type = 'tour';
        var mod = 'gettourinfo';
        if($(elem).attr('name') == 'close'){
            var tid = $(elem).parent().attr('name');
            $(elem).removeAttr('name');
            $(elem).parent().next().slideDown(1200); 
            $(elem).animate({width:'hide'},450, function(){
                $(elem).removeClass().addClass("unit-btn-red pointer").html('&nbsp;&nbsp;&nbsp;Hide&nbsp;&nbsp;&nbsp;').animate({width:'show'},450);
                $(elem).next().animate({width:'show'},150);
            }); 
        }else{
            $(elem).parent().next().slideUp(1200); 
            $(elem).animate({width:'hide'},450, function(){
                $(elem).removeClass().addClass("unit-btn-green pointer").attr('name', 'close').html('&nbsp;&nbsp;&nbsp;Show&nbsp;&nbsp;&nbsp;').animate({width:'show'},450);
                $(elem).parent().find('input').val('');
            });  
            $(elem).next().animate({width:'hide'},150);
        }   
    }

    /***********************
                    Создать турнир
                                ***********************/
    function createTour(elem){
        var type = 'tour';
        var mod = 'create';
        var error = new Array( 'Турнир успешно создан', 'Не все поля заполнены', 'Такой турнир уже существует' ); 
        var answer = $(elem).parent().find('.dialog');
        answer.slideUp(350, function(){
            var name = $(elem).parent().find('#tname').val();     
            var prize =  $(elem).parent().find('#tprize').val();   
            var img = $(elem).parent().find('#timg').val();       
            var game =  $(elem).parent().find('#tgame').val();  
            var tourmod = $(elem).parent().find('#tmod').val();       
            var tourtype = $(elem).parent().find('#ttype').val();    
            var date = $(elem).parent().find('.form-group[name="tdate"]').find('input').val();   
            var rule = $(elem).parent().find('#trule').val();   
            var admin = $(elem).parent().find('#tadmin').next().val();   
            var mblock = $(elem).parent().find('#tmblock').val(); 
            var rblock  = $(elem).parent().find('#trblock').val();

            if(name == '' || prize == '' || img == '' || game == null || tourmod == null || tourtype == null || date == '' || rule == null || admin == '' || mblock == '' || rblock == ''){
                answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
                return false;
            }

            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, name:name, prize:prize, img:img, game:game, tourmod:tourmod, tourtype:tourtype, date:date, rule:rule, admin:admin, mblock:mblock, rblock:rblock},
                success: function(data){
                    if(data == 'ok'){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350, function(){
                            setTimeout('pagerefresh()', 1000);
                        });
                    }else{
                        answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350); 
                    }
                },
            });
        });  
    }


    function createNews(elem)
    {
        var type = 'news';
        var mod = 'create'; 
        var error = new Array( 'Новость отправлена на модерацию', 'Не все поля заполнены' ); 
        var answer = $(elem).parent().find('.dialog');
        
        answer.slideUp(350, function(){
            var titlename = $(elem).parent().find('#news_titlename').val();     
            var picture = $(elem).parent().find('#news_picture').val();     
            var title = $(elem).parent().find('#news_title').val();     
            var description = $(elem).parent().find('#news_description').val();     
            var keywords = $(elem).parent().find('#news_keywords').val();     
            var urlname = $(elem).parent().find('#news_urlname').val();     
            var prevtext = $(elem).parent().find('#news_prevtext').val();     
            var maintext = $(elem).parent().find('#news_maintext').val();     
            var author = $(elem).parent().find('#news_author').val();     
            var category = $(elem).parent().find('#news_category').val();     

            if(titlename == '' || picture == '' || title == '' || description == '' || keywords == '' || urlname == '' || prevtext == '' || maintext == '' || author == '' || category == null)
            {
                answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
                return false;  
            }
            
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, titlename:titlename, picture:picture, title:title, description:description, keywords:keywords, urlname:urlname, prevtext:prevtext, maintext:maintext, author:author, category:category},
                success: function(data){
                    if(data == 'ok'){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350, function(){
                            setTimeout('pagerefresh()', 1000);
                        });
                    }else{
                        answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350); 
                    }
                },
            });
            
        });  
    }



    function moderateNews(elem)
    {
        var type = 'news';
        var mod = 'moderate'; 
        var error = new Array( 'Новость опубликована', 'Не все поля заполнены' ); 
        var answer = $(elem).parent().find('.dialog');
        answer.slideUp(350, function(){
            var id = $(elem).parent().parent().find('.unit-v1').attr('name');  
            var titlename = $(elem).parent().find('#news_titlename').val();     
            var picture = $(elem).parent().find('#news_picture').val();     
            var title = $(elem).parent().find('#news_title').val();     
            var description = $(elem).parent().find('#news_description').val();     
            var keywords = $(elem).parent().find('#news_keywords').val();     
            var urlname = $(elem).parent().find('#news_urlname').val();     
            var prevtext = $(elem).parent().find('#news_prevtext').val();     
            var maintext = $(elem).parent().find('#news_maintext').val();     
            var author = $(elem).parent().find('#news_author').val();     
            var category = $(elem).parent().find('#news_category').val();     

            if(titlename == '' || picture == '' || title == '' || description == '' || keywords == '' || urlname == '' || prevtext == '' || maintext == '' || author == '' || category == null)
            {
                answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
                return false;  
            }
            
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, id:id, titlename:titlename, picture:picture, title:title, description:description, keywords:keywords, urlname:urlname, prevtext:prevtext, maintext:maintext, author:author, category:category},
                success: function(data){
                    if(data == 'ok'){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350, function(){
                            setTimeout('pagerefresh()', 1000);
                        });
                    }else{
                        answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350); 
                    }
                },
            });
            
        }); 
    }




    // set winner
    function moveTour(elem){
        var answer = $(elem).parent().find('.dialog').first();
        answer.slideUp(600); 
        if($(elem).attr('name') == 'close'){
            $(elem).removeAttr('name');
            $(elem).next().slideDown(600); 
            $(elem).animate({width:'hide'},450, function(){
                $(elem).removeClass().addClass("unit-btn-red pointer").html('&nbsp;&nbsp;&nbsp;Hide&nbsp;&nbsp;&nbsp;').animate({width:'show'},450);
                $(elem).next().animate({width:'show'},150);
            }); 
        }else{
            $(elem).next().slideUp(600); 
            $(elem).animate({width:'hide'},450, function(){
                $(elem).removeClass().addClass("unit-btn-green pointer").attr('name', 'close').html('&nbsp;&nbsp;&nbsp;Show&nbsp;&nbsp;&nbsp;').animate({width:'show'},450);
                $(elem).parent().find('input').val('');
            });  
            $(elem).next().animate({width:'hide'},150);
        }
    }


    function moveTour_swn(elem){
        var error = new Array( 'Ошибка в логине', 'Укажите логин', 'продвинут вперед' );
        var answer = $(elem).parent().find('.dialog').first();
        answer.slideUp(350, function(){
            var wlogin = $(elem).parent().find('input').val();
            if(wlogin == ''){
                answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
            }else{
                // AJAX data = '' or int
                data = '';
                if(!data){
                    answer.removeClass().addClass("dialog dialog-success").html(wlogin + ' ' + error[2]).slideDown(350); 
                }else{
                    answer.removeClass().addClass("dialog dialog-danger").html(error[0]).slideDown(350); 
                }
            }
        });  
    }
    function end_tourney(elem){

        var type = 'tour';
        var mod = 'tourEnd';
        var tourid = $(elem).parent().parent().attr('name');
        var answer = $(elem).next();
        var error = new Array( 'Турнир завершен, идет рестарт', 'Победитель не определен' ); 
        $.ajax({
            type: "POST", 
            url: "/ajax.php",
            data:{type:type, mod:mod, tourid:tourid},
            success: function(data){
                if(data == 'ok'){
                    answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350);
                    setTimeout(function(){
                       window.location.reload(1);
                    }, 2000);
                }else{
                    answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
                }
            },
        }); 
    }



    // delete twitch channel
    function deleleStreamer(elem){
        if($(elem).attr("class") == "unit-btn-green pointer"){
            $(elem).animate({width:'hide'},450, function(){
                $(elem).removeClass().addClass("unit-btn-red pointer");
                $(elem).prev().css("color", "#ea6153");
                $(elem).animate({width:'show'},450);
            });  
        }else{
            $(elem).parent().slideUp(450, function(){  
                var type = 'tour';
                var mod = 'delTwitch';
                var twitch = $(elem).prev().html();
                $(elem).parent().empty();
                $.ajax({
                    type: "POST", url: "/ajax.php",
                    data:{type:type, mod:mod, twitch:twitch},
                });
            });  
        } 
    }
    // add twitch channel
    function addStreamer(elem){
        var error = new Array( 'Канал добавлен', 'Канал не существует' );
        var answer = $(elem).parent().find('.dialog');
        var twitch = $(elem).parent().find('input').val();
        
        answer.slideUp(350, function(){
            $.getJSON("https://api.twitch.tv/kraken/channels/"+ twitch +".json?callback=?", function(response){
                response = JSON.stringify(response);
                response = jQuery.parseJSON(response);
                var type = 'tour';
                var mod = 'addTwitch';
                if(response._id > 0){
                    $.ajax({
                        type: "POST", url: "/ajax.php",
                        data:{type:type, mod:mod, twitch:twitch},
                    });
                    $(elem).parent().find('div').first().append('<div class="unit-v1"><span class="fui-youtube"></span><span>'+twitch+'</span><span class="unit-btn-green pointer" onclick="deleleStreamer(this)">&nbsp;&nbsp;&nbsp;Delete&nbsp;&nbsp;&nbsp;</span></div>');
                    answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350);  
                }else{
                    answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
                }
            });	 
        });  
    }


    /***********************
                     FILE UPLOAD AVATAR
                                ***********************/
    function addUseravatarPicture(elem){
        elem = $('#addUseravatarPicture');
        addUseravatar(elem);
    }

    function addUseravatar(elem){
        var error = new Array( 'Неверный формат', 'Размер не равен 100 х 100', 'Кратинка более 100 кбайт' );
        var answer = $(elem).parent().next().find('.dialog');
        answer.slideUp(600); 
        
        if($(elem).attr('name') == 'close'){
            $(elem).removeAttr('name');
            $(elem).parent().next().slideDown(900); 
            $(elem).animate({width:'hide'},450, function(){
                $(elem).removeClass().addClass("unit-btn-red pointer").html('&nbsp;&nbsp;&nbsp;Загрузить&nbsp;&nbsp;&nbsp;').animate({width:'show'},450);
                $(elem).next().animate({width:'show'},150);
            }); 
        }else{
            var fd = new FormData(document.getElementById("fileinfo"));
                fd.append("fUploadType", "uAvatar");
                $.ajax({
                    url: '/upload.php',  
                    type: 'POST',
                    data: fd,
                    success:function(data){

                        if(data == 0){
                            answer.html(error[data]).slideDown(600); 
                            return false;
                        }
                        
                        if(data == ''){
                            answer.html(error[2]).slideDown(600); 
                            return false;
                        }
                        
                        $(elem).animate({width:'hide'},450, function(){
                            $(elem).next().animate({width:'hide'},150);

                            $(elem).parent().next().slideUp(750, function(){
                                $(elem).removeClass().addClass("unit-btn-green pointer").attr('name', 'close').html('&nbsp;&nbsp;&nbsp;Обновить&nbsp;&nbsp;&nbsp;').animate({width:'show'},450, function(){
                                    $('#useravatarImage').attr('src', '/uploads/avatars/'+data);
                                });
                            });
                        });
                    }, 
                    cache: false,
                    contentType: false,
                    processData: false
                    
            });
        }
    }



    /***********************
                     FILE UPLOAD PICTURE
                                ***********************/
    function userUploadPicture(elem){
        var error = new Array( 'Файл загружен', 'Формат только jpg', 'размер < 200 кб' );
        var answer = $(elem).parent().find('.dialog');
        var file = $('#fileUpl').val();  
        $('#fileUpl_link').slideUp(350);
        answer.slideUp(350, function(){
            var fd = new FormData(document.getElementById("fileinfo"));
            fd.append("fUploadType", "regularUpload");
            $.ajax({
                url: '/upload.php',  
                type: 'POST',
                data: fd,
                success:function(data){

                    if(!$.isNumeric(data)){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350, function(){
                            $('#userUploadPictureCopyLink').attr('name', 'http://ofight.ru/uploads/'+data);
                            $('#userUploadPictureCopyLink').show(450);
                        }); 
                        return false;
                    } else {
                        answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350); 
                        return false;
                    }

                }, 
                cache: false,
                contentType: false,
                processData: false
            });
        });  
    }
    function userUploadPictureCopyLink(elem){
        var answer = $(elem).parent().find('.dialog');
        var error = new Array( 'Скопировано в буфер' );
        var link = $(elem).attr('name');
        window.prompt("Copy to clipboard: Ctrl+C, Enter", link);
        answer.slideUp(350, function(){
            answer.removeClass().addClass("dialog dialog-warning").html(error[0]).slideDown(350);
        }); 
    }








    //team
    // cog over
    function unitTeam_conf(elem){
        if($(elem).attr('name') == 'close'){
            var uname = $(elem).prev().find('a').attr('name');
            $(elem).prev().animate({width:'hide'},550, function(){
                    $(elem).prev().html('&nbsp;&nbsp;&nbsp;<a class="pointer" name="'+uname+'" onclick="unitTeam_lead(this);">лидер</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="pointer" onclick="unitTeam_del(this);">удалить</a>');
                    $(elem).prev().animate({width:'show'},550);
            }); 
            $(elem).animate({width:'hide'},550, function(){
                    $(elem).html('<i class="fa fa-times pointer"></i>');
                    $(elem).animate({width:'show'},550);
                    $(elem).removeAttr('name');
            });   
        }else{
            var uname = $(elem).prev().find('a').attr('name');
            $(elem).prev().animate({width:'hide'},550, function(){
                    $(elem).prev().html('<a href="#" class="user-login" name="'+uname+'">&nbsp;&nbsp;&nbsp;EricaSmith</a>');
                    $(elem).prev().animate({width:'show'},550);
            }); 
            $(elem).animate({width:'hide'},550, function(){
                    $(elem).html('<i class="fa fa-cog pointer"></i>');
                    $(elem).animate({width:'show'},550);
                    $(elem).attr('name','close');
            });   
        }
    }
    function unitTeam_lead(elem){
        var a = $(elem).attr('name');
        
        // AJAX
        location.reload();
    }
    function unitTeam_del(elem){
        $(elem).parent().parent().hide(550);
    }



    /***********************
                         Get Player Rank
                                ***********************/
    
    function getPlayerRanking(elem)
    {
        var type = 'user';
        var mod = 'getPlayerRanking';   
        var error = new Array( 'Неверный логин' ); 
        var answer = $(elem).parent().find('.dialog');
        if($('#getPlayerRanking_block').is(":hidden")){
            $('#getPlayerRanking_block').slideDown(350);
        }
        answer.slideUp(350, function(){
            var name = $(elem).parent().find('#getPlayerRanking_name').val(); 
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, name:name},
                success: function(data){
                    if(!$.isNumeric(data)){
                        data = JSON.parse(data);
                        $('#getPlayerRanking_data').html('<tr><td>'+data[1]+'</td><td><div class="obj-uLogo"><img id="tBlock-data-en-avatar" src="/uploads/avatars/'+data[0].avatar+'" class="img-circle"></div></td><td><a href="/user/profile/'+data[0].username+'" class="obj-uName" id="tBlock-data-en-name">'+data[0].username+'</a></td><td>'+data[0].wincount+'</td><td>'+data[0].defeatcount+'</td></tr>');
                    }else{
                        answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350); 
                    }
                },
            });
        }); 
    }




    /***********************
                         setWinnerByAdmin
                                ***********************/

    //------> Set Win
    
    function setWinnerByAdmin(elem){
        var type = 'tour';
        var mod = 'setWinnerByAdmin';
        var error = new Array( 'Корректировка завершена', 'Не все поля заполнены', 'Ошибка, такой пары нет' ); 
        var answer = $(elem).parent().find('.dialog');
        answer.slideUp(350, function(){
            var id = $(elem).parent().parent().parent().attr('name');
            var winner = $(elem).parent().find('#winner').val();     
            var loser =  $(elem).parent().find('#loser').val();   
            var round = $(elem).parent().find('#round').val();       

            if(winner == '' || loser == '' || round == ''){
                answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
                return false;
            }

            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, winner:winner, loser:loser, round:round, id:id},
                success: function(data){
                    if(data == 'ok'){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350, function(){
                            $('#winner').val('');
                            $('#loser').val('');
                            $('#round').val('');
                        });
                    }else{
                        answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350); 
                    }
                },
            });
        });  
    }

    //------> Дисквалификация

    function setDisqualifyByAdmin(elem){
        var error = new Array( 'Игрок дисквалифицирован', 'Неверное имя игрока' ); 
        var answer = $(elem).parent().find('.dialog');
        var user = $(elem).parent().find('#setDisqualifyByAdmin_user').val(); $(elem).parent().find('#setDisqualifyByAdmin_user').val('');
        answer.slideUp(450, function(){
            $.post('/ajax.php', {type:'tour', mod:'setDisqualifyByAdmin', user:user}, function(data){
                if(data == 0){
                    answer.removeClass().addClass("dialog dialog-success").html(error[data]).slideDown(350); 
                }else{
                    answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350); 
                }
            });   
        }); 
    }


    function SelfDisqualify_set(elem){
        var set = $(elem).parent();
        var conf = set.next();
        set.slideUp(450, function(){
            conf.slideDown(550); 
        }); 
    }
    function SelfDisqualify_conf(elem){
        var conf = $(elem).parent();
        var user = getCookie('username');
        conf.slideUp(550, function(){
            $.post('/ajax.php', {type:'tour', mod:'setDisqualifyByAdmin', user:user}, function(data){
                pagerefresh();
            }); 
        });  
    }
    function SelfDisqualify_cancel(elem){
        var conf = $(elem).parent();
        var set = conf.prev();
        conf.slideUp(550, function(){
            set.slideDown(450); 
        }); 
    }

    //------> Get info   getInfoAboutUser_data

    function getInfoAboutUser(elem)
    {
        var type = 'tour';
        var mod = 'getInfoAboutUser';
        var error = new Array( 'Ошибка в имени', 'Логин введен неверный', 'Введите логин' ); 
        var answer = $(elem).parent().find('.dialog');
        var block = $(elem).parent().parent().find('#getInfoAboutUser_data');
        
        answer.slideUp(450, function()
        {
            $('#getInfoAboutUser_data').hide(300);
            var id = $(elem).parent().parent().parent().attr('name');
            var user = $(elem).parent().find('#getInfoAboutUser').val();   
            if(user == '')
            {
                answer.removeClass().addClass("dialog dialog-danger").html(error[2]).slideDown(350); 
                return false;
            }

            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod, user:user, id:id},
                success: function(data){
                    
                    if(data == '1'){
                        answer.removeClass().addClass("dialog dialog-danger").html(error[data]).slideDown(350); 
                    }else{
                        data = JSON.parse(data);
                        $('#getInfoAboutUser').val('');
                        $('#getInfoAboutUser_data').show();
                         if(data[0].MoveTo_SE != 'y')
                         {
                            var bracket = 'Группа';
                         } else {
                            var bracket = 'На выбывание';  
                         }
                         //console.log(data);
                         block.html('<div class="unit-text-sm-2"> Логин: '+data[0].username+'</div><div class="unit-text-sm-2"> Vk.com: '+data[2].vkcom+'</div><div class="unit-text-sm-2"> B.net Tag: '+data[2].bnettag+'</div><div class="unit-text-sm-2">Сетка : '+bracket+'</div><div class="unit-text-sm-2"> Раунд: '+data[1]+'</div><div class="unit-text-sm-2"> Противник: '+data[3].username+'</div>').slideDown(500); 
   
                    }
                },
            }); 
        });  
    }





    //------> ANALITICS BRACKETS
    function getRoundOneAnalytic(elem){ 
        var id = $(elem).parent().parent().parent().attr('name');
        var round = $(elem).parent().find('#getRoundOneAnalytic_round').val();
        var error = new Array( 'Введите раунд', 'В группах 3 раунда'); 
        var answer = $(elem).parent().find('.dialog');
        var block = $(elem).parent().parent().find('.unit-table').find('#getRoundOneAnalytic_data');
        block.slideUp(100, function(){
            block.slideDown().html('');
            $('#getRoundOneAnalytic_info').html('');
            if(round == ''){
                answer.removeClass().addClass("dialog dialog-danger").html(error[0]).slideDown(350); return false;
            } 
            if(round > 3){
                answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); return false;
            }  
            answer.slideUp(450, function(){
                $('#getRoundOneAnalytic_info').html('').append('<p>Данные проверки '+round+'-го раунда</p>');
                $.post('/ajax.php', {type:'tour', mod:'getRoundOneAnalytic', round:round, id:id}, function(data){
                    data = JSON.parse(data);
                    i = 0; while(i < data.length){ 
                        if(i%2 != 0){ 
                            k = i - 1; col = '';
                            
                            if(data[i]['r'+round+'finalrez'] != '' && data[k]['r'+round+'finalrez'] != ''){
                                col = '#2ecc71';
                            } else if ( (data[i]['r'+round+'rez'] != '' && data[k]['r'+round+'rez'] == '') || (data[i]['r'+round+'rez'] == '' && data[k]['r'+round+'rez'] != '') ){
                                col = '#e74c3c';
                            } else {
                                col = '';
                            }
                            block.append('<tr style="background: '+col+';"><td>'+data[i]['username']+'</td><td>'+data[i]['r'+round+'rez']+'</td><td>'+data[i]['r'+round+'finalrez']+'</td></tr>');
                            block.append('<tr style="background: '+col+';"><td>'+data[k]['username']+'</td><td>'+data[k]['r'+round+'rez']+'</td><td>'+data[k]['r'+round+'finalrez']+'</td></tr>');
                        } 
                    i++}
                }); 
            }); 
        });        
    }

/* <tr><td>'++'</td><td>'++'</td><td>'++'</td><td>'++'</td></tr> */

    /***********************
                         sendVacancy
                                ***********************/
        function sendVacancy(elem){
            var type = 'user';
            var mod = 'sendVacancy';    
            var realName = $(elem).parent().find('#realName').val();    
            var eMail = $(elem).parent().find('#eMail').val();    
            var topic = $(elem).parent().find('#topic').val();    
            var textInfo = $(elem).parent().find('#textInfo').val();    
            var error = new Array( 'Заявка отправлена', 'Не все поля заполнены' );
            var answer = $(elem).parent().find('.dialog');
            
            if(realName == '', eMail == '', topic == '', textInfo == ''){
                answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
                return false;
            }
        
            answer.slideUp(350, function(){
                $.ajax({
                    type: "POST", 
                    url: "/ajax.php",
                    data:{type:type, mod:mod, realName:realName, eMail:eMail, topic:topic, textInfo:textInfo},
                    success: function(data){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350);
                        $(elem).parent().find('#realName').val('');    
                        $(elem).parent().find('#eMail').val('');    
                        $(elem).parent().find('#topic select').val('base');    
                        $(elem).parent().find('#textInfo').val('');  
                    },
                });
            });
        }

    /***********************
                         sendTourCreateFrom
                                ***********************/
        function sendTourCreateFrom(elem)
        {
            var type = 'user';
            var mod = 'sendTourCreateFrom';   
            var realName = $(elem).parent().find('#realName').val();    
            var eMail = $(elem).parent().find('#eMail').val();  
            var textInfo = $(elem).parent().find('#textInfo').val();  
            var error = new Array( 'Заявка отправлена', 'Не все поля заполнены' );
            var answer = $(elem).parent().find('.dialog');
            if(realName == '', eMail == '', textInfo == ''){
                answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
                return false;
            }
            answer.slideUp(350, function(){
                $.ajax({
                    type: "POST", 
                    url: "/ajax.php",
                    data:{type:type, mod:mod, realName:realName, eMail:eMail, textInfo:textInfo},
                    success: function(data){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350);
                        $('#realName').val('');    
                        $('#eMail').val('');    
                        $('#textInfo').val('');  
                    },
                });
            });
        }







      
    /***********************
                       Tourney Status
                                ***********************/

        function userTourStatus(){
            var type = 'tour';
            var mod = 'tourPlayerData';
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod},
                success: function(uStatus){

            //------> Если незареген
                    
                    if(uStatus == 'notRegistr'){
                        return false;
                    }
                    
            //------> Если нет турнира
                    
                    if(uStatus == 'noTour'){
                        setTimeout(function(){ userTourStatus(); }, 45000);
                        return false;
                    }
                    
                    uStatus = JSON.parse(uStatus);
                    console.log(uStatus);
                    
            //------> встаем на прослушку
                    var eventSource = new EventSource('/SSE.php');
                    eventSource.onopen = function(e){};
                    eventSource.onerror = function(e){
                        if(this.readyState != EventSource.CONNECTING){
                            console.log("Ошибка, состояние: " + this.readyState);
                        }
                    };
                    eventSource.onmessage = function(e){
                        if(event.data > 0){
                            eventSource.close();
                            userTourStatus();
                        }
                    };
                    
                    var tourFAQ = {
                                      "Hearthstone": '-&nbsp;&nbsp;игры до 2х побед, финал до 3х<br>-&nbsp;&nbsp;победитель всегда меняет колоду<br>-&nbsp;&nbsp;проигравший по желанию<br>-&nbsp;&nbsp;нужно делать screen-shot побед<br>-&nbsp;&nbsp;противник&nbsp;&nbsp;АФК >15 мин, - auto-kick<br>-&nbsp;&nbsp;с проблемами обращаться в <a href="http://ofight.ru/chat">чат</a>'
                                  };
                    
                    var ShowStatus = {
                                      "EnemyEmpty": "Противник еще играет предыдущий раунд, подождите немного",
                                      "EnemyResultEmpty": "Результат не подтвержден противником",
                                      "ResultError": "Ошибка ввода результатов, обратитесь к судье турнира на странице чата",
                                      "ShowConfirm": "Подтвердите участие в раунде, иначе Вам будет засчитано поражение на турнире",
                                      "TourEndForUser": "Вы проиграли и турнир для Вас закончен, но не печальтесь, скоро все начнется по новой",
                                      "UserWinPlace_1": "Поздравляем, Вы победили, напишите сюда для получения приза: vk.com/serdyukov_s",
                                      "UserWinPlace_2": "Ну чтож, это была достойная игра, Вы заняли 2-е место",
                                      "UserWinPlace_3": "Ну чтож, это была достойная игра, Вы заняли 3-е место",
                                      "SetAutoWin": "Ваш противник не подтвердил участие, подождите 10 минут и Вам будет дана автоматическая победа в раунде",
                                      "WaitGroupEnd": "Групповой раунд для Вас завершен, подождите окончания игр противников, после чего будут определены финалисты турнира",
                                      "UserResultEmpty": "Сразитесь с противником и внесите результаты"
                                     };
                    
                    $('.tournament-frame').slideUp(550, function() {

                            $('#uTour-2').hide();
                            $('#uTour-3').hide();
                            $('#uTour-4').hide();
                            $('#uTour-5').hide();
                            $('#uTour-6').hide();
                            $('#uTour-7').hide();
                            $('#uTour-9').hide();

                            $('#tBlock-data-name').html(uStatus.tourData.tourname);
                            $('#tBlock-data-round').html('Раунд '+uStatus.tourRound);   
                            $('#tBlock-data-bracket').attr('href', '/bracket/'+uStatus.tourData.id);
                            $('#tBlock-data-rule').attr('href', decodeURIComponent(uStatus.tourData.tourrules));
                            $('#tBlock-data-en-name').html(uStatus.tourEnemy.username);
                            $('#tBlock-data-en-avatar').attr('src', '/uploads/avatars/'+uStatus.tourEnemyData.avatar);
                            $('#tBlock-data-en-btag').html('Battle Tag: '+uStatus.tourEnemyData.bnettag);
                            $('#tBlock-data-en-vk').html('Vkontakte: '+uStatus.tourEnemyData.vkcom); 

                            if(uStatus.tourData.tourgame == 'Hearthstone'){
                                $('#tBlock-data-en-race').html('Герои: '+uStatus.tourEnemy.race1+', '+uStatus.tourEnemy.race2+', '+uStatus.tourEnemy.race3); 
                                $('#tBlock-data-user-heroes').html('Ваши герои: '+uStatus.tourUser.race1+'  '+uStatus.tourUser.race2+'  '+uStatus.tourUser.race3); 
                            }

                            $('#tBlock-data-status').html(ShowStatus[uStatus.tourStatus]); 
                            if(uStatus.tourStatus == 'EnemyResultEmpty'){
                                $('#delete_result').show(); 
                            }
                            $('#tBlock-data-faq').html(tourFAQ[uStatus.tourData.tourgame]);
                        
                            //Ввод подтверждения
                            if(uStatus.tourStatus == 'ShowConfirm')
                            {
                                $("#tmain-timer").html(uStatus.tourConfirmTime);
                                $('#tBlock-data-confirm').show();
                                setTimeout(timer, 1000);
                            }

                            //Данные противника
                            if(uStatus.tourStatus != 'EnemyEmpty' && uStatus.tourStatus != 'UserWinPlace_1' && uStatus.tourStatus != 'UserWinPlace_2' && uStatus.tourStatus != 'UserWinPlace_3' && uStatus.tourStatus != 'TourEndForUser' && uStatus.tourStatus != 'ShowConfirm' && uStatus.tourStatus != 'ResultError' && uStatus.tourStatus != 'WaitGroupEnd' ){
                                $('#uTour-2').show();
                                $('#uTour-3').show();
                            }
                        
                        //------> Cancel result
                            if(uStatus.tourStatus == 'EnemyEmpty' || uStatus.tourStatus == 'ResultError'){
                                $('#uTour-8').show(); 
                            }
                        
                            //Ввести результат пользователя
                            if(uStatus.tourStatus == 'UserResultEmpty')
                            {
                                $('#uTour-4').show();
                            }
                        
                            //Игроки группы
                            if(uStatus.tourUser.MoveTo_SE != 'y'){
                                $('#tBlock-data-round-type').html('Групповая стадия');  
                                $('#uTour-9').show();
                                if($('#uTour-9').html() == '')
                                {
                                    var type = 'tour';
                                    var mod = 'tourGetGroupEnemy';
                                    $.ajax({
                                        type: "POST", 
                                        url: "/ajax.php",
                                        data:{type:type, mod:mod},
                                        success: function(data){
                                            enemyGr = JSON.parse(data);
                                            var gN = new Array();
                                            var alphabet = new Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL');  
                                            for(j = 0; j <= 30; j++)
                                            {
                                                gN[j] = alphabet[j];
                                            }
                                            $('#uTour-9').append('<div class="unit-v3">Состав&nbsp;&nbsp;группы&nbsp;&nbsp;<b>"'+gN[uStatus.tourUser.r2]+'"</b></div>');      
                                            for(i= 0; i <= 3; i++)
                                            {
                $('#uTour-9').append('<div><div class="obj-uLogo"><img src="/uploads/avatars/'+enemyGr[i]['avatar']+'" class="img-circle"></div><a href="/user/profile/'+enemyGr[i]['username']+'" class="obj-uName">'+enemyGr[i]['username']+'</a></div>');
                                            }     
                                        },
                                    });  
                                }
                            }else{
                                $('#tBlock-data-round-type').html('Игра на выбывание');
                            }

                            $('.tournament-frame').slideDown(550, function() {  

                            });
                        
                    });
                },
            });
        }


        userTourStatus();


    /***********************
                        Accept Duel
                                ***********************/

    function accDuel(elem){
        $.post('/ajax.php', {type:'tour', mod:'accDuel'}, function(){
            $("#tBlock-data-confirm").hide();
            userTourStatus();
        }); 
    }


    /***********************
                        Set Result
                                ***********************/
    function SetTourneyResult(result, scoreEn, scoreMy){
        var type = 'tour';
        var mod = 'tourSetResult';
        $.ajax({
            type: "POST", 
            url: "/ajax.php",
            data:{type:type, mod:mod, result:result, scoreMy:scoreMy, scoreEn:scoreEn},
            success: function(data){
                userTourStatus(); 
            },
        });
    }
    function tourbtnrezMy(){
        $('#uTour-6-My').val('2');
        $('#uTour-6-En').val('1');
        $('#uTour-5').slideUp(600, function() {
             $('#uTour-6').slideDown(900); 
        });
    }
    function tourbtnrezEn(){
        $('#uTour-6-My').val('1');
        $('#uTour-6-En').val('2');
        $('#uTour-5').slideUp(600, function() {
             $('#uTour-6').slideDown(900); 
        });
    }  
    function delete_result(elem){
        $.post('/ajax.php', {type:'tour', mod:'delete_result'}, function(){
            $(elem).hide();
            userTourStatus();
        }); 
    }



// лучше вседелать потом на стороне сервера + проверки на BO
    function tourbtnscore(elem){
        var scoreMy = parseInt($('#uTour-6-My').val(),10);
        var scoreEn = parseInt($('#uTour-6-En').val(),10);
        
        if(scoreMy > scoreEn){
            var result = 'W';
        }
        if(scoreMy < scoreEn){
            var result = 'D';
        }
        $('#uTour-6').slideUp(800, function() {
            SetTourneyResult(result, scoreEn, scoreMy); 
        });
    }

    function tourBTNCancel(elem){
        $('#uTour-8').slideUp(500, function() {
            $.post('/ajax.php', {type:'tour', mod:'tourCancelResult'}, function(){
                eventSource.close();
                userTourStatus();    
            });
        });
    }




    /***********************
                       Tour Bracket page
                               ***********************/

    function ShowHideBracket(elem)
    {
        
        var lem = $(elem).parent().next();
        if($(lem).is(':visible'))
        {
            $(lem).slideToggle(400, function(response){
               $(elem).html('&nbsp;&nbsp;&nbsp;[развернуть]');
            });	  
            
        } else {
            
            $(lem).slideToggle(400, function(response){
               $(elem).html('&nbsp;&nbsp;&nbsp;[свернуть]');
            });	  

        }
    }

    function brackets_profile(elem){
        var name = $(elem).html();
        if(name == 'Free Slot'){
            return false;
        }
        window.open('/user/profile/'+name ,'_blank');
    }


    /***********************
                        Main Streamer
                                ***********************/

    function twitch_set_main_stream(elem){
        var error = new Array( 'Стример установлен', 'Канал не существует' );
        var answer = $(elem).parent().find('.dialog');
        var streamer = $(elem).parent().find('input').val();

        answer.slideUp(350, function(){
            $.getJSON("https://api.twitch.tv/kraken/channels/"+ streamer +".json?callback=?", function(response){
                response = JSON.stringify(response);
                response = jQuery.parseJSON(response);
                if(response._id > 0){
                    $.post('/ajax.php', {type:'tour', mod:'setTourMainStream', streamer:streamer}, function(){
                        answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350, function(){
                            setTimeout('pagerefresh()', 1000);
                        });
                    });      
                }else{
                    answer.removeClass().addClass("dialog dialog-danger").html(error[1]).slideDown(350); 
                }
            });	 
        }); 
    }

    function twitch_del_main_stream(elem){
        if($(elem).attr("class") == "unit-btn-green pointer"){
            $(elem).animate({width:'hide'},450, function(){
                $(elem).removeClass().addClass("unit-btn-red pointer");
                $(elem).prev().css("color", "#ea6153");
                $(elem).animate({width:'show'},450);
            });  
        }else{
            $(elem).parent().slideUp(450, function(){  
                var error = new Array( 'Основной стрим закрыт' );
                var answer = $(elem).parent().parent().parent().find('.dialog');
                $.post('/ajax.php', {type:'tour', mod:'delTourMainStream'}, function(){
                    answer.removeClass().addClass("dialog dialog-success").html(error[0]).slideDown(350, function(){
                        setTimeout('pagerefresh()', 1000);
                    });
                }); 
            });  
        } 
    }







    /***********************
                       PAGE READY!
                                ***********************/
    $( document ).ready(function() {
    //------> TWITCH LIVE
    
        function twitch_get_main_stream(){
            if(!document.getElementById('obj-twitch-live')){
                return false;
            }
            // ajax -> get live stream (add from admin)
            $.post('/ajax.php', {type:'tour', mod:'getTourMainStream'}, function(streamName){
                
                if(!streamName){
                    $('#obj-twitch-live').remove();
                    return false;   
                } else {
                    $('#obj-twitch-live').append('<div class="title-header"><h5>Основной стрим</h5><hr></div><div class="block"><div id="twitch_embed_player"></div></div>'); 
                    if(document.getElementById('chat-message')){
                        $('#chat-message').height('500');
                    }
                }
                //streamName = "turntheslayer"; // delete it
                var twitch_embed_player_width = $('#obj-twitch-live').width() - 10;
                var twitch_embed_player_height = twitch_embed_player_width / 1.55;
                $(function () {
                    window.onPlayerEvent = function (data){
                      data.forEach(function(event) {
                        if (event.event == "playerInit") {
                          var player = $("#twitch_embed_player")[0];
                          player.playVideo();
                        }
                      });
                    }
                    swfobject.embedSWF("//www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf", "twitch_embed_player", twitch_embed_player_width, twitch_embed_player_height, "11", null,
                      { "eventsCallback":"onPlayerEvent",
                        "embed":1,
                        "channel":streamName,
                        "auto_play":"true"},
                      { "allowScriptAccess":"always",
                        "allowFullScreen":"true"});
                });
            });  
        }
        twitch_get_main_stream();
        



        
        
        
        
        
        
        
        
        
        
        
    //------> VK Widget
        
        function loadVKcom()
        {
            if(!document.getElementById('vk_groups'))
            {
                return false;
            }
            var mode = $('#vk_groups').attr('name');
            mode=mode.split(':');
            VK.Widgets.Group("vk_groups", {mode: mode[0], width: "auto", height: mode[1], color1: 'FFFFFF', color2: '34495e', color3: 'bdc3c7'}, 77576704);
        }
        loadVKcom();
        
        function runStreams(){
            var type = 'user';
            var mod = 'streamers';
            if(!document.getElementById('stream-block-main')){
                return false;
            }
            $.ajax({
                type: "POST", 
                url: "/ajax.php",
                data:{type:type, mod:mod},
                success: function(data){
                    $.getJSON("https://api.twitch.tv/kraken/streams.json?channel="+data+"&callback=?", function(response){
                        response = JSON.stringify(response);
                        response = jQuery.parseJSON(response);
                            
                        if(response._total != 0)
                        {
                             $('#obj-twitch').show();
                        }

                        var count = 0;
                        while (count < Object.keys(response.streams).length){
                             var slink = response.streams[count].channel.url;
                             var sname = response.streams[count].channel.name;
                             var sview = response.streams[count].viewers;
                             var simg = response.streams[count].preview.small;
                             $('.stream-block').append('<div class="stream-block-channel"><div onclick="window.open(\''+slink+'\');"><div><a class="overlay stream-block-overlay"><div><div><span class="fui-link"></span></div></div></a><img src="'+simg+'" alt="Стрим '+sname+' на oFight.ru"></div><span>'+sname+'</span></div><div><span class="fui-eye"></span>&nbsp;&nbsp;'+sview+'</div></div>');

                             count++;
                        }
                    });	    
                },
            });  
            if(document.getElementsByClassName('stream-block-channel')){
                document.getElementById('stream-block-main').style.display="block";
                document.getElementById('stream-block-head').style.display="block";
            }
        }

    /***********************
                      Run on pages
                                ***********************/
        if(location.pathname.split("/")[1] == ''){ 
            runStreams();
        }

        if(location.pathname.split("/")[1] == 'chat'){ 
            runStreams();
        }
        
        if(location.pathname.split("/")[1] == 'user'){ 
               
        }
        
        if(location.pathname.split("/")[1] == 'tourney'){ 
            
            if($('#argBtag').is(':visible')){
                var type = 'user';
                var mod = 'userinfo';
                $.ajax({
                    type: "POST", 
                    url: "/ajax.php",
                    data:{type:type, mod:mod},
                    success: function(data){
                        data = JSON.parse(data);
                        $('#argBtag').val(data.bnettag);
                        $('#argVK').val(data.vkcom);
                    },
                }); 
            }
  
        }
        
        

        
        
        if(location.pathname.split("/")[1] == 'bracket'){ 
        
            function check_empty_bracket(group, name){
                function fs_count(group){ var fs_c = 0; for(k = 0; k < 4; k++){ if(group[k]['un'] == 'Free Slot'){ fs_c++; } } return fs_c;}
                fs_c = fs_count(group);
                var p_c = 0;
                for(k = 0; k < 4; k++){
                    if(group[k]['un'] != 'Free Slot'){
                        if(jQuery.inArray(group[k]['un'], name) !== -1){
                            p_c++;
                        }  
                    }
                }
                if( (fs_c < 3 && p_c == 2) || (fs_c == 3 && p_c == 1) || (fs_c == 4) ){
                    return '#bdc3c7';
                }
                return '#ECF0F1';
            }
       
            var minimalData = (function() {
                var type = 'tour';
                var mod = 'getBracket';
                var id = location.pathname.split("/")[2];
                var json = null;
                $.ajax({
                    type: "POST", 
                    async: false,
                    url: "/ajax.php",
                    data:{type:type, mod:mod, id:id},
                    success: function(data){
                        if(!data){
                            $('#tourBracket-inner').hide();
                        }
                        var data = JSON.parse(data);
                        if(data.tData){
                            if(data.group != null){
                                var gN = new Array();
                                var alphabet = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL');   
                                for(j = 0; j <= 30; j++){
                                    gN[j] = alphabet[j];
                                }
                                
                                for(i = 0; i < Object.keys(data.group).length; i++){
                                    color = check_empty_bracket(data.group[i], data.SE_Names);
                                    $('#tourBracket-group').append('<div class="tourBracket-gBlock"><p>Группа '+gN[i]+'</p><div><div style="background: '+color+'">'+data.group[i][0].un+'</div><div style="background: '+color+'">'+data.group[i][0].sc+'</div></div><div><div style="background: '+color+'">'+data.group[i][1].un+'</div><div style="background: '+color+'">'+data.group[i][1].sc+'</div></div><div><div style="background: '+color+'">'+data.group[i][2].un+'</div><div style="background: '+color+'">'+data.group[i][2].sc+'</div></div><div><div style="background: '+color+'">'+data.group[i][3].un+'</div><div style="background: '+color+'">'+data.group[i][3].sc+'</div></div></div>');
                                }
                                
                            } else {
                                $('.tourBracket-backet-title[name="groupStage"]').hide();
                            }                            
                            
                            

                            
                            $('#tourBracket-name').html(data.tData.tourname); 
                            $('#tourBracket-name').attr('href', '/tourney/'+data.tData.id);
                            $('#tourBracket-body').bracket({init: data.bracket});

                            
                            for(i = 1; i <= data.tData.tourrounds; i++){
                                if(i != data.tData.tourrounds){
                                    $('#tourBracket-body-head').append('<div>Раунд '+i+'</div>');
                                }else{
                                    $('#tourBracket-body-head').append('<div>Финал</div>');
                                }
                            }
                        }else{
                            $('#tourBracket-name').html('Этот турнир еще не начался'); 
                        }
                    }
                });
            })();

        }
        
        
        
    });



