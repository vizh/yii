<?php

/**
 * @var \application\components\controllers\AdminMainController $this
 * @var Account $account
 * @var \api\models\forms\admin\Account $form
 */

use api\models\Account;

$isNewRecord = $account->getIsNewRecord();

?>

<?=CHtml::form('','POST', ['class' => 'form-horizontal'])?>
    <?=CHtml::activeHiddenField($form, 'Id')?>
    <?=CHtml::activeHiddenField($form, 'EventId')?>
    <div class="btn-toolbar">
        <?if(!$isNewRecord):?>
            <?=CHtml::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
        <?endif?>
    </div>

    <div class="well">
        <?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
        <?if(Yii::app()->getUser()->hasFlash('success')):?>
            <div class="alert alert-success"><?=Yii::app()->getUser()->getFlash('success')?></div>
        <?endif?>

        <?if(!$isNewRecord):?>
            <div class="control-group">
                <?=CHtml::activeLabel($form, 'Blocked', ['class' => 'control-label'])?>
                <div class="controls">
                    <?=CHtml::activeCheckBox($form, 'Blocked', ['class' => 'input-xlarge'])?>
                    <?=$form->Blocked ? $form->BlockedReason : ''?>
                </div>
            </div>
        <?endif?>
        <div class="control-group">
            <?=CHtml::activeLabel($form, 'EventTitle', ['class' => 'control-label'])?>
            <div class="controls">
                <?=CHtml::activeTextField($form, 'EventTitle', ['class' => 'input-block-level', 'readonly' => !$isNewRecord])?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span8">
                <?if(!$isNewRecord):?>
                    <div class="control-group">
                        <?=CHtml::activeLabel($form, 'Key', ['class' => 'control-label'])?>
                        <div class="controls">
                            <?=CHtml::activeTextField($form, 'Key', ['class' => 'input-block-level', 'readonly' => 'readonly'])?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?=CHtml::activeLabel($form, 'Secret', ['class' => 'control-label'])?>
                        <div class="controls">
                            <?=CHtml::activeTextField($form, 'Secret', ['class' => 'input-block-level', 'readonly' => 'readonly'])?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?=CHtml::activeLabel($form, 'Role', ['class' => 'control-label'])?>
                        <div class="controls">
                            <?=CHtml::activeDropDownList($form, 'Role', $form->getRoles(), ['class' => 'input-block-level'])?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?=CHtml::activeLabel($form, 'RequestPhoneOnRegistration', ['class' => 'control-label'])?>
                        <div class="controls">
                            <?=CHtml::activeDropDownList($form, 'RequestPhoneOnRegistration', $form->getRequestPhoneOnRegistrationStatusData(), ['class' => 'input-block-level'])?>
                        </div>
                    </div>
                    <?if($form->Role === Account::ROLE_PARTNER_WOC):?>
                        <div class="control-group">
                            <?=CHtml::activeLabel($form, 'QuotaByUser', ['class' => 'control-label'])?>
                            <div class="controls">
                                <?=CHtml::activeTextField($form, 'QuotaByUser', ['class' => 'input-block-level'])?>
                                <?=$form->QuotaByUserCounter;?>
                            </div>
                        </div>
                    <?endif?>
                <?else:?>
                    <div class="control-group">
                        <?=CHtml::activeLabel($form, 'Role', ['class' => 'control-label'])?>
                        <div class="controls">
                            <?=CHtml::activeDropDownList($form, 'Role', $form->getRoles(), ['class' => 'input-block-level'])?>
                        </div>
                    </div>

                    <div class="control-group" style="margin-bottom: 0;">
                        <div class="controls">
                            <?=CHtml::submitButton(Yii::t('app', 'Сгенерировать доступы'), ['class' => 'btn btn-success'])?>
                        </div>
                    </div>
                <?endif?>
            </div>
            <div class="span4">
                <?=CHtml::activeTextArea($form, 'Comment', [
                    'class' => 'input-block-level',
                    'placeholder' => $form->getAttributeLabel('Comment'),
                    'style' => 'height:180px;margin:0'
                ])?>
            </div>
        </div>
        <?if(!$isNewRecord):?>
            <div class="control-group domains">
                <?=CHtml::activeLabel($form, 'Domains', ['class' => 'control-label'])?>
                <div class="controls">
                    <button class="btn btn-mini" type="button"><?=Yii::t('app', 'Добавить домен')?></button>
                </div>
            </div>
            <div class="control-group ips">
                <?=CHtml::activeLabel($form, 'Ips', ['class' => 'control-label'])?>
                <div class="controls">
                    <button class="btn btn-mini" type="button"><?=Yii::t('app', 'Добавить IP адрес')?></button>
                </div>
            </div>
        <?endif?>
    </div>
<?=CHtml::endForm()?>

<script type="text/javascript">
    domains = [];
    <?foreach($form->Domains as $domain):?>
        domains.push('<?=$domain?>');
    <?endforeach?>

    ips = [];
    <?foreach($form->Ips as $ip):?>
        ips.push('<?=$ip?>');
    <?endforeach?>
</script>

<script type="text/template" id="domain-input-tpl">
    <div class="input-append m-bottom_5" style="display:block">
        <input type="text" value="<%=value%>" class="input-xlarge" name="<?=CHtml::activeName($form, 'Domains[]')?>"/>
        <button class="btn btn-danger" type="button"><i class="icon-remove icon-white"></i></button>
    </div>
</script>

<script type="text/template" id="ip-input-tpl">
    <div class="input-append m-bottom_5" style="display: block;">
        <input type="text" value="<%=value%>" class="input-xlarge" name="<?=CHtml::activeName($form, 'Ips[]')?>"/>
        <button class="btn btn-danger" type="button"><i class="icon-remove icon-white"></i></button>
    </div>
</script>

