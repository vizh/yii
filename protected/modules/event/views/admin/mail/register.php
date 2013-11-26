<div class="row-fluid">
  <?=\CHtml::beginForm('','POST', ['class' => 'form-horizontal']);?>
  <div class="btn-toolbar">
    <a href="<?=$this->createUrl('/event/admin/edit/index', ['eventId' => $event->Id]);?>" class="btn">&larr; <?=\Yii::t('app','Вернуться к редактору мероприятия');?></a>
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
      <?=\CHtml::activeLabel($form, 'Body', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextArea($form, 'Body', ['class' => 'input-block-level', 'style' => 'height: 500px']);?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
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