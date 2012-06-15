<div class="row">
  <div class="span16">
    <h1>Работа со счетами и заказами юридических лиц</h1>
  </div>

  <div class="span16">
    <?if (!empty($this->Error)):?>
    <div class="alert-message error">
      <p><strong>Возникла ошибка!</strong> <?=$this->Error;?></p>
    </div>
    <?elseif (! empty($this->Result)):?>
    <div class="alert-message success">
      <p><strong>Выполнено!</strong> <br> <?=$this->Result;?></p>
    </div>
    <?endif;?>
    </div>

  <?php echo $this->Step;?>
</div>