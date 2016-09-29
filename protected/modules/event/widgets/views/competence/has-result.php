<?php
/**
 * @var \event\widgets\Competence $this
 */
?>
<div class="registration registration-success">
    <h3 class="text-success text-center">
        <?if(!isset($this->WidgetCompetenceHasResultMessage)):?>
           <?=\Yii::t('app', 'Спасибо, ваш отзыв очень важен для нас!')?>
        <?else:?>
            <?=$this->WidgetCompetenceHasResultMessage?>
        <?endif?>
    </h3>
</div>