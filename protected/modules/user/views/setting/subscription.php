<?
/**
 *  @var \user\models\forms\setting\Subsciption $form
 */
?>

<?=$this->renderPartial('parts/title')?>
<div class="user-account-settings">
  <div class="clearfix">
    <div class="container">
      <div class="row">
        <div class="span3">
          <?=$this->renderPartial('parts/nav', array('current' => $this->getAction()->getId()))?>
        </div>
        <div class="span9">
          <?=\CHtml::beginForm('', 'POST', array('class' => 'b-form'))?>
            <div class="form-header">
              <h4><?=\Yii::t('app', 'Управление подпиской')?></h4>
            </div>
            <?=$this->renderPartial('user.views.edit.parts.form-alert', array('form' => $form))?>
            <div class="form-row">
              <label class="checkbox">
                <?=\CHtml::activeCheckBox($form, 'Subscribe')?> <?=$form->getAttributeLabel('Subscribe')?>
              </label>
            </div>
            <?$unsubscribeEventsData = $form->getUnsubscribeEventsData()?>
            <?if(!empty($unsubscribeEventsData) && $form->Subscribe):?>
                <h5 class="m-top_20"><?=\Yii::t('app', 'Отписаться от рассылок мероприятий:')?></h5>
                <?foreach($form->getUnsubscribeEventsData() as $id => $title):?>
                    <div class="row">
                        <div class="span8 offset1">
                            <div class="form-row">
                                <label class="checkbox">
                                    <?=\CHtml::activeCheckBox($form, 'UnsubscribeEvents['.$id.']', ['checked' => true])?> <?=$title?>
                                </label>
                            </div>
                        </div>
                    </div>
                <?endforeach?>
            <?endif?>

            <div class="form-footer">
              <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-info'))?>
            </div>
          <?=\CHtml::endForm()?>
        </div>
      </div>
    </div>
  </div>
</div>
