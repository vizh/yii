<?php
/**
 * @var \event\models\section\Section $section
 * @var \partner\models\forms\program\Participant $form
 */
?>
<h2 class="m-bottom_30"><?=\Yii::t('app','Участники секции');?> "<a href="<?=$this->createUrl('/partner/program/section', array('sectionId' => $section->Id));?>"><?=$section->Title;?></a>"</h2>
<h4 class="m-bottom_40"><?=\Yii::t('app', 'Новый участник');?></h4>
<?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
<?if (\Yii::app()->user->hasFlash('success')):?>
  <div class="alert alert-success"><?=\Yii::app()->user->getFlash('success');?></div>
<?endif;?>
<div class="row">
  <div class="span12">
    <?=\CHtml::form('', 'POST', array('class' => 'form-horizontal'));?>

    <?$this->renderPartial('participants-select', ['form' => $form]);?>

    <div class="control-group">
      <?=\CHtml::activeLabel($form, 'Role', array('class' => 'control-label'));?>
      <div class="controls">
        <?=\CHtml::activeDropDownList($form, 'RoleId', \CHtml::listData(\event\models\section\Role::model()->findAll(), 'Id', 'Title'));?>
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app', 'Добавить'), array('class' => 'btn btn-info'));?>
      </div>
    </div>
    <?=\CHtml::endForm();?>
  </div>
</div>


<?if (!empty($section->LinkUsers)):?>
  <h4 class="m-bottom_40"><?=\Yii::t('app', 'Список участников');?></h4>
  <?foreach ($section->LinkUsers as $link):?>
    <div class="row m-bottom_40 section-participant">
      <div class="span12">
        <?$form = new \partner\models\forms\program\Participant($link);?>
        <?=\CHtml::form('', 'POST', array('class' => 'form-horizontal'));?>

        <?$this->renderPartial('participants-select', ['form' => $form]);?>

        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'Role', array('class' => 'control-label'));?>
          <div class="controls">
            <?=\CHtml::activeDropDownList($form, 'RoleId', \CHtml::listData(\event\models\section\Role::model()->findAll(), 'Id', 'Title'));?>
          </div>
        </div>

        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'ReportTitle', ['class' => 'control-label']);?>
          <div class="controls">
            <?=\CHtml::activeTextField($form, 'ReportTitle');?>
          </div>
        </div>

        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'ReportThesis', ['class' => 'control-label']);?>
          <div class="controls">
            <?=\CHtml::activeTextArea($form, 'ReportThesis', ['class' => 'span9']);?>
          </div>
        </div>

        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'ReportUrl', ['class' => 'control-label']);?>
          <div class="controls">
            <?=\CHtml::activeTextField($form, 'ReportUrl', ['class' => 'span9']);?>
          </div>
        </div>

        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'VideoUrl', ['class' => 'control-label']);?>
          <div class="controls">
            <?=\CHtml::activeTextField($form, 'VideoUrl', ['class' => 'span9']);?>
          </div>
        </div>

        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'ReportFullInfo', ['class' => 'control-label']);?>
          <div class="controls">
            <?=\CHtml::activeTextArea($form, 'ReportFullInfo',  ['class' => 'span9']);?>
          </div>
        </div>
        <div class="control-group">
          <?if ($link->Report !== null && !empty($link->Report->Url)):?>
            <div class="controls m-top_10">
              <a href="<?=$link->Report->Url;?>"><?=\Yii::t('app', 'Скачать презентацию');?></a>
            </div>
          <?endif;?>
        </div>
        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'Delete', array('class' => 'control-label'));?>
          <div class="controls">
            <?=\CHtml::activeCheckBox($form, 'Delete', array('uncheckValue' => null));?>
          </div>
        </div>
        <div class="control-group">
          <?=\CHtml::activeLabel($form, 'Order', array('class' => 'control-label'));?>
          <div class="controls">
            <?=CHtml::activeTextField($form, 'Order', ['class' => 'input-mini']);?>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить изменения'), array('class' => 'btn btn-info'));?>
          </div>
        </div>
        <?=\CHtml::activeHiddenField($form, 'Id');?>
        <?=\CHtml::endForm();?>
      </div>
    </div>
  <? endforeach; ?>
<?endif;?>
