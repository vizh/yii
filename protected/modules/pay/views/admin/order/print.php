<?/**
 * @var \application\components\utility\Paginator $paginator
 * @var  \pay\models\forms\admin\OrderPrint $form
 * @var \event\models\Event $event
 */?>
<div class="btn-toolbar"></div>
<div class="well">
  <?=\CHtml::beginForm($this->createUrl('/pay/admin/order/print'),'GET',['class' => 'form-horizontal']);?>
  <?=\CHtml::errorSummary($form,'<div class="alert alert-error">', '</div>');?>
  <div class="row">
    <div class="span5">
      <?=\CHtml::activeLabel($form,'EventLabel');?>
      <?=\CHtml::activeTextField($form, 'EventLabel', ['class' => 'input-block-level', 'placeholder' => $form->getAttributeLabel('EventLabel')]);?>
      <?=\CHtml::activeHiddenField($form, 'EventId');?>
    </div>
    <div class="span3">
      <?=\CHtml::activeLabel($form,'DateFrom');?>
      <?=\CHtml::activeTextField($form, 'DateFrom', ['placeholder' => $form->getAttributeLabel('DateFrom')]);?>
      <button type="submit" class="btn btn-info" name="find"><i class="icon-search icon-white"></i></button>
    </div>
  </div>
  <?=\CHtml::endForm();?>
  <hr/>

  <?if ($event !== null):?>
    <h4 class="m-bottom_10"><?=\Yii::t('app', 'Счета для «{event}»', ['{event}' => $event->Title]);?>:</h4>
    <?for($p = 0; $p <= $paginator->getCountPages(); $p++):?>
      <a href="<?=$paginator->getUrl($p);?>" class="btn" target="_blank"><?=(($p-1) * $paginator->perPage)+1;?> &mdash; <?=$p * $paginator->perPage;?></a>
    <?endfor;?>
  <?endif;?>
</div>