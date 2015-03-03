<?php
/**
 * @var $this \event\widgets\Contacts
 * @var $phones string[]
 */
?>

<div class="contacts">
    <header>
        <h3 class="title"><?=\Yii::t('app', 'Контакты');?></h3>
    </header>
    <article>
        <?if ($this->event->getContactAddress() !== null):?>
            <p class="address"><?=$this->event->getContactAddress();?></p>
        <?endif;?>
        <?foreach ($phones as $phone):?>
            <span class="phone"><?=$phone;?></span>
        <?endforeach;?>
        <?foreach ($this->event->LinkEmails as $link):?>
            <a href="mailto: <?=$link->Email->Email;?>" class="email"><?=$link->Email->Email;?></a>
        <?endforeach;?>
    </article>
</div>