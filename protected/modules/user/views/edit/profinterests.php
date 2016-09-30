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
              <h4><?=\Yii::t('app', 'Профессиональные интересы')?></h4>
            </div>

            <?=$this->renderPartial('parts/form-alert', array('form' => $form))?>

            <div class="form-row">
              <div class="row">
                <?foreach($form->getProfessionalInterestList() as $code => $title):?>
                  <div class="span4">
                    <label class="checkbox">
                      <?=\CHtml::activeCheckBox($form, $code, array('uncheckValue' => null))?> <?=$title?>
                    </label>
                  </div>
                <?endforeach?>
              </div>
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