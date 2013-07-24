<div class="btn-toolbar"></div>
<div class="well">
  <?=$widget->getAdminPanel()->errorSummary('<div class="alert alert-error">', '</div>');?>
  <?if ($widget->getAdminPanel()->hasSuccess()):?>
    <div class="alert alert-success"><?=$widget->getAdminPanel()->getSuccess();?></div>
  <?endif;?>
  
  <?=$widget->getAdminPanel();?>
</div>