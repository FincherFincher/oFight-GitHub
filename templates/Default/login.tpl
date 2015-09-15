[not-group=g]
    <li><a href="">{login}</a></li>
    <li><span class="vertical-divider"></span></li>
    <li class="user-dropdown dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Личный кабинет<b class="caret"></b></a>
        <span class="dropdown-arrow"></span>
        <ul class="dropdown-menu">
            <li><a href="/user/profile">Личный кабинет</a></li>
[/not-group] 

[group=a]  
            <li><a href="/user/CreateTourney">Создание турниров</a></li>
            <li><a href="/user/AdminTourney">Проведение турниров</a></li>   
[/group]   
   
[group=s]  
            <li><a href="/user/Admin">Администрация</a></li>
            <li><a href="/user/CreateTourney">Создание турнира</a></li>
            <li><a href="/user/AdminTourney">Проведение турниров</a></li>   
            <li><a href="/user/ModerationTourney">Модерация турниров</a></li> 
            <li><a href="/user/CreateNews">Создание новости</a></li> 
            <li><a href="/user/ModerNews">Модерация новостей</a></li> 
[/group]  
                 
[group=n]  
            <li><a href="/user/CreateNews">Создание новости</a></li> 
[/group]              
                 
                 
            <!--<<li><a href="/user">Создание новостей</a></li>
            <li><a href="/user">Модерация новостей</a></li>-->
            
[not-group=g]
            <li class="divider"></li>
            <li><a href="?do=logout">Выход</a></li>
        </ul>
    </li>
  <!-- <li><a href="/user"><span class="visible-sm visible-xs">Settings<span class="fui-gear"></span></span><span class="visible-md visible-lg"><span class="fui-gear"></span></span></a></li>-->

[/not-group]

[group=g]
<li><a href="" data-toggle="modal" data-target="#myModal_1">Войти&nbsp;</a></li><li><span class="vertical-divider"></span></li><li><span class="v-divider"></span></li><li><a href="" data-toggle="modal" data-target="#myModal_2">&nbsp;Регистрация</a></li>
[/group]