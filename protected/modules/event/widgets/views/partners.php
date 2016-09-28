<?php
/**
 * @var $this \event\widgets\Partners
 * @var $partners \event\models\Partner[]
 */

if (empty($partners))
{
  return;
}
?>

<div class="partners">
  <div class="title">
    <span class="backing"><?=\Yii::t('app', 'Партнеры мероприятия')?></span>
  </div>
  <div class="logos units"><?
    foreach ($partners as $partner):
     ?><div class="logo unit">
        <a target="_blank" href="<?=$partner->Company->Url?>">
          <img src="<?=$partner->Company->getLogoForEvent()?>" alt="">
        </a>
      </div><?
    endforeach;
   ?></div>
</div>
