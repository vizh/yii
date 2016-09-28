<?php
/**
 *  @var Q2 $form
 */

use \competence\models\test\iidf15\Q2;
?>
<?=\CHtml::errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
<div class="form-group">
    <label class="col-sm-2 control-label"><?=\Yii::t('app', 'Имя Фамилия')?></label>
    <div class="col-sm-10">
        <?=\CHtml::activeTextField($form, 'value', ['class' => 'form-control'])?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"><?=\Yii::t('app', 'Телефон')?></label>
    <div class="col-sm-10">
        <?=\CHtml::activeTextField($form, 'valuePhone', ['class' => 'form-control'])?>
    </div>
</div>
