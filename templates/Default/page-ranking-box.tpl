<div class="container">
<div class="row">

    <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="unit-head">TOP 50 игроков oFight</div>
        <div class="block unit">
            <table class="table unit-table unit-table-ranking">
                <thead>
                    <tr>
                        <th>Ранг</th>
                        <th>Аватар</th>
                        <th>Логин на портале</th>
                        <th>Победы</th>
                        <th>Поражения</th>
                    </tr>
                </thead>
                <tbody>
                    {RANKING}
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="unit-head">У каждого есть свой рейтинг</div>
        <div class="block unit">
            <img src="/uploads/sys/sys-2.jpg" class="img-responsive" alt="Рейтинг на портале oFight.ru">
            <div>
                <div class="unit-head-sm"><p>Посмотреть рейтинг конкретного игрока</p></div>
                <div class="unit-text-sm">Рейтинг по количеству побед и поражений на портале oFight</div>
                <div class="form-group">
                    <input id="getPlayerRanking_name" type="text" value="" required="" placeholder="&nbsp;&nbsp;Введите логин игрока на сайте" class="form-control input-sm">
                </div>
                <a class="btn btn-lg btn-block btn-primary button" onclick="getPlayerRanking(this);">Узнать рейтинг</a>
                <div class="dialog dialog-danger"></div>   
                <br>
                <div id="getPlayerRanking_block" style="display: none;">
                    <table class="table unit-table unit-table-ranking">
                        <thead>
                            <tr>
                                <th>Ранг</th>
                                <th>Аватар</th>
                                <th>Логин на портале</th>
                                <th>Победы</th>
                                <th>Поражения</th>
                            </tr>
                        </thead>
                        <tbody id="getPlayerRanking_data"></tbody>
                    </table>
                </div>
            </div>
        </div>
        
            <!-- Google adsense --> 
            <div class="hidden-xs">
                <div class="title-header"><h5>Рекламный блок</h5><hr></div>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-5681924169238083"
                     data-ad-slot="8369933052"
                     data-ad-format="auto"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        
    </div>
    
</div>
</div>
   
