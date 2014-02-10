<?/**
 * @var \event\models\forms\widgets\Base $form
 */?>
<?=\CHtml::form('','POST', ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']);?>
  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'TabTitle', ['class' => 'control-label']);?>
    <div class="controls">
      <?foreach ($form->getLocaleList() as $locale):?>
        <div class="m-bottom_5">
          <div class="input-append">
            <?=\CHtml::activeTextField($form, 'Attributes[TabTitle]['.$locale.']', ['class' => 'input-xxlarge']);?>
            <span class="add-on"><?=$locale;?></span>
          </div>
        </div>
      <?endforeach;?>
    </div>
  </div>

  <div class="control-group">
    <?=\CHtml::activeLabel($form, 'TabContent', ['class' => 'control-label']);?>
    <div class="controls">
      <?foreach ($form->getLocaleList() as $locale):?>
        <div class="m-bottom_5">
          <div class="input-append">
            <?=\CHtml::activeTextArea($form, 'Attributes[TabContent]['.$locale.']', ['class' => 'input-xxlarge', 'style' => 'height: 300px;']);?>
            <span class="add-on"><?=$locale;?></span>
          </div>
        </div>
      <?endforeach;?>
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
    </div>
  </div>
<?=\CHtml::endForm();?>