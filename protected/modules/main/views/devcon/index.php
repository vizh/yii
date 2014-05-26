<?php
/**
 * @var \user\models\User $user
 * @var string $code
 */
?>
<div class="container interview m-top_30 m-bottom_40">
    <div class="row">
        <div class="span8 offset2 m-top_30 text-center">
            <p class="lead">Уважаемый <?=$user->FirstName;?>, спасибо за&nbsp;готовность оставить свое мнение о&nbsp;мероприятии, заполнив анкету участника DevCon 2014. Это займет у&nbsp;вас не&nbsp;более <nobr>5-ти</nobr> минут.</p>
            <p class="lead">После заполнения анкеты вы&nbsp;можете смело подойти на&nbsp;стойку &laquo;Информация&raquo; в&nbsp;<nobr>Конгресс-холле</nobr> и&nbsp;получить приз.</p>

            <div class="text-center m-top_30 m-bottom_30">
                <a href="<?=Yii::app()->createUrl('/main/devcon/process', ['code' => $code]);?>" class="btn btn-success" type="submit">Заполнить анкету</a>
            </div>
        </div>
    </div>
</div>