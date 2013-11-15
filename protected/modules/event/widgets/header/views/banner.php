<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>
<?if (isset($this->HeaderBannerStyles)):?>
<style type="text/css">
  <?=$this->HeaderBannerStyles;?>
</style>
<?endif;?>
<div class="b-event-promo <?=$event->IdName;?>" style="background: <?if (isset($this->HeaderBannerBackgroundImagePath)):?>url('<?=$this->HeaderBannerBackgroundImagePath;?>') repeat-x<?endif;?> #<?=$this->HeaderBannerBackgroundColor;?>">
  <div class="container" style="background: url('<?=$this->HeaderBannerImagePath;?>') no-repeat center center; padding: 0; height: <?=$this->HeaderBannerHeight;?>px">
    <div class="row">
      <div class="span12"></div>
    </div>
    <?if ($this->eventPage):?>
      <span class="all">
        <a href="<?=Yii::app()->createUrl('/event/list/index');?>"><?=Yii::t('app', 'Все мероприятия');?></a>
      </span>
    <?endif;?>
  </div>
</div>