<?php
/**
 * @var \user\models\User $user
 */
use main\models\forms\CodeValidation;

?>
<div class="container interview m-top_30 m-bottom_40">
    <div class="row">
        <div class="span8 offset2 m-top_30">
            <p class="lead text-center">Здравствуйте, <?=$user->getShortName();?>!</p>
            <p class="lead text-center">Спасибо за&nbsp;готовность оставить свое мнение о&nbsp;мероприятии, заполнив анкету участника Russian App Day и оценив доклады. Это займет у&nbsp;вас не&nbsp;более 5&nbsp;минут.</p>
            <p class="lead text-center" style="font-weight: 500;">После заполнения анкеты вы&nbsp;получите отличную возможность выиграть одну из&nbsp;последних моделей смартфона Nokia Lumia&nbsp;&mdash; внимательно слушайте объявления по&nbsp;громкоговорящей связи, каждый час мы&nbsp;будем анонсировать победителя!</p>
        </div>
    </div>

    <div class="row m-top_30 m-bottom_30">
        <div class="span4 offset2 text-center">
            <a class="btn btn-large btn-success" href="<?=Yii::app()->createUrl('/main/appday14/form');?>">Заполнить анкету</a>
        </div>
        <div class="span4 text-center">
            <a class="btn btn-large btn-success" href="">Оценить доклады</a>
        </div>
    </div>
</div>