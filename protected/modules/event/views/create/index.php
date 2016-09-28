<?
\Yii::app()->getClientScript()->registerPackage('runetid.ckeditor');
\Yii::app()->getClientScript()->registerPackage('runetid.bootstrap-datepicker');
$this->setPageTitle(\Yii::t('app', 'Добавление события'));
$this->bodyId = 'event-create';
?>
<style type="text/css">
  .form-horizontal .control-label {
    width: 160px;
  }

  .form-horizontal .control-label.required {
    width: 171px;
  }

  .form-horizontal .control-label span.required {
    color: brown;
    font-size: 20px;
  }
</style>
<script type="text/javascript">
$(function () {
  $('input[id*="Create_Options_6"]').change(function () {
    $('input[id*="Create_PlannedParticipants"]').toggleClass('hide');
  });
  CKEDITOR.replace('event\\models\\forms\\Create[FullInfo]', {
    height: 335
  });
});
</script>

<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Мероприятия')?></span>
    </div>
  </div>
</h2>

<?if(\Yii::app()->user->hasFlash('success')):?>
<div class="container">
  <div class="alert alert-success"><?=\Yii::app()->user->getFlash('success')?></div>
</div>
<?else:?>
<div class="container event-create">
  <div class="row">
    <div class="span12">
      <h2 class="m-bottom_20"><?=\Yii::t('app', 'Добавление события')?></h2>

      <p><?=\Yii::t('app', 'Сервис RUNET-ID/Календарь предназначен для организаторов конференций, семинаров, лекций, выставок и других мероприятий, посвященных IT-тематике, Интернету, технологиям и медиа.')?></p>
      <p><?=\Yii::t('app', 'С помощью нашего календаря вы можете не только анонсировать событие, но и организовать регистрацию на мероприятие, а также приём оплаты за участие. Сегодня на портале RUNET-ID зарегистрированно почти 200 тысяч профессионалов IT и медиа, которых может заинтересовать ваш проект.')?></p>
      <p><?=\Yii::t('app', 'Пожалуйста, заполните все поля формы ниже, и наши сотрудники обязательно свяжутся с вами.')?></p>

      <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>

      <?=\CHtml::form('', 'POST', ['class' => '', 'enctype' => 'multipart/form-data'])?>

      <div class="well">
        <h4 class="m-bottom_20"><?=\Yii::t('app', 'Информация о мероприятии')?></h4>
        <div class="row">
          <div class="span7">
            <div class="control-group">
              <?=\CHtml::activeLabel($form, 'Title', array('class' => 'control-label', 'required' => true))?>
              <div class="controls">
                <?=\CHtml::activeTextField($form, 'Title', ['class' => 'input-block-level'])?>
              </div>
            </div>

            <div class="row">
              <div class="span2">
                <div class="control-group">
                  <?=\CHtml::activeLabel($form, 'City', array('class' => 'control-label', 'required' => true))?>
                  <div class="controls">
                    <?=\CHtml::activeTextField($form, 'City', ['placeholder' => \Yii::t('app', 'Москва'), 'class' => 'input-block-level'])?>
                  </div>
                </div>
              </div>
              <div class="span5">
                <div class="control-group">
                  <?=\CHtml::activeLabel($form, 'Place', array('class' => 'control-label', 'required' => true))?>
                  <div class="controls">
                    <?=\CHtml::activeTextField($form, 'Place', ['placeholder' => \Yii::t('app', 'Берсеневская наб., 6 (Digital October)'), 'class' => 'input-block-level'])?>
                  </div>
                </div>
              </div>
            </div>

            <div class="control-group">
              <?=\CHtml::activeLabel($form, 'Date', array('class' => 'control-label', 'required' => true))?>
              <div class="controls">
                <?=\CHtml::activeTextField($form, 'StartDate', array('class' => 'input-medium', 'placeholder' => \Yii::t('app', 'дд.мм.гггг')))?> &ndash; <?=\CHtml::activeTextField($form, 'EndDate', array('class' => 'input-medium', 'placeholder' => \Yii::t('app', 'дд.мм.гггг')))?>
                <label class="checkbox"><?=\CHtml::activeCheckBox($form, 'OneDayDate')?> <?=$form->getAttributeLabel('OneDayDate')?></label>
              </div>
            </div>

            <div class="control-group">
              <?=\CHtml::activeLabel($form, 'Url', array('class' => 'control-label'))?>
              <div class="controls">
                <?=\CHtml::activeTextField($form, 'Url')?>
              </div>
            </div>
          </div>
          <div class="span3">
            <div class="control-group">
              <?=\CHtml::activeLabel($form, 'LogoSource', array('class' => 'control-label', 'required' => true))?>
              <div class="controls" style="margin-top: -8px;">
                <?=\CHtml::activeFileField($form, 'LogoSource')?>
                <p class="help-block"><?=\Yii::t('app', 'В качестве логотипа загружать векторные изображения (EPS, AI)<br>или PNG24 с прозрачным фоном и шириной не менее 400px.')?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="m-bottom_40">
          <div class="control-group">
            <?=\CHtml::activeLabel($form, 'Info', array('class' => 'control-label', 'required' => true))?>
            <div class="controls">
              <?=\CHtml::activeTextArea($form, 'Info', array('class' => 'input-block-level', 'style' => 'height: 100px'))?>
            </div>
          </div>

          <div class="control-group">
            <?=\CHtml::activeLabel($form, 'FullInfo', array('class' => 'control-label'))?>
            <div class="controls">
              <?=\CHtml::activeTextArea($form, 'FullInfo', array('class' => 'input-block-level'))?>
            </div>
          </div>
        </div>
        <div class="control-group">
          <p style="margin-bottom: 5px;"><?=\Yii::t('app', 'Дополнительные опции')?> (<a target="_blank" href="http://runet-id.com/docs/presentation.pdf"><?=\Yii::t('app', 'подробное описание')?></a>)</p>
          <div class="controls">
            <span class="help-block"><?=\Yii::t('app', 'Укажите дополнительные опциии, которые были бы вам интересны. Наш менеджер свяжется с вами и предоставит подробную информацию.')?></span>
            <?foreach($form->getOptionsData() as $key => $option):?>
              <label class="checkbox">
                <?=\CHtml::activeCheckBox($form, 'Options['.$key.']', array('checked' => in_array($key, $form->Options) ? true : null, 'uncheckValue' => null, 'value' => $key))?> <?=$option?>
              </label>
              <?if($key == 6):?>
                <?=\CHtml::activeTextField($form, 'PlannedParticipants', ['placeholder' => \Yii::t('app', 'Введите планируемое кол-во участников'), 'class' => 'span4 '.(in_array(6, $form->Options)?'':'hide')])?>
              <?endif?>
            <?endforeach?>
          </div>
        </div>
      </div>

      <h4 class="m-bottom_20 m-top_40"><?=\Yii::t('app', 'Контактный представитель')?></h4>
      <div class="row">
        <div class="span4">
          <div class="control-group">
            <?=\CHtml::activeLabel($form, 'ContactName', array('class' => 'control-label', 'required' => true))?>
            <div class="controls">
              <?=\CHtml::activeTextField($form, 'ContactName', ['class' => 'input-block-level'])?>
            </div>
          </div>
        </div>
        <div class="span4">
          <div class="control-group">
            <?=\CHtml::activeLabel($form, 'ContactPhone', array('class' => 'control-label', 'required' => true))?>
            <div class="controls">
              <?=\CHtml::activeTextField($form, 'ContactPhone', ['class' => 'input-block-level'])?>
            </div>
          </div>
        </div>
        <div class="span4">
          <div class="control-group">
            <?=\CHtml::activeLabel($form, 'ContactEmail', array('class' => 'control-label', 'required' => true))?>
            <div class="controls">
              <?=\CHtml::activeTextField($form, 'ContactEmail', ['class' => 'input-block-level'])?>
            </div>
          </div>
        </div>
          <div class="span12">
              <div class="control-group">
                  <?=\CHtml::activeLabel($form, 'Company', array('class' => 'control-label', 'required' => true))?>
                  <div class="controls">
                      <?=\CHtml::activeTextField($form, 'Company', ['class' => 'input-block-level'])?>
                  </div>
              </div>
          </div>
      </div>


      <div class="control-group">
        <div class="controls">
          <?=\CHtml::submitButton(\Yii::t('app', 'Отправить'), array('class' => 'btn btn-info'))?>
        </div>
      </div>
      <?=\CHtml::endForm()?>
    </div>
  </div>
</div>
<?endif?>