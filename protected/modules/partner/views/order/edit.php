<?
/**
 * @var \partner\components\Controller $this
 * @var \pay\models\Order $order
 * @var \pay\models\forms\Juridical $form
 * @var \pay\models\Product[] $products
 * @var CActiveForm $activeForm
 */

use application\helpers\Flash;
$this->setPageTitle(\Yii::t('app', 'Редактирование счета') . ' №' . $order->Id);
?>

<?php $activeForm = $this->beginWidget('CActiveForm');?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-pencil"></span> <?=\Yii::t('app', 'Редактирование счета');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>');?>
        <?=Flash::html();?>
        <?$this->renderPartial('edit/juridical', ['activeForm' => $activeForm, 'form' => $form]);?>
        <hr/>
        <?$this->renderPartial('edit/items', ['products' => $products]);?>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']);?>
    </div>
</div>
<?php $this->endWidget();?>