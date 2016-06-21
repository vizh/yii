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
        <h3 class="title"><?= \Yii::t('app', 'Контакты'); ?></h3>
    </header>
    <article>
        <?php if ($this->event->getContactAddress() !== null): ?>
            <p class="address"><?= $this->event->getContactAddress() ?></p>
        <?php endif ?>

        <?php if (!empty($phones)): ?>
            <span class="header">Тел.:</span>
            <?php foreach ($phones as $phone): ?>
                <span class="phone"><?=$phone?></span>
            <?php endforeach ?>
            <br><br>
        <?php endif ?>

        <?php if (!empty($this->event->LinkEmails)): ?>
            <span class="header">Email:</span>
            <?=implode(', ', $emails)?>
            <br><br>
        <?php endif ?>

        <?php if ($this->event->LinkSite): ?>
            <span class="site">Официальный сайт проекта: <?=CHtml::link($this->event->LinkSite->Site, $this->event->LinkSite->Site)?></span>
        <?php endif ?>
    </article>
</div>