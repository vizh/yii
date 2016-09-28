<?php
use partner\components\Controller;
use application\widgets\ActiveForm;

/**
 * @var Controller $this
 */
?>
<?$this->setPageTitle('Добавление/редактирование участника мероприятия')?>
<?$activeForm = $this->beginWidget(ActiveForm::className())?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-pencil"></i> <?=\Yii::t('app', 'Редактирование участника')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=$activeForm->errorSummary($form)?>
        <div class="form-group">
            <?$this->widget('zii.widgets.jui.CJuiAutoComplete', [
                'model' => $form,
                'attribute' => 'Label',
                'source' => '/ajax/users',
                'options'=> [
                    'minLength' => '2',
                    'select' => 'js:function (event, ui) {
                        window.location.href = "/user/edit/?id=" + ui.item.value;
                    }'
                ],
                'htmlOptions' => [
                    'id' => 'Edit_Label',
                    'class' => 'form-control',
                    'placeholder' => $form->getAttributeLabel('Label')
                ],
                'scriptFile' => false,
                'cssFile' => false
            ])?>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Продолжить'), ['class' => 'btn btn-primary'])?>
    </div>
</div>
<?$this->endWidget()?>
