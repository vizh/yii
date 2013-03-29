<?php
/**
 * @var $this \event\widgets\Contacts
 * @var $phones string[]
 */
$address = $this->event->getContactAddress();
$emailFlag = false;
$site = $this->event->getContactSite();
?>

<div class="contacts">
  <h5 class="title"><?=\Yii::t('app', 'Контактная информация')?></h5>
  <p class="name"><?=$this->event->Title;?></p>
  <?if ($address !== null):?>
  <p class="address"><?=$address;?></p>
  <?endif;?>
  <?if (!empty($phones)):?>
  <p class="telephone">
    <strong><?=implode('</strong><br><strong>', $phones);?></strong>
  </p>
  <?endif;?>
  <p class="email">
    <?foreach ($this->event->LinkEmails as $linkEmail):?>
      <?=$emailFlag ? '<br>':''?>
      <a href="mailto:<?=$linkEmail->Email->Email;?>"><?=$linkEmail->Email->Email;?></a>
      <?$emailFlag = true;?>
    <?endforeach;?>
  </p>
  <?if ($site != null):?>
  <p class="url">
    <a target="_blank" href="<?=$site;?>"><?=trim($site->Url,' /');?></a>
  </p>
  <?endif;?>
</div>
