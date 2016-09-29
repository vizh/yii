<?php
/**
 * @var \event\widgets\Competence $this
 */
?>
<div class="alert alert-error">
  <p class="text-error">
    <?if(!isset($this->WidgetCompetenceErrorKeyMessage)):?>
      Не корректная ссылка. Свяжитесь с организаторами мероприятия.
    <?else:?>
      <?=$this->WidgetCompetenceErrorKeyMessage?>
    <?endif?>
  </p>
</div>