<?php
use user\models\User;
use application\helpers\Flash;

/**
 * @var \application\components\controllers\AdminMainController $this
 * @var \company\models\forms\admin\Edit $form
 * @var \application\widgets\ActiveForm $activeForm
 */

$this->setPageTitle('Карточка компании');
?>
<?php $activeForm = $this->beginWidget('\application\widgets\ActiveForm');?>
<div class="btn-toolbar">
    <?=\CHtml::submitButton('Сохранить', ['class' => 'btn btn-success']);?>
</div>
<div class="well">
    <div class="row-fluid">
        <div class="span12">
            <?=$activeForm->errorSummary($form);?>
            <?=Flash::html();?>

            <div class="control-group">
                <?=$activeForm->label($form, 'Name', ['class' => 'control-label']);?>
                <div class="controls">
                    <?=$activeForm->textField($form, 'Name');?>
                </div>
            </div>
            <div class="control-group">
                <?=$activeForm->label($form, 'FullName', ['class' => 'control-label']);?>
                <div class="controls">
                    <?=$activeForm->textField($form, 'FullName', ['class' => 'input-block-level']);?>
                </div>
            </div>
            <div class="control-group">
                <?=$activeForm->label($form, 'Url', ['class' => 'control-label']);?>
                <div class="controls">
                    <?=$activeForm->textField($form, 'Url');?>
                </div>
            </div>
            <div class="control-group">
                <?=$activeForm->label($form, 'Logo', ['class' => 'control-label']);?>
                <div class="controls">
                    <?=$activeForm->fileField($form, 'Logo');?>
                </div>
            </div>
            <hr/>
            <?php if ($form->isUpdateMode()):?>
                <h4><?=$form->getAttributeLabel('Moderators');?></h4>
                <?php $this->renderPartial('edit/moderators', ['form' => $form, 'activeForm' => $activeForm]);?>

                <hr/>
                <h4><?=$form->getAttributeLabel('RaecUsers');?></h4>
                <?php $this->renderPartial('edit/raec-users', ['form' => $form, 'activeForm' => $activeForm]);?>
            <?php endif;?>
        </div>
    </div>
</div>
<?php $this->endWidget();?>

