<?php
/**
 * @var $form \pay\models\forms\Juridical
 * @var $this JuridicalController
 */
?>

<section id="section" role="main">
  <div class="container m-top_40">
    <div class="row">
      <div class="offset2 span8">

        <h3><?=Yii::t('app', 'Выставление счета');?></h3>
        <p><?=Yii::t('app', 'Пожалуйста, внимательно заполните реквизиты компании, которая будет оплачивать ваше участие. Указанные вами данные будут использованы в выставляемом счете.');?></p>
        <p><?=Yii::t('app', 'Документы на оплату будут созданы автоматически, без проверки корректности реквизитов.');?></p>

        <?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>

        <?=CHtml::beginForm('', 'POST', array('class' => 'form-inline m-top_20 m-bottom_60'));?>

          <div class="control-group">
              <?= CHtml::activeLabel($form, 'Name', array('class' => 'control-label')); ?>
              <div class="controls">
                  <?= CHtml::activeTextField($form, 'Name', array('class' => 'span8')); ?>
                  <span class="help-inline">Полное наименование организации, включая организационно-правовую форму предприятия</span>
              </div>
          </div>
          <div class="control-group">
              <?= CHtml::activeLabel($form, 'Address', array('class' => 'control-label')); ?>
              <div class="controls">
                  <?= CHtml::activeTextArea($form, 'Address', array('class' => 'span8')); ?>
                  <span class="help-inline">Например: 123056, г. Москва, ул. Б. Грузинская, д. 42, ком. 12</span>
              </div>
          </div>
          <div class="control-group">
              <?=CHtml::activeLabel($form, 'PostAddress', array('class' => 'control-label'));?>
              <div class="controls">
                  <?=CHtml::activeTextArea($form, 'PostAddress', array('class' => 'span8'));?>
                  <span class="help-inline">Например: 123056, г. Москва, ул. Б. Грузинская, д. 42, ком. 12</span>
              </div>
          </div>

          <div class="row-fluid">
              <div class="span6">
                  <div class="control-group">
                      <?=CHtml::activeLabel($form, 'INN', array('class' => 'control-label'));?>
                      <div class="controls">
                          <?=CHtml::activeTextField($form, 'INN', array('class' => 'span12'));?>
                          <span class="help-inline">10 или 12 цифр, зависит от организационной формы</span>
                      </div>
                  </div>
              </div>
              <div class="span6">
                  <div class="control-group">
                      <?=CHtml::activeLabel($form, 'KPP', array('class' => 'control-label'));?>
                      <div class="controls">
                          <?=CHtml::activeTextField($form, 'KPP', array('class' => 'span12'));?>
                          <span class="help-inline">9 цифр, если имеется</span>
                      </div>
                  </div>
              </div>
          </div>

          <div class="control-group">
              <?= CHtml::activeLabel($form, 'Phone', array('class' => 'control-label')); ?>
              <div class="controls">
                  <?= CHtml::activeTextField($form, 'Phone', array('class' => 'span4')); ?>
                  <span class="help-inline">Формат: +7 (xxx) xxx-xx-xx</span>
              </div>
          </div>

          <div class="form-actions">
              <a class="btn" href="<?= $this->createUrl('/pay/cabinet/index'); ?>">
                  <?= \Yii::t('app', 'Отменить'); ?>
              </a>
              <a id="order_submit" class="btn btn-info pull-right" href=""><?= \Yii::t('app', 'Выставить счет') ?></a>
          </div>

        <?php echo CHtml::endForm();?>

      </div>
    </div>
  </div>


</section>
