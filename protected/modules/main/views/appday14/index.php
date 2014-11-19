<?php
/**
 * @var CodeValidation $form
 */
use main\models\forms\CodeValidation;

?>
<div class="container interview m-top_30 m-bottom_40">
    <div class="row">
        <div class="span8 offset2 m-top_30">
            <p class="lead text-center">Здравствуйте!</p>
            <p class="lead text-center">Спасибо за&nbsp;готовность оставить свое мнение о&nbsp;мероприятии, заполнив анкету участника Russian App Day и оценив доклады. Это займет у&nbsp;вас не&nbsp;более 5&nbsp;минут.</p>
            <p class="lead text-center" style="font-weight: 500;">После заполнения анкеты вы&nbsp;получите отличную возможность выиграть одну из&nbsp;последних моделей смартфона Nokia Lumia&nbsp;&mdash; внимательно слушайте объявления по&nbsp;громкоговорящей связи, каждый час мы&nbsp;будем анонсировать победителя!</p>


            <?=CHtml::beginForm(Yii::app()->createUrl('/main/appday14/index'), 'post');?>

            <?=CHtml::errorSummary($form, null, null, ['class' => 'alert alert-error']);?>
            <?=CHtml::activeLabel($form, 'code');?>
            <?=CHtml::activeTextField($form, 'code', ['class' => 'span6']);?>
            <p class="muted">
                Ссылка на анкету и код были отправлены в письме накануне мероприятия. Если вы не получили письмо, узнать свой код для прохождения опроса можно на стойке регистрации.
            </p>

            <div class="text-center m-top_30 m-bottom_30">
                <button class="btn btn-success" type="submit">Продолжить</button>
            </div>

            <?CHtml::endForm();?>
        </div>
    </div>
</div>



