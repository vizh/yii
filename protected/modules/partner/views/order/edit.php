<?php
/**
 * @var partner\components\Controller $this
 * @var pay\models\forms\Juridical $form
 * @var application\widgets\ActiveForm $activeForm
 */

use application\helpers\Flash;

$this->setPageTitle($form->isUpdateMode() ? (\Yii::t('app', 'Редактирование счета') . ' №' . $form->getOrder()->Number) : \Yii::t('app', 'Создание счета'));

$clientScript = \Yii::app()->getClientScript();
$clientScript->registerScript('init', '
    new COrderEdit(' . $form->getUser()->RunetId . ',' . ($form->getOrder() !== null ? $form->getOrder()->Id : 'undefined') . ');',
    \CClientScript::POS_HEAD
);
?>

<?$activeForm = $this->beginWidget('application\widgets\ActiveForm')?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><span class="fa fa-pencil"></span> <?=\Yii::t('app', 'Реквизиты счета')?></span>
        </div>
        <div class="panel-body" ng-controller="OrderEditController">
            <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
            <?=Flash::html()?>

            <?$this->renderPartial('edit/juridical', ['activeForm' => $activeForm, 'form' => $form])?>
            <hr>
            <?$this->renderPartial('edit/items', ['form' => $form])?>

        </div>
        <div class="panel-footer">
            <?=CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary'])?>
        </div>
    </div>
<?$this->endWidget()?>