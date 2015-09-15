<head>
    <meta charset="UTF-8">
    <title>Турниры на oFight.ru</title>
    <script type="text/javascript" src="/templates/Default/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/templates/Default/js/jquery.bracket.min.js"></script>
    <script type="text/javascript" src="/templates//Default/js/main.js"></script>
    <link rel="stylesheet" type="text/css" href="/templates/Default/css/jquery.bracket.min.css" />
    <link rel="shortcut icon" href="/uploads/sys/favicon.ico">
</head>
<body>
    <div class="tourBracket-head" style="background-image:url(/uploads/tourBracket-bg-1.jpg)">
       <div class="tourBracket-title"><a href="#" class="tourBracket-link" id="tourBracket-name">Генерация сетки участников после старта турнира</a></div>
       <div class="tourBracket-title-divider">&nbsp;</div>
       <div class="tourBracket-title"><a href="http://ofight.ru/" class="tourBracket-link">oFight Tournaments</a></div>
    </div>

    
    
    <div id="tourBracket-inner">
        <div class="tourBracket-backet-title" name="groupStage">Групповая стадия<a onclick="ShowHideBracket(this);">&nbsp;&nbsp;&nbsp;[свернуть]</a></div>
        <div>
            <div id="tourBracket-group"></div>  
        </div>
        <div class="tourBracket-backet-title">Сетка на выбывание</div>
        <div>
            <div id="tourBracket-body-head"></div>
            <div id="tourBracket-body"></div>
        </div>
    </div> 
</body>