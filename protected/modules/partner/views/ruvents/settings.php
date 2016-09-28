<?php
/**
 * @var \partner\components\Controller $this
 * @var \partner\models\forms\ruvents\Settings $form
 * @var CActiveForm $activeForm
 */
use application\helpers\Flash;
$this->setPageTitle(\Yii::t('app', 'Настройки клиента'));
?>
<?$activeForm = $this->beginWidget('CActiveForm')?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-cog"></i> Дополнительные атрибуты</span>
        </div>
        <div class="panel-body">
            <?=Flash::html()?>
            <?=$activeForm->errorSummary($form, '<div class="alert alert-danger">', '</div>')?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?=$activeForm->label($form, 'AvailableUserData')?>
                        <?$this->widget('\partner\widgets\ui\MultiSelect', [
                            'model' => $form,
                            'attribute' => 'AvailableUserData',
                            'items' => $form->getDefinitionData()
                        ])?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?=$activeForm->label($form, 'EditableUserData')?>
                        <?$this->widget('\partner\widgets\ui\MultiSelect', [
                            'model' => $form,
                            'attribute' => 'EditableUserData',
                            'items' => $form->getDefinitionData()
                        ])?>
                    </div>
                </div>
            </div>
        </div> <!-- / .panel-body -->
        <div class="panel-footer">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary'])?>
        </div>
    </div>
<?$this->endWidget()?>