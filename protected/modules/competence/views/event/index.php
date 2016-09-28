<?php
/**
 * @var application\components\controllers\PublicMainController $this
 * @var Event $event
 * @var User $user
 * @var Test $test
 * @var CodeValidation $form
 * @var CActiveForm $activeForm
 */

use event\models\Event;
use user\models\User;
use competence\models\Test;
use competence\models\form\event\CodeValidation;

?>
<div class="container interview m-top_30 m-bottom_40">
    <div class="row">
        <div class="span8 offset2 m-top_30 text-center">
            <p class="lead">Здравствуйте!</p>
            <?if(!empty($test->Info)):?>
                <?=$test->Info?>
            <?php else:?>
                <p class="lead">
                    Спасибо за готовность оставить свое мнение о мероприятии, заполнив анкету участника <?=$event->Title?>.
                    Это займет у вас не более <nobr>5-ти</nobr> минут.
                </p>
            <?endif?>

            <?if($user === null):?>
                <?$activeForm = $this->createWidget('CActiveForm', ['htmlOptions' => ['class' => 'well m-bottom_30']])?>
                    <?=$activeForm->errorSummary($form, '<div class="alert alert-error">', '</div>')?>
                    <?=$activeForm->label($form, 'Code')?>
                    <?=$activeForm->textField($form, 'Code', ['class' => 'span6'])?>
                    <p class="muted">
                        <?if($event->IdName == 'devcon15'):?>
                            Для заполнения анкеты введите код, который напечатан на вашем бейдже.
                        <?php else:?>
                            Ссылка на анкету и код были отправлены в письме накануне мероприятия.<br/>
                            Если вы не получили письмо, узнать свой код для прохождения опроса можно на стойке регистрации.
                        <?endif?>
                    </p>
                    <div class="text-center m-top_30">
                        <?=CHtml::submitButton($test->StartButtonText, ['class' => 'btn btn-success'])?>
                    </div>
                <?php //$this->endWidget()?>
            <?php else:?>
                <div class="text-center m-top_30 m-bottom_30">
                    <?=CHtml::link($test->StartButtonText, ['process', 'eventIdName' => $event->IdName], ['class' => 'btn btn-success'])?>
                </div>
            <?endif?>
        </div>
    </div>
</div>