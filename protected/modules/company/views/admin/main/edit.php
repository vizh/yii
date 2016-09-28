<?php
use application\helpers\Flash;

/**
 * @var \application\components\controllers\AdminMainController $this
 * @var \company\models\forms\admin\Company $form
 * @var \application\widgets\ActiveForm $activeForm
 */

\Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
$this->setPageTitle('Карточка компании');
?>
<?$activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['htmlOptions' => ['enctype' => 'multipart/form-data']])?>
<div class="btn-toolbar">
    <?=\CHtml::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
</div>
<div class="well">
    <div class="row-fluid">
        <div class="span12">
            <?=$activeForm->errorSummary($form)?>
            <?=Flash::html()?>

            <div class="control-group">
                <?=$activeForm->label($form, 'Name', ['class' => 'control-label'])?>
                <div class="controls">
                    <?=$activeForm->textField($form, 'Name')?>
                </div>
            </div>
            <div class="control-group">
                <?=$activeForm->label($form, 'FullName', ['class' => 'control-label'])?>
                <div class="controls">
                    <?=$activeForm->textField($form, 'FullName', ['class' => 'input-block-level'])?>
                </div>
            </div>
            <div class="control-group">
                <?=$activeForm->label($form, 'Info', ['class' => 'control-label'])?>
                <div class="controls">
                    <?=$activeForm->textArea($form, 'Info', ['class' => 'input-block-level'])?>
                </div>
            </div>
            <div class="control-group">
                <?=$activeForm->label($form, 'Code', ['class' => 'control-label'])?>
                <div class="controls">
                    <?=$activeForm->textField($form, 'Code')?>
                </div>
            </div>
            <div class="control-group">
                <?=$activeForm->label($form, 'Logo', ['class' => 'control-label'])?>
                <?if($form->isUpdateMode()):?>
                    <?=\CHtml::image($form->getActiveRecord()->getLogo()->get58px(),'',['class' => 'm-bottom_5'])?>
                <?endif?>
                <div class="controls">
                    <?=$activeForm->fileField($form, 'Logo')?>
                </div>
            </div>

            <hr/>
            <div class="row-fluid">
                <div class="span6">
                    <div class="control-group">
                        <?=$activeForm->label($form, 'Address', ['class' => 'control-label'])?>
                        <div class="controls">
                            <?$this->widget('\contact\widgets\AddressControls', ['form' => $form->Address])?>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="control-group">
                        <?=$activeForm->label($form, 'Url', ['class' => 'control-label'])?>
                        <div class="controls">
                            <?=$activeForm->textField($form, 'Url')?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?=$activeForm->label($form, 'Email', ['class' => 'control-label'])?>
                        <div class="controls">
                            <?=$activeForm->textField($form, 'Email')?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?=$activeForm->label($form, 'Phone', ['class' => 'control-label'])?>
                        <div class="controls">
                            <?$this->widget('\contact\widgets\PhoneControls', ['form' => $form->Phone])?>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div id="company-clusters">
                <h4><?=$form->getAttributeLabel('RaecClusters')?></h4>
                <?foreach($form->RaecClusters as $i => $id):?>
                    <?=$activeForm->dropDownList($form, "RaecClusters[$i]", $form->getClustersData())?>
                <?endforeach?>
                <div class="hide"><?=$activeForm->dropDownList($form, 'RaecClusters[]', $form->getClustersData())?> </div>
            </div>
            <?=\CHtml::button('Добавить', ['class' => 'btn btn-default', 'onclick' => "$('#company-clusters').append($('#company-clusters div.hide').html());"])?>

            <hr/>
            <div id="company-interests">
                <h4><?=$form->getAttributeLabel('ProfessionalInterests')?></h4>
                <div class="control-group">
                    <?=$activeForm->label($form, 'PrimaryProfessionalInterest', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=$activeForm->dropDownList($form, 'PrimaryProfessionalInterest', $form->getProfessionalInterestsData())?>
                    </div>
                </div>
                <?foreach($form->ProfessionalInterests as $i => $id):?>
                    <?=$activeForm->dropDownList($form, "ProfessionalInterests[$i]", $form->getProfessionalInterestsData())?>
                <?endforeach?>
                <div class="hide"><?=$activeForm->dropDownList($form, 'ProfessionalInterests[]', $form->getProfessionalInterestsData())?> </div>
            </div>
            <?=\CHtml::button('Добавить экосистему', ['class' => 'btn btn-default', 'onclick' => "$('#company-interests').append($('#company-interests div.hide').html());"])?>
            <hr/>

            <?if($form->isUpdateMode()):?>
                <h4><?=$form->getAttributeLabel('Moderators')?></h4>
                <?$this->renderPartial('edit/moderators', ['form' => $form, 'activeForm' => $activeForm])?>

                <hr/>
                <h4><?=$form->getAttributeLabel('RaecUsers')?></h4>
                <?$this->renderPartial('edit/raec-users', ['form' => $form, 'activeForm' => $activeForm])?>
            <?endif?>
        </div>
    </div>
</div>
<?$this->endWidget()?>

