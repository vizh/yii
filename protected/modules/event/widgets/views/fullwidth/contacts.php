<?php
/**
 * @var $this \event\widgets\Contacts
 * @var $phones string[]
 */
?>

<div class="contacts">
  <header>
    <h3 class="title">Контакты</h3>
  </header>
  <article>
    <?foreach ($phones as $phone):?>
      <span class="phone"><?=$phone;?></span>
    <?endforeach;?>
    <?foreach ($this->event->LinkEmails as $link):?>
      <a href="mailto: <?=$link->Email->Email;?>" class="email"><?=$link->Email->Email;?></a>
    <?endforeach;?>
  </article>
</div>