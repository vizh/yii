<?php
/**
 * @var \user\models\User $user
 * @var Result $result
 * @var \event\models\Event $event
 *
 */

use competence\models\Result;
?>

<div class="container interview m-top_30 m-bottom_40 welcome">
    <div class="row">
        <div class="span8 offset2 m-top_30">
            <p class="lead text-center">Здравствуйте<?php if ($user !== null):?>, <?=$user->getShortName();?><?php endif;?>!</p>
            <p class="lead text-center">Спасибо за готовность оставить свое мнение о мероприятии, заполнив анкету участника и оценив доклады. Это займет у вас не более 5 минут.</p>
        </div>
    </div>
    <div class="row m-top_30 m-bottom_30 select-buttons">
        <div class="span4 offset2 text-center">
            <?php if ($result === null):?>
                <?=\CHtml::link('Заполнить анкету', ['/competence/event/index', 'eventIdName' => $event->IdName], ['class' => 'btn btn-large btn-success']);?>
            <?php else:?>
                 <p class="text-success">Анкета участника заполнена.</p>
            <?php endif;?>
        </div>
        <div class="span4 text-center">
            <a class="btn btn-large btn-success" href="http://www.msdevcon.ru/vote/">Оценить доклады</a>
        </div>
    </div>
</div>