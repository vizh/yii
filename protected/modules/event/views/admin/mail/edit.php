<?php
/**
 * @var \event\models\forms\admin\mail\Register $form
 * @var \event\models\Event $event
 * @var string $idMail
 * @var \application\components\controllers\AdminMainController $this
 * @var \application\widgets\ActiveForm $activeForm
 */

use application\helpers\Flash;

$clientScript = \Yii::app()->getClientScript();

$script = 'roles = ' . json_encode($form->getEventRoleData()) . ';';
if ($form->isUpdateMode()) {
    $script .= '
        $(function () {
        ';

    foreach ($form->getActiveRecord()->getRoles() as $role) {
        $script .= "EventMailEdit.createRoleLabel($role->Id, '$role->Title', 'Roles');";
    }
    foreach ($form->getActiveRecord()->getRolesExcept() as $role) {
        $script .= "EventMailEdit.createRoleLabel($role->Id, '$role->Title', 'RolesExcept');";
    }
    $script .= '});';
}
$clientScript->registerScript($this->getUniqueId(), $script, \CClientScript::POS_HEAD);
$clientScript->registerPackage('runetid.ckeditor');
$this->setPageTitle(\Yii::t('app', 'Редактирование регистрационного письма'));
?>

<div class="row-fluid">
    <?$activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['htmlOptions' => ['class' => 'form-horizontal']])?>
    <div class="btn-toolbar">
        <?=\CHtml::link('&larr; Вернуться к редактору мероприятия', ['edit/index', 'eventId' => $event->Id], ['class' => 'btn'])?>
        <?=\CHtml::link('&larr; Вернуться к списку писем', ['index', 'eventId' => $event->Id], ['class' => 'btn m-top_5'])?>
    </div>
    <div class="well">
        <?=$activeForm->errorSummary($form)?>
        <?=Flash::html()?>

        <div class="control-group">
            <?=$activeForm->label($form, 'Subject', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textField($form, 'Subject', ['class' => 'input-block-level'])?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'Roles', ['class' => 'control-label'])?>
            <div class="controls">
                <?=\CHtml::textField('RoleSearch', '', ['data-field' => 'Roles'])?>
                <p class="help-block roles"></p>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'RolesExcept', ['class' => 'control-label'])?>
            <div class="controls">
                <?=\CHtml::textField('RoleExceptSearch', '', ['data-field' => 'RolesExcept'])?>
                <p class="help-block rolesexcept"></p>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'Body', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->textArea($form, 'Body', ['class' => 'input-block-level'])?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'Layout', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->dropDownList($form, 'Layout', $form->getLayoutData())?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'SendPassbook', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->checkBox($form, 'SendPassbook')?>
            </div>
        </div>
        <div class="control-group">
            <?=$activeForm->label($form, 'SendTicket', ['class' => 'control-label'])?>
            <div class="controls">
                <?=$activeForm->checkBox($form, 'SendTicket')?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls clearfix">
                <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
				<a target="_blank" href="<?=$this->createUrl('view', ['idEvent' => $event->Id, 'idMail' => $idMail])?>" class="btn btn-dark-gray"><?=Yii::t('app', 'Просмотр')?></a>
                <?=$activeForm->submitButton($form, 'Delete', \Yii::t('app', 'Удалить'), ['class' => 'btn btn-danger pull-right', 'value' => 1])?>
            </div>
        </div>
        <div class="control-group muted">
            <div class="controls">
                <h4><?=\Yii::t('app', 'Доступный функционал Twig')?></h4>
                <ul>
					<li><b>{{user}}</b> - Пользователь. Например, {{user.shortName}}.</li>
					<li><b>{{event}}</b> - Мероприятие.</li>
					<li><b>http://some.host/?runetid={{user.RunetId}}&hash={{user|registrationHash('apiKey')}}</b></li>
				</ul>
                <h4><?=\Yii::t('app', 'Доступные поля')?></h4>
                <?=$form->getBodyFieldsNote()?>
            </div>
        </div>
    </div>
    <?$this->endWidget()?>
</div>