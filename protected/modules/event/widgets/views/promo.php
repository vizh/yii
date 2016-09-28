<?php
/**
 * @var \event\widgets\Promo $this
 * @var \event\models\Event $event
 */

use application\components\utility\Texts;
?>
<div class="event_widget_Promo <?=$event->IdName?>">
    <div class="container">
        <div class="row units events">
            <div class="unit span12 event">
                <header>
                    <img src="<?=$event->getLogo()->get120px()?>" alt="" class="logo">
                    <p class="muted">
                        <small><?=$event->Type->Title?></small>
                    </p>
                    <h2 class="date">
                        <?$this->widget('\event\widgets\Date', ['event' => $event])?>
                    </h2>
                    <h2 class="title">
                        <?=\CHtml::link($event->Title, $event->getUrl())?>
                    </h2>
                    <?if($event->getContactAddress() !== null):?>
                        <small class="muted"><?=$event->getContactAddress()?></small>
                    <?endif?>
                </header>
                <article><p><?=Texts::cropText($event->Info, \Yii::app()->params['EventPreviewLength'])?></p></article>
                <footer>
                    <?if($this->isCurrentUserParticipant):?>
                        <?=\CHtml::link(\Yii::t('app', 'Вы уже зарегистрированы'), $event->getUrl(), ['class' => 'btn disabled', 'disabled' => 'disabled'])?>
                    <?php elseif (isset($event->Free) && $event->Free):?>
                        <?=\CHtml::link(\Yii::t('app', 'Регистрация бесплатна'), $event->getUrl(), ['class' => 'btn btn-large btn-info', 'disabled' => 'disabled'])?>
                    <?endif?>

                    <?if(!empty($event->PayAccount)):?>
                        <p class="muted"><small><?=\Yii::t('app', 'Регистрация через RUNET-ID')?></small></p>
                    <?endif?>
                </footer>
            </div>
        </div>
    </div>
</div>
