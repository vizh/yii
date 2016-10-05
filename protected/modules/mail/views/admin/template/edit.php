<?php
/**
 * @var \application\components\controllers\AdminMainController $this
 * @var mail\models\forms\admin\Template $form
 * @var \application\widgets\ActiveForm $activeForm
 */

use mail\models\forms\admin\Template;
use application\helpers\Flash;

$clientScript = \Yii::app()->getClientScript();

$js = 'TemplateEdit.roles = ' . json_encode($form->getEventRolesData()) . ';';
foreach ($form->Conditions as $condition) {
    switch ($condition['by']) {
        case Template::ByEvent:
            $js .= 'TemplateEdit.createEventCriteria(' . json_encode($condition) . ');';
            break;
        case Template::ByEmail:
            $js .= 'TemplateEdit.createEmailCriteria(' . json_encode($condition) . ');';
            break;
        case Template::ByRunetId:
            $js .= 'TemplateEdit.createRunetIdCriteria(' . json_encode($condition) . ');';
            break;
        case Template::ByGeo:
            $js .= 'TemplateEdit.createGeoCriteria(' . json_encode($condition) . ');';
            break;
    }
}
if ($form->getActiveRecord() !== null && $form->getActiveRecord()->Active) {
    $js .= '$("form.form-horizontal input, form.form-horizontal textarea, form.form-horizontal select").attr("disabled", "disabled");';
}
$clientScript->registerScript('edit', $js);
$clientScript->registerPackage('runetid.backbone');
$clientScript->registerPackage('runetid.ckeditor');

$template = $form->getActiveRecord();

$this->setPageTitle('Рассылка');
?>
<?$activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['htmlOptions' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']])?>
    <div class="btn-toolbar">
        <?=CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
    </div>
    <div class="well">
        <?=Flash::html()?>
        <?=$activeForm->errorSummary($form, '<div class="alert alert-error">')?>

        <?=$this->renderPartial('edit/count', ['form' => $form])?>

        <h3><?=\Yii::t('app', 'Параметры рассылки')?></h3>

        <div class="control-group">
            <?=$activeForm->label($form, 'Title', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Title', ['class' => 'span4'])?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'Subject', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Subject', ['class' => 'span4'])?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'From', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'From', ['class' => 'span4'])?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'FromName', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'FromName', ['class' => 'span4'])?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'MailerClass', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->dropDownList($form, 'MailerClass', $form->getMailServices(), ['class' => 'span4'])?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'SendPassbook', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->checkBox($form, 'SendPassbook')?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'SendUnsubscribe', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->checkBox($form, 'SendUnsubscribe')?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'SendUnverified', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->checkBox($form, 'SendUnverified')?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'ShowUnsubscribeLink', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->checkBox($form, 'ShowUnsubscribeLink')?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'ShowFooter', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->checkBox($form, 'ShowFooter')?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'SendInvisible', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->checkBox($form, 'SendInvisible')?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'RelatedEventId', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'RelatedEventId')?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'Layout', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->dropDownList($form, 'Layout', $form->getLayoutData())?>
            </div>
        </div>

        <?$this->renderPartial('edit/attachments', ['form' => $form, 'activeForm' => $activeForm])?>

        <div class="control-group">
            <?=$activeForm->label($form, 'Body', ['class' => 'control-label'])?>
            <div class="controls">
                <?if(!$form->isUpdateMode() || !$template->checkViewExternalChanges()):?>
                    <?=$activeForm->textArea($form, 'Body', ['class' => 'input-block-level', 'style' => 'height: 500px;'])?>
                    <p class="m-top_10 muted">
                        <?foreach($form->bodyFieldLabels() as $field => $label):?>
                            <?=$field?> &mdash; <?=$label?><br/>
                        <?endforeach?>
                    </p>
                <?else:?>
                    <div class="alert alert-info" style="margin: 0;">Шаблон письма притерпел внешние изменения. Отредактируйте его через PHP редактор. Путь к шаблону: <?=$template->getViewPath()?></div>
                <?endif?>
            </div>
        </div>

        <?=$activeForm->hiddenField($form, 'Active', ['value' => (int)$form->Active])?>
        <?if($form->Active == 0):?>
            <div class="control-group m-top_40">
                <?=$activeForm->label($form, 'Active', ['class' => 'control-label text-error'])?>
                <div class="controls">
                    <input type="checkbox" id="confirm-template"/>
                    <p class="m-top_5 text-error">Внимание после активации внести изменения<br/> в рассылку будет невозможно!</p>
                    <?=$activeForm->submitButton($form, 'Active', 'Запустить рассылку', ['class' => 'btn btn-success', 'disabled' => 'disabled', 'value' => 1])?>
                </div>
            </div>

            <?if($form->isUpdateMode()):?>
                <div class="control-group m-top_40">
                    <?=$activeForm->label($form, 'Test', ['class' => 'control-label'])?>
                    <div class="controls">
                        <?=$activeForm->textField($form, 'TestUsers')?>
                        <?=$activeForm->submitButton($form, 'Test', 'Отправить тест', ['class' => 'btn btn-info', 'value' => 1])?>
                    </div>
                </div>
            <?endif?>
        <?endif?>

        <h3>Выборка</h3>
        <?foreach($form->getConditionData() as $key => $value):?>
            <button name="" data-by="<?=$key?>" class="btn add-criteria-btn" type="button">
                <i class="icon-plus"></i> <?=$value?>
            </button>
        <?endforeach?>
        <div id="filter">
            <?=$activeForm->hiddenField($form, 'Conditions', ['value' => ''])?>
        </div>

        <?$this->renderPartial('edit/templates', ['form' => $form, 'activeForm' => $activeForm])?>
    </div>
<?$this->endWidget()?>

<?if($template && $template->Success):?>
    <section>
        <?=Html::beginForm(['rollback', 'id' => $template->Id])?>
            <?=Html::submitButton('Откатить', [
                'class' => 'btn btn-danger'
            ])?>
        <?=Html::endForm()?>
    </section>
<?endif?>
