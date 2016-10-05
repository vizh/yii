<?php
/**
 * @var \application\components\controllers\PublicMainController $this
 * @var Event $event
 * @var User $user
 * @var Test $test
 */
use event\models\Event;
use user\models\User;
use competence\models\Test;

//TODO: Костыль разлогинивания для тестов msdevtour
if (strpos($test->Code, 'devcon') === 0) {
    /** @var CWebUser $user */
    if (\Yii::app()->user->getCurrentUser() !== null) {
        $user = \Yii::app()->user;
    }
    elseif (\Yii::app()->tempUser->getCurrentUser() !== null) {
        $user = \Yii::app()->tempUser;
    }

    if (!$user->getIsGuest()) {
        $user->logout();
    }

    \Yii::app()->getClientScript()->registerMetaTag(
        '10; url='.$this->createUrl('index', ['eventIdName' => $event->IdName]),
        null,
        'refresh'
    );
}
?>
<div class="container interview m-top_30 m-bottom_40">
    <div class="row">
        <div class="span8 offset2 m-top_30 text-center">
            <?if(!empty($test->AfterEndText)):?>
                <?=$test->AfterEndText?>
            <?else:?>
                <p class="lead"><strong>Спасибо, ваш отзыв очень важен для нас!</strong></p>
            <?endif?>
        </div>
    </div>
</div>
