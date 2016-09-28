<?/**
 * @var \event\models\forms\widgets\Base $form
 */?>
<?=\CHtml::form('','POST', ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'])?>
  <?foreach($widget->getAttributeNames() as $key => $name):?>
    <div class="control-group">
      <?=\CHtml::activeLabel($form, $name, ['class' => 'control-label'])?>
      <div class="controls">
        <?foreach($form->getLocaleList() as $locale):?>
          <div class="m-bottom_5">
            <div class="input-append">
              <?if($key == 1):?>
                <?=\CHtml::activeTextArea($form, 'Attributes['.$name.']['.$locale.']', ['class' => 'input-xxlarge', 'style' => 'height: 400px;'])?>
              <?else:?>
                <?=\CHtml::activeTextField($form, 'Attributes['.$name.']['.$locale.']', ['class' => 'input-xxlarge'])?>
              <?endif?>
              <span class="add-on"><?=$locale?></span>
            </div>
          </div>
        <?endforeach?>
      </div>
    </div>
  <?endforeach?>
  <div class="control-group">
    <div class="controls">
      <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success'])?>
    </div>
  </div>
<?=\CHtml::endForm()?>