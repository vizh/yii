<?
/*
 * @var pay\models\OrderJuridicalTemplate $template
 */
?>
<?=\CHtml::form('','POST',['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']);?>
<div class="btn-toolbar clearfix">
  <?if (!empty($backUrl)):?>
    <a href="<?=$backUrl;?>" class="btn"><i class="icon-arrow-left"></i> <?=\Yii::t('app', 'Вернуться');?></a>
    <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success pull-right']);?>
  <?else:?>
    <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
  <?endif;?>
</div>
<div class="well">
  <div class="row-fluid">
    <div class="span8">
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
    <?if (\Yii::app()->getUser()->hasFlash('success')):?>
      <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
    <?endif;?>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'Title', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Title', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'Recipient', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Recipient', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'Address', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Address', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'Phone', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Phone', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'Fax', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Fax', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'INN', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'INN', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'KPP', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'KPP', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'Bank', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Bank', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'BankAccountNumber', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'BankAccountNumber', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'AccountNumber', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'AccountNumber', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'BIK', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'BIK', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'VAT', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeCheckBox($form, 'VAT');?>
      </div>
    </div>

    <div class="control-group m-top_20">
      <?=\Chtml::activeLabel($form, 'Stamp', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeFileField($form, 'Stamp');?>
        <?if (file_exists($template->getStampImagePath(true))):?>
          <div class="m-top_5"><?=\CHtml::image($template->getStampImagePath());?></div>
        <?endif;?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'StampMarginLeft', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'StampMarginLeft');?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'StampMarginTop', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'StampMarginTop');?>
      </div>
    </div>

    <div class="control-group m-top_20">
      <div class="controls">
        <h3><?=\Yii::t('app', 'Первая подпись');?></h3>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'SignFirstTitle', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'SignFirstTitle', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'SignFirstName', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'SignFirstName');?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'SignFirstImage', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeFileField($form, 'SignFirstImage');?>
        <?if (file_exists($template->getFirstSignImagePath(true))):?>
          <div class="m-top_5"><?=\CHtml::image($template->getFirstSignImagePath());?></div>
        <?endif;?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'SignFirstImageMarginLeft', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'SignFirstImageMarginLeft');?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'SignFirstImageMarginTop', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'SignFirstImageMarginTop');?>
      </div>
    </div>

    <div class="control-group m-top_20">
      <div class="controls">
        <h3><?=\Yii::t('app', 'Вторая подпись');?></h3>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'SignSecondTitle', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'SignSecondTitle', ['class' => 'input-xxlarge']);?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'SignSecondName', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'SignSecondName');?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'SignSecondImage', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeFileField($form, 'SignSecondImage');?>
        <?if (file_exists($template->getSecondSignImagePath(true))):?>
          <div class="m-top_5"><?=\CHtml::image($template->getSecondSignImagePath());?></div>
        <?endif;?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'SignSecondImageMarginLeft', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'SignSecondImageMarginLeft');?>
      </div>
    </div>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'SignSecondImageMarginTop', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'SignSecondImageMarginTop');?>
      </div>
    </div>
    </div>
    <div class="span2">
      <a href="<?=$this->createUrl('/pay/admin/account/ordertemplate', ['templateId' => $template->Id, 'view' => true]);?>" class="btn btn-large" target="_blank"><i class="icon-eye-open"></i> <?=\Yii::t('app', 'Просмотр');?></a>
    </div>
  </div>
</div>
<div class="btn-toolbar">
  <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
</div>
<?=\CHtml::endForm();?>