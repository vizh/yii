<?php
/**
 * @var $form \pay\models\forms\Juridical
 * @var $this JuridicalController
 */
?>

<section id="section" role="main">
  <div class="container">
    <div class="row">
      <div class="offset2 span8">

        <h3><?=Yii::t('app', 'Выставление счета');?></h3>

        <h5><?=Yii::t('app', 'Заполните данные юридического лица');?></h5>

        <?=CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>

        <?=CHtml::beginForm('', 'POST', array('class' => 'form-horizontal m-top_40'));?>

        <div class="control-group">
          <?=CHtml::activeLabel($form, 'Name', array('class' => 'control-label'));?>
          <div class="controls">
            <?=CHtml::activeTextField($form, 'Name', array('class' => 'span4'));?>
          </div>
        </div>
        <div class="control-group">
          <?=CHtml::activeLabel($form, 'Address', array('class' => 'control-label'));?>
          <div class="controls">
            <?=CHtml::activeTextArea($form, 'Address', array('class' => 'span4'));?>
          </div>
        </div>
        <div class="control-group">
          <?=CHtml::activeLabel($form, 'INN', array('class' => 'control-label'));?>
          <div class="controls">
            <?=CHtml::activeTextField($form, 'INN', array('class' => 'span4'));?>
          </div>
        </div>
        <div class="control-group">
          <?=CHtml::activeLabel($form, 'KPP', array('class' => 'control-label'));?>
          <div class="controls">
            <?=CHtml::activeTextField($form, 'KPP', array('class' => 'span4'));?>
          </div>
        </div>
        <div class="control-group">
          <?=CHtml::activeLabel($form, 'Phone', array('class' => 'control-label'));?>
          <div class="controls">
            <?=CHtml::activeTextField($form, 'Phone', array('class' => 'span4'));?>
          </div>
        </div>
        <div class="control-group">
          <?=CHtml::activeLabel($form, 'PostAddress', array('class' => 'control-label'));?>
          <div class="controls">
            <?=CHtml::activeTextArea($form, 'PostAddress', array('class' => 'span4'));?>
          </div>
        </div>

        <div class="control-group">
          <div class="controls">
            <div class="row">
              <div class="span2">
                <a class="btn" href="<?=$this->createUrl('/widget/pay/cabinet');?>">
                  <i class="icon-circle-arrow-left"></i>
                  <?=\Yii::t('app', 'Назад');?>
                </a>
              </div>
              <div class="span3">
                <?=\CHtml::submitButton(\Yii::t('app', 'Выставить счет'), ['class' => 'btn btn-info']);?>
              </div>
            </div>
          </div>
        </div>

        <?php echo CHtml::endForm();?>



      </div>
    </div>
  </div>


</section>
