<?php
/**
 * @var \application\components\controllers\PublicMainController $this
 * @var Event $event
 * @var Test $test
 */
use event\models\Event;
use competence\models\Test;
?>
<div class="container interview m-top_30 m-bottom_40">
    <div class="row">
        <div class="span8 offset2 m-top_30 text-center">
            <?if(!empty($test->BeforeText)):?>
                <?=$test->BeforeText?>
            <?else:?>
                <p class="lead">Здравствуйте!</p>
                <p class="lead">Вы немного поторопились &mdash; заполнить анкету участника можно будет с <?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy с HH:mm', $test->StartTime)?>.</p>
            <?endif?>
        </div>
    </div>
</div>