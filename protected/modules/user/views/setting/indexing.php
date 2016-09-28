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
              <h4><?=\Yii::t('app', 'Индексации в поисковых системах')?></h4>
            </div>
            <?=$this->renderPartial('user.views.edit.parts.form-alert', array('form' => $form))?>
            <div class="form-row">
              <label class="checkbox">
                <?=\CHtml::activeCheckBox($form, 'Deny')?> <?=$form->getAttributeLabel('Deny')?>
              </label>
            </div>

            <div class="form-footer">
              <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-info'))?>
            </div>
          <?=\CHtml::endForm()?>
        </div>
      </div>
    </div>
  </div>
</div>