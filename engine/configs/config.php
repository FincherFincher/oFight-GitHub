<?php

    $config = array(
        'sitename' => '',
        'dbprefix' => '',
        
        
        
        
        
        
    /***********************
              Статус турнира
                                ***********************/
        'tourStatus' => array(
                            'started' => '<div class="cell tstatus-live">LIVE!</div>',
                            'pregPass' => '<div class="cell tstatus-succ"><span class="fui-check"></span></div>',
                            'pregOpen' => '<div class="cell tstatus-open"><span class="fui-plus"></span></div>',
                            'fregPass' => '<div class="cell tstatus-succ"><span class="fui-check"></span></div>',
                            'fregOpen' => '<div class="cell tstatus-succ"><span class="fui-time"></span></div>'
                        ),
        
        
        
        
        
        
        
    /***********************
            Турнирные иконки
                                ***********************/
        'tourGameicon' => array(
                            'Hearthstone' => '<img src="/uploads/icon-hearthstone.png" class="img-responsive" alt="Hearthstone турнир">'
                        ),
        
        
        
        
        
        
        
        
    /***********************
            Турнирные моды
                                ***********************/
        'tourmod' => array(

                            'Olympia' => 'Игры по олимпийской системе, сетка формата "single elimination"',
                            'Spartan' => 'Игроки начинают в группах по 4 участника, двое из которых выходят в "play off"'
                        ),
        
        
        
        
        
        
        
        
        
        
        
        
    /***********************
            Турнирные иконки
                                ***********************/
        'profile' => array(
                            'statspersonal' => array(
                                            'statspersonal' => '                    
                                                            <!-- add battle.net tag -->                                             
                                                            <div class="unit-v1">
                                                                <span class="fa fa-pencil-square-o fa-fw"></span>
                                                                <span>Battle.net</span>
                                                                <span class="unit-btn-green pointer" onclick="userAttr(this, bnettag);" name="close">&nbsp;&nbsp;&nbsp;Обновить&nbsp;&nbsp;&nbsp;</span>
                                                                <div class="unit-v1-cancel pointer" style="display:none;" onclick="PP_attr_cancel(this, "Обновить")"><span class="fui-cross"></span></div>
                                                            </div>                                                               
                                                                <!-- show/hide -->
                                                                <div style="display:none;">                                                                         
                                                                    <div class="form-group">
                                                                        <input type="text" value="{BTAG}" required="" placeholder="&nbsp;&nbsp;Введите Battle.net tag" class="form-control input-sm">
                                                                    </div>
                                                                    <div class="dialog dialog-danger"></div>                                                                                          
                                                                </div> 
                                                         '
                            ),
                            'statsother' => array(
                                            'Hearthstone' => '<img src="/uploads/icon-hearthstone.png" class="img-responsive" alt="Hearthstone турнир">'
                            )
                        ),
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    /***********************
            Статус сраницы турнир
                                ***********************/
        'tourPageStatus' => array(
                                    'started' => '
                                                    <div class="unit-v4 unit-err">
                                                        <div class="unit-v1">
                                                            <span class="fa fa-power-off fa-fw"></span>
                                                            <span>Турнир начался</span>
                                                        </div>
                                                    </div>
                                                 ',

                                    'pregOpen' => '
                                                    <div class="unit-v4 unit-rdy">
                                                        <div class="unit-v1">
                                                            <span class="fa fa-check-square-o fa-fw"></span> 
                                                            <span>Записаться на турнир</span>
                                                        </div>
                                                    </div> 
                                                  ',

                                    'pregPass' => '
                                                    <div class="unit-v4 unit-suc">
                                                        <div class="unit-v1">
                                                            <span class="fa fa-check-square fa-fw"></span>
                                                            <span>Записаны, ждем к началу</span>
                                                        </div>
                                                    </div>
                                                  ',

                                    'fregOpen' => ' 
                                                    <div class="unit-v4 unit-rdy">
                                                        <div class="unit-v1">
                                                            <span class="fa fa-check-square-o fa-fw"></span>
                                                            <span>Регистрация на турнир</span>
                                                        </div>
                                                    </div>
                                                  ',
                                    'fregPass' => '
                                                    <div class="unit-v4 unit-suc">
                                                        <div class="unit-v1">
                                                            <span class="fa fa-check-square fa-fw"></span>
                                                            <span>Регистрация пройдена</span>
                                                        </div>
                                                    </div>
                                                  '
                        ),
        
        
        
        
        
    /***********************
      Опции статуса сраницы турнир
                                ***********************/
        'tourPageStatusOption' => array(
                                'started' => '',
                                'pregOpen' => '<a class="btn btn-lg btn-block btn-primary button" onclick="tourPreRegistration(this);">Предварительная запись</a>',
                                'pregPass' => '',
                                'fregOpen' => array(
                                                    'Regular' => ' '
                                                ),
                                'fregPass' => ''
                        ),
        
        
        
        
        
        
        
        
        
    );
?>