<?php
/**
 * @var $this \event\widgets\Contacts
 * @var $phones string[]
 */
$address = $this->event->getContactAddress();
$emailFlag = false;
$site = $this->event->getContactSite();
?>

<div class="contacts-fullwidth">
  <h5 class="title"><?=\Yii::t('app', 'Контактная информация')?></h5>

  <div class="row">
    <div class="span12">
      <?if ($address !== null):?>
        <p class="address"><?=$address;?></p>
      <?endif;?>
    </div>
  </div>

  <div class="row m-bottom_20 m-top_10">
    <div class="span3 offset2">
      <?if ($site != null):?>
        <p class="url">
          <a target="_blank" href="<?=$site;?>"><?=trim($site->Url,' /');?></a>
        </p>
      <?endif;?>
    </div>

    <div class="span3">
      <?if (!empty($this->event->LinkEmails)):?>
        <p>
          <?foreach ($this->event->LinkEmails as $linkEmail):?>
            <?=$emailFlag ? '<br>':''?>
            <a href="mailto:<?=$linkEmail->Email->Email;?>"><?=$linkEmail->Email->Email;?></a>
            <?$emailFlag = true;?>
          <?endforeach;?>
        </p>
      <?endif;?>
    </div>

    <div class="span3">
      <?if (!empty($phones)):?>
        <p class="telephone">
          <strong><?=implode('</strong><br><strong>', $phones);?></strong>
        </p>
      <?endif;?>
    </div>
  </div>
</div>
