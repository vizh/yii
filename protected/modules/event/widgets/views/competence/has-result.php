<?php
/**
 * @var \event\widgets\Competence $this
 */
?>
<div class="alert alert-success">
    <?if (!isset($this->WidgetCompetenceHasResultMessage)):?>
        Спасибо, ваш отзыв очень важен для нас!
    <?else:?>
        <?=$this->WidgetCompetenceHasResultMessage;?>
    <?endif;?>
</div>