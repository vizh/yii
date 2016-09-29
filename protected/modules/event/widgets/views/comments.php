<?php
/**
 * @var \event\widgets\Comments $this
 */
?>
<div class="comments m-top_20">
    <h4><?=\Yii::t('app', 'Комментарии пользователей')?></h4>

    <div class="b-comments">
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/<?=Yii::app()->language == 'en' ? 'en_US' : 'ru_RU'?>/sdk.js#xfbml=1&version=v2.5&appId=201234113248910";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-comments"
             data-href="<?=Yii::app()->createAbsoluteUrl('/event/view/index', ['idName' => $this->event->IdName])?>"
             data-width="580" data-num-posts="20"></div>
    </div>
</div>

