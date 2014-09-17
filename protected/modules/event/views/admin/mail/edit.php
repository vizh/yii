<script type="text/javascript">
  roles = <?=json_encode($form->getEventRoleData());?>;
  $(function () {
    <?foreach ($mail->getRoles() as $role):?>
      EventMailEdit.createRoleLabel(<?=$role->Id;?>, '<?=$role->Title;?>', 'Roles');
    <?endforeach;?>

    <?foreach ($mail->getRolesExcept() as $role):?>
      EventMailEdit.createRoleLabel(<?=$role->Id;?>, '<?=$role->Title;?>', 'RolesExcept')
    <?endforeach;?>
  });
</script>

<div class="row-fluid">
  <?=\CHtml::beginForm('','POST', ['class' => 'form-horizontal']);?>
  <div class="btn-toolbar">
    <a href="<?=$this->createUrl('/event/admin/edit/index', ['eventId' => $event->Id]);?>" class="btn">&larr; <?=\Yii::t('app','Вернуться к редактору мероприятия');?></a><br/>
    <a href="<?=$this->createUrl('/event/admin/mail/index', ['eventId' => $event->Id]);?>" class="btn m-top_5">&larr; <?=\Yii::t('app','Вернуться к списку писем');?></a>
  </div>
  <div class="well">
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
    <?if (\Yii::app()->getUser()->hasFlash('success')):?>
      <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
    <?endif;?>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Subject', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Subject', ['class' => 'input-block-level']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Roles', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::textField('RoleSearch','',['data-field' => 'Roles']);?>
        <p class="help-block roles"></p>
      </div>
    </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'RolesExcept', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::textField('RoleExceptSearch', '', ['data-field' => 'RolesExcept']);?>
        <p class="help-block rolesexcept"></p>
      </div>
    </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Body', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextArea($form, 'Body', ['class' => 'input-block-level']);?>
      </div>
    </div>
      <div class="control-group">
          <?=\CHtml::activeLabel($form, 'Layout', ['class' => 'control-label']);?>
          <div class="controls">
              <?=\CHtml::activeDropDownList($form, 'Layout', $form->getLayoutData());?>
          </div>
      </div>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'SendPassbook', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeCheckBox($form, 'SendPassbook');?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls clearfix">
        <button type="submit" class="btn btn-success"><?=\Yii::t('app', 'Сохранить');?></button>
        <button type="submit" name="<?=\CHtml::activeName($form, 'Delete');?>" value="1" class="btn btn-danger pull-right"><?=\Yii::t('app', 'Удалить');?></button>
      </div>
    </div>
    <div class="control-group muted">
      <div class="controls">
        <h4><?=\Yii::t('app', 'Доступные поля');?></h4>
        <?foreach($fields as $field):?>
          <?=$field;?> &mdash; <?=$this->getAction()->getFieldLabel($field);?><br/>
        <?endforeach;?>
      </div>
    </div>
  </div>
  <?=\CHtml::endForm();?>
</div>