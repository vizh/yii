<?php
/*
 * @var bool $showForm
 * @var \event\models\forms\widgets\Base $form
 */
?>
<?if ($showForm):?>
  <?=\CHtml::form('','POST', ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']);?>
    <?foreach (array_keys($form->Attributes) as $attr):?>
      <div class="control-group">
        <?=\CHtml::activeLabel($form, $attr, ['class' => 'control-label']);?>
        <div class="controls">
          <?foreach ($form->getLocaleList() as $locale):?>
            <div class="m-bottom_5">
              <div class="input-append">
                <?=\CHtml::activeTextField($form, 'Attributes['.$attr.']['.$locale.']', ['class' => 'input-xxlarge']);?>
                <span class="add-on"><?=$locale;?></span>
              </div>
            </div>
          <?endforeach;?>
        </div>
      </div>
    <?endforeach;?>
    <div class="control-group">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']);?>
      </div>
    </div>
  <?=\CHtml::endForm();?>
<?endif;?>
