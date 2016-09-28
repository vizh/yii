<?php
/**
 * @var \event\widgets\Competence $this
 */
?>
<div class="alert alert-error">
  <p class="text-error">
    <?if(!isset($this->WidgetCompetenceHasResultMessage)):?>
      Данная ссылка уже использована ранее.
    <?else:?>
      <?=$this->WidgetCompetenceHasResultMessage?>
    <?endif?>
  </p>
</div>