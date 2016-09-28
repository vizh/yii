<div class="btn-toolbar">
  <a href="<?=$this->createUrl('/event/admin/edit/index', ['eventId' => $widget->getEvent()->Id])?>" class="btn"><i class="icon-arrow-left"></i> <?=\Yii::t('app', 'Назад')?></a>
</div>
<div class="well">
  <?=$widget->getAdminPanel()->errorSummary('<div class="alert alert-error">', '</div>')?>
  <?if($widget->getAdminPanel()->hasSuccess()):?>
    <div class="alert alert-success"><?=$widget->getAdminPanel()->getSuccess()?></div>
  <?endif?>

  <?=$widget->getAdminPanel()->render()?>
</div>