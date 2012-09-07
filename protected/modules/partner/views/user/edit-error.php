<div class="span12">
  <?if (!empty($this->action->error)):?>
  <div class="alert alert-error">
    <button data-dismiss="alert" class="close">×</button>
    <strong>Ошибка!</strong> <?=$this->action->error;?>
  </div>
  <?endif;?>
</div>