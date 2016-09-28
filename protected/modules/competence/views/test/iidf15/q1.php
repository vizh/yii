<?php
/**
 *  @var Q1 $form
 */

use competence\models\test\iidf15\Q1;
?>
<?=\CHtml::errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
<div class="form-group">
    <label class="col-sm-2 control-label"><?=\Yii::t('app', 'Email')?></label>
    <div class="col-sm-10">
        <?=\CHtml::activeTextField($form, 'value', ['class' => 'form-control'])?>
    </div>
</div>
