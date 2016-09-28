<?=\CHtml::form('','POST',array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data'))?>
<div class="btn-toolbar">
  <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-success'))?>
</div>
<div class="well">
  <div class="row-fluid">
    <?if(\Yii::app()->user->hasFlash('success')):?>
      <div class="alert alert-success"><?=\Yii::app()->user->getFlash('success')?></div>
    <?endif?>
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
    <div class="span6">
      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Title', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'Title', array('class' => 'input-block-level'))?>
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'SalaryFrom', array('placeholder' => $form->getAttributeLabel('SalaryFrom')))?> &mdash; <?=\CHtml::activeTextField($form, 'SalaryTo', array('placeholder' => $form->getAttributeLabel('SalaryTo')))?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Url', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'Url')?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Text', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeTextArea($form, 'Text', array('class' => 'input-block-level'))?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Company', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'Company')?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Category', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeDropDownList($form, 'Category', $form->getCategoryList(), array('class' => 'input-block-level'))?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Position', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'Position')?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Visible', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeCheckBox($form, 'Visible')?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'JobUp', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeCheckBox($form, 'JobUp')?>
          <div class="m-top_10 hide">
            <?=\CHtml::activeTextField($form, 'JobUpStartTime', array('class' => 'input-medium', 'placeholder' => $form->getAttributeLabel('JobUpStartTime')))?> &mdash; <?=\CHtml::activeTextField($form, 'JobUpEndTime', array('class' => 'input-medium', 'placeholder' => $form->getAttributeLabel('JobUpEndTime')))?>
            <p class="m-top_5 text-info">Формат: день.месяц.год часы:минуты</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<?=\CHtml::endForm()?>
