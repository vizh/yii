<?php
/**
 * @var \CController $this
 * @var \CActiveForm $activeForm
 * @var string $view
 * @var \user\models\forms\document\ForeignPassport $form
 */

?>

<?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>

<?$this->renderPartial($view, ['form' => $form, 'activeForm' => $activeForm])?>

<div class="form-footer">
    <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-info'])?>
</div>

