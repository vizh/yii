<?
/*
 * @var pay\models\OrderJuridicalTemplate $template
 */
?>
<script type="text/javascript">
    $(function () {
        CKEDITOR.replace('pay\\models\\forms\\admin\\OrderTemplate[OfferText]', {
            'customConfig' : 'config_admin.js'
        });
    });
</script>
<?=\CHtml::form('','POST',['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']);?>
<div class="btn-toolbar clearfix">
  <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
  <p class="text-error m-top_5" style="font-size: 11px; margin-bottom: 0;"><?=\Yii::t('app', 'Нажимая кнопку сохранить, вы берете на себя отвественность за то, куда придут деньги плательщиков!');?></p>
</div>
<div class="well">
  <div class="row-fluid">
    <div class="span8">
    <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
    <?if (\Yii::app()->getUser()->hasFlash('success')):?>
      <div class="alert alert-success"><?=\Yii::app()->getUser()->getFlash('success');?></div>
    <?endif;?>

    <?if ($template->ParentTemplateId == null):?>
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
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'NumberFormat', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'NumberFormat');?>
        <span class="help-inline"><strong>%s</strong> &mdash; <?=\Yii::t('app', 'место, куда выводить номер счета. Например IMH-%s будет отображаться как IMH-001');?></span>
      </div>
    </div>

    <?if($template->getIsNewRecord() || $template->Number == 1):?>
    <div class="control-group">
      <?=\Chtml::activeLabel($form, 'Number', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::activeTextField($form, 'Number');?>
        <p class="m-top_5 text-error"><?=\Yii::t('app', 'Внимание! Это поле редактируется только один раз');?></p>
      </div>
    </div>
    <?endif;?>

    <div class="control-group m-top_20">
      <?=\Chtml::activeLabel($form, 'Stamp', ['class' => 'control-label']);?>
      <div class="controls">
        <?=\CHtml::fileField(\CHtml::activeName($form, 'Stamp'));?>
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
    <div class="control-group">
        <?=\Chtml::activeLabel($form, 'OfferText', ['class' => 'control-label']);?>
        <div class="controls">
            <?=\CHtml::activeTextArea($form, 'OfferText');?>
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
        <?=\CHtml::fileField(\CHtml::activeName($form, 'SignFirstImage'));?>
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
        <?=\CHtml::fileField(\CHtml::activeName($form, 'SignSecondImage'));?>
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

    <?else:?>
      <div class="control-group">
        <?=\Chtml::activeLabel($form, 'Title', ['class' => 'control-label']);?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'Title', ['class' => 'input-xxlarge']);?>
        </div>
      </div>
      <div class="control-group">
        <?=\Chtml::activeLabel($form, 'NumberFormat', ['class' => 'control-label']);?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'NumberFormat');?>
          <span class="help-inline"><strong>%s</strong> &mdash; <?=\Yii::t('app', 'место, куда выводить номер счета. Например IMH-%s будет отображаться как IMH-001');?></span>
        </div>
      </div>
      <?if($template->getIsNewRecord() || $template->Number == 1):?>
        <div class="control-group">
          <?=\Chtml::activeLabel($form, 'Number', ['class' => 'control-label']);?>
          <div class="controls">
            <?=\CHtml::activeTextField($form, 'Number');?>
            <p class="m-top_5 text-error"><?=\Yii::t('app', 'Внимание! Это поле редактируется только один раз');?></p>
          </div>
        </div>
      <?endif;?>
      <div class="alert alert-info"><?=\Yii::t('app', 'Данный шаблон яляется копией другово шаблона. Для того, чтобы внести изменения в основные поля, отредатируйте шаблон-родитель <a href="{url}" class="btn btn-mini">перейти</a>', ['{url}' => $this->createUrl('/pay/admin/orderjuridicaltemplate/edit', ['templateId' => $template->ParentTemplateId])]);?></div>
    <?endif;?>
    </div>
    <div class="span2">
      <a href="<?=$this->createUrl('/pay/admin/orderjuridicaltemplate/edit', ['templateId' => $template->Id, 'view' => true]);?>" class="btn btn-large" target="_blank"><i class="icon-eye-open"></i> <?=\Yii::t('app', 'Просмотр');?></a>
    </div>
  </div>
</div>
<div class="btn-toolbar">
  <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
</div>
<?=\CHtml::endForm();?>