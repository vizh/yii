<?php
/**
 * @var \api\models\Account $account
 * @var \api\models\forms\admin\Account $form
 */
?>
<?=\CHtml::form('','POST', ['class' => 'form-horizontal'])?>
<?=\CHtml::activeHiddenField($form, 'Id')?>
<?=\CHtml::activeHiddenField($form, 'EventId')?>
<div class="btn-toolbar">
  <?if(!$account->getIsNewRecord()):?>
    <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
  <?endif?>
</div>

<div class="well">
  <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
  <?if(\Yii::app()->getUser()->hasFlash('success')):?>
    <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success')?></div>
  <?endif?>

  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'EventTitle', ['class' => 'control-label'])?>
    <div class="controls">
      <?=\CHtml::activeTextField($form, 'EventTitle', ['class' => 'input-xxlarge', 'readonly' => !$account->getIsNewRecord()])?>
    </div>
  </div>

  <?if(!$account->getIsNewRecord()):?>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Key', ['class' => 'control-label'])?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Key', ['readonly' => 'readonly'])?>
      </div>
    </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Secret', ['class' => 'control-label'])?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Secret', ['readonly' => 'readonly', 'class' => 'input-xlarge'])?>
      </div>
    </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Role', ['class' => 'control-label'])?>
      <div class="controls">
        <?=\CHtml::activeDropDownList($form, 'Role', $form->getRoles(), ['class' => 'input-xlarge'])?>
      </div>
    </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'RequestPhoneOnRegistration', ['class' => 'control-label'])?>
      <div class="controls">
        <?=\CHtml::activeDropDownList($form, 'RequestPhoneOnRegistration', $form->getRequestPhoneOnRegistrationStatusData(), ['class' => 'input-xlarge'])?>
      </div>
    </div>
    <div class="control-group domains">
      <?=\CHtml::activeLabel($form, 'Domains', ['class' => 'control-label'])?>
      <div class="controls">
        <button class="btn btn-mini" type="button"><?=\Yii::t('app', 'Добавить домен')?></button>
      </div>
    </div>
    <div class="control-group ips">
      <?=\CHtml::activeLabel($form, 'Ips', ['class' => 'control-label'])?>
      <div class="controls">
        <button class="btn btn-mini" type="button"><?=\Yii::t('app', 'Добавить IP адрес')?></button>
      </div>
    </div>
  <?else:?>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Role', ['class' => 'control-label'])?>
      <div class="controls">
        <?=\CHtml::activeDropDownList($form, 'Role', $form->getRoles(), ['class' => 'input-xlarge'])?>
      </div>
    </div>

    <div class="control-group" style="margin-bottom: 0;">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сгенерировать доступы'), ['class' => 'btn btn-success'])?>
      </div>
    </div>
  <?endif?>
</div>
<?=\CHtml::endForm()?>


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
  <div class="input-append m-bottom_5" style="display: block;">
    <input type="text" value="<%=value%>" class="input-xlarge" name="<?=\CHtml::activeName($form, 'Domains[]')?>"/>
    <button class="btn btn-danger" type="button"><i class="icon-remove icon-white"></i></button>
  </div>
</script>

<script type="text/template" id="ip-input-tpl">
  <div class="input-append m-bottom_5" style="display: block;">
    <input type="text" value="<%=value%>" class="input-xlarge" name="<?=\CHtml::activeName($form, 'Ips[]')?>"/>
    <button class="btn btn-danger" type="button"><i class="icon-remove icon-white"></i></button>
  </div>
</script>

