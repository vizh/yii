<?=$this->renderPartial('parts/title')?>

<div class="user-account-settings">
  <div class="clearfix">
    <div class="container">
      <div class="row">
        <div class="span3">
          <?=$this->renderPartial('parts/nav', array('current' => $this->getAction()->getId()))?>
        </div>
        <div class="span9">

          <?=\CHtml::form('', 'POST', array('class' => 'b-form'))?>

            <div class="form-header">
              <h4><?=\Yii::t('app', 'Основная информация')?></h4>
            </div>

            <?=$this->renderPartial('parts/form-alert', array('form' => $form))?>

            <div class="form-row">
              <?=\CHtml::activeLabel($form, 'LastName')?>
              <?=\CHtml::activeTextField($form, 'LastName', array('required' => true, 'class' => 'span5'))?>
            </div>

            <div class="form-row">
              <?=\CHtml::activeLabel($form, 'FirstName')?>
              <?=\CHtml::activeTextField($form, 'FirstName', array('required' => true, 'class' => 'span5'))?>
            </div>

            <div class="form-row">
              <?=\CHtml::activeLabel($form, 'FatherName')?>
              <?=\CHtml::activeTextField($form, 'FatherName', array('class' => 'span5'))?>
            </div>

            <div class="form-row">
              <?=\CHtml::activeLabel($form, 'Birthday')?>
              <?=\CHtml::activeTextField($form, 'Birthday', array('class' => 'span3', 'placeholder' => \Yii::t('app', 'Пример: 01.01.1980')))?>
            </div>


            <div class="form-row">
              <?foreach($form->getGenderList() as $value => $title):?>
              <label class="radio inline">
                <?=\CHtml::activeRadioButton($form, 'Gender', array('value' => $value,'uncheckValue' => null))?> <?=$title?>
              </label>
              <?endforeach?>
            </div>

            <div class="form-info"><b><span class="required">*</span></b> — <?=\Yii::t('app', 'поля обязательны для заполнения')?></div>

            <div class="form-footer">
              <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-info'))?>
            </div>

          <?=\CHtml::endForm()?>

        </div>
      </div>
    </div>
  </div>
</div>