<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <div class="block">
                <div class="img-link">
                    <img src="{IMAGE}" class="img-responsive" alt="{TITLE}">
                </div>    
                <div class="news-info">Автор: {AUTHOR}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Дата: {DATE}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fui-eye"></span>&nbsp;&nbsp;{VIEWS}</div>
                
                <div class="social-btn-news"><script type="text/javascript">document.write(VK.Share.button(false,{type: "round", text: "Интересная статья"}));</script></div> 

                <div class="news-fl">
                    <!-- <h1>{TITLE}</h1> -->
                    
                    {FULLSTORY}
                    
                    
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-4">
           
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
           
            <div class="title-header"><h5>Коммент's</h5><hr></div>
            <div class="block news-cm">
                 
                [not-group=g]
                <table class="user-logo-table">
                    <tr>

                        <td>
                            <textarea name="" id="comment" placeholder="Напишите Ваш комментарий"></textarea>
                            <a class="button-native" onclick="addComment();">Добавить комментарий</a>
                            <input id="uname" type="hidden" value="{UNAME}">
                        </td>
                    </tr>
               </table>
               [/not-group]
                   
               <table id="comments" class="user-logo-table">
                    {COMMENTS}
               </table>
               
               
               
            </div>
        </div>
        </div>
    </div> 
</div> 




