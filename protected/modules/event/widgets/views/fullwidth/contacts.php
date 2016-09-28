<?php
/**
 * @var event\widgets\Contacts $this
 * @var string[] $phones
 */

$emails = [];
foreach ($this->event->LinkEmails as $link) {
    $emails[] = CHtml::mailto($link->Email->Email, '', ['class' => 'email']);
}
?>

<div class="contacts">
    <header>
        <h3 class="title"><?=\Yii::t('app', 'Контакты')?></h3>
    </header>
    <article>
        <?if($this->event->getContactAddress() !== null):?>
            <p class="address"><?=$this->event->getContactAddress()?></p>
        <?endif?>

        <?if(!empty($phones)):?>
            <span class="header">Тел.:</span>
            <?foreach($phones as $phone):?>
                <span class="phone"><?=$phone?></span>
            <?endforeach?>
            <br><br>
        <?endif?>

        <?if(!empty($this->event->LinkEmails)):?>
            <span class="header">Email:</span>
            <?=implode(', ', $emails)?>
            <br><br>
        <?endif?>

        <?if($this->event->LinkSite):?>
            <span class="site">Официальный сайт проекта: <?=CHtml::link($this->event->LinkSite->Site, $this->event->LinkSite->Site)?></span>
        <?endif?>
    </article>
</div>