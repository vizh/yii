<?php
/**
 * @var \partner\components\Controller $this
 * @var \api\models\Account $account
 * @var \application\widgets\ActiveForm $activeForm
 * @var \partner\models\forms\settings\ApiAccount $form
 */

use application\helpers\Flash;

/** @var \CClientScript $clientScript */
$clientScript = \Yii::app()->getClientScript();
$clientScript->registerPackage('angular');
$clientScript->registerScript('init', '
    new CApiSettings(' . json_encode($form->getAttributes()) . ');
', \CClientScript::POS_HEAD);

$this->setPageTitle('API');
?>
<?$activeForm = $this->beginWidget('\application\widgets\ActiveForm', ['htmlOptions' => ['class' => 'form-horizontal']])?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-bolt"></i> <?=\Yii::t('app', 'API доступы')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body" ng-controller="ApiSettingsController">
        <?=Flash::html()?>
        <?=$activeForm->errorSummary($form)?>
        <div class="row form-group">
            <label class="col-sm-2 control-label">KEY:</label>
            <div class="col-sm-8">
                <?=\CHtml::textField('key', $account->Key, ['class' => 'form-control', 'readonly' => 'readonly'])?>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-sm-2 control-label">SECRET:</label>
            <div class="col-sm-8">
                <?=\CHtml::textField('key', $account->Secret, ['class' => 'form-control', 'readonly' => 'readonly'])?>
            </div>
        </div>
        <div class="row form-group">
            <?=$activeForm->label($form, 'Domains', ['class' => 'col-sm-2 control-label'])?>
            <div class="col-sm-8">
                <div ng-repeat="domain in domains" class="input-group" style="margin-bottom: 5px;">
                    <?=$activeForm->textField($form, 'Domains[]', ['value' => '{{domain.domain}}', 'class' => 'form-control'])?>
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button" ng-click="removeDomain($index)"><span class="fa fa-times"></span></button>
                    </span>
                </div>
                <?=\CHtml::button(\Yii::t('app', 'Добавить домен'), ['class' => 'btn btn-default', 'ng-click' => 'addDomain()'])?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <div class="row form-group">
            <div class="col-sm-8 col-sm-offset-2">
                <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary'])?>
            </div>
        </div>
    </div>
</div>
<?$this->endWidget()?>


<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-users"></i> <?=\Yii::t('app', 'Виджет регистрации')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <pre><span style='color:#808030; '>&lt;</span>script src<span style='color:#808030; '>=</span><span style='color:#800000; '>"</span><span style='color:#0000e6; '>//<?=RUNETID_HOST?>/javascripts/widget.js</span><span style='color:#800000; '>"</span><span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>script<span style='color:#808030; '>></span><br/><span style='color:#808030; '>&lt;</span>div <span style='color:#800000; font-weight:bold; '>class</span><span style='color:#808030; '>=</span><span style='color:#800000; '>"</span><span style='color:#0000e6; '>rid-widget</span><span style='color:#800000; '>"</span> data<span style='color:#808030; '>-</span>widget<span style='color:#808030; '>=</span><span style='color:#800000; '>"</span><span style='color:#0000e6; '>registration</span><span style='color:#800000; '>"</span> data<span style='color:#808030; '>-</span>apikey<span style='color:#808030; '>=</span><span style='color:#800000; '>"</span><span style='color:#0000e6; '><?=$account->Key?></span><span style='color:#800000; '>"</span><span style='color:#808030; '>></span><span style='color:#808030; '>&lt;</span><span style='color:#808030; '>/</span>div<span style='color:#808030; '>></span></pre>
        <hr/>
        <script src="//<?=RUNETID_HOST?>/javascripts/widget.js"></script>
        <div class="rid-widget" data-widget="registration" data-apikey="<?=$account->Key?>"></div>
    </div>
</div>