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

<h2 class="b-header_large light">
  <div class="line"></div>
  <div class="container">
    <div class="title">
      <span class="backing runet">Runet</span>
      <span class="backing text"><?=\Yii::t('app', 'Мероприятия');?></span>
    </div>
  </div>
</h2>

<?if (\Yii::app()->user->hasFlash('success')):?>
<div class="container">
  <div class="alert alert-success"><?=\Yii::app()->user->getFlash('success');?></div>
</div>
<?else:?>
<div class="container event-create">
  <div class="row">
    <div class="span12">
      <h2 class="m-bottom_20"><?=\Yii::t('app', 'Добавление события');?></h2>

      <p>Сервис RUNET-ID/Календарь предназначен для организаторов конференций, семинаров, лекций, выставок и других мероприятий, посвященных IT-тематике, Интернету, технологиям и медиа.</p>
      <p>С помощью нашего календаря вы можете не только анонсировать событие, но и организовать регистрацию на мероприятие, а также приём оплаты за участие. Сегодня на портале RUNET-ID зарегистрированно почти 100 тысяч профессионалов IT и медиа, которых может заинтересовать ваш проект.</p>
      <p>Пожалуйста заполните все поля формы ниже и наши сотрудники обязательно свяжутся с вами.</p>
      
      <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>');?>
      
      <?=\CHtml::form('', 'POST', ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']);?>
      <h4 class="m-bottom_20 m-top_40"><?=\Yii::t('app', 'Контактное лицо');?></h4>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'ContactName', array('class' => 'control-label', 'required' => true));?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'ContactName');?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'ContactPhone', array('class' => 'control-label', 'required' => true));?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'ContactPhone');?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'ContactEmail', array('class' => 'control-label', 'required' => true));?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'ContactEmail');?>
        </div>
      </div>

      <h4 class="m-bottom_20 m-top_40"><?=\Yii::t('app', 'Мероприятие');?></h4>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Title', array('class' => 'control-label', 'required' => true));?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'Title');?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Place', array('class' => 'control-label', 'required' => true));?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'Place');?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Date', array('class' => 'control-label', 'required' => true));?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'StartDate', array('class' => 'input-medium', 'placeholder' => \Yii::t('app', 'дд.мм.гггг')));?> &ndash; <?=\CHtml::activeTextField($form, 'EndDate', array('class' => 'input-medium', 'placeholder' => \Yii::t('app', 'дд.мм.гггг')));?>
          <label class="checkbox m-top_5"><?=\CHtml::activeCheckBox($form, 'OneDayDate');?> <?=$form->getAttributeLabel('OneDayDate');?></label>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Url', array('class' => 'control-label'));?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'Url');?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'LogoSource', array('class' => 'control-label', 'required' => true))?>
        <div class="controls">
          <?=\CHtml::activeFileField($form, 'LogoSource')?>
          <p class="help-block"><?=\Yii::t('app', 'В качестве логотипа загружать векторные изображения (EPS, AI)<br>или PNG24 с прозрачным фоном и шириной не менее 400px.')?></p>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Info', array('class' => 'control-label', 'required' => true));?>
        <div class="controls">
          <?=\CHtml::activeTextArea($form, 'Info', array('class' => 'input-xxlarge'));?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'FullInfo', array('class' => 'control-label'));?>
        <div class="controls">
          <?=\CHtml::activeTextArea($form, 'FullInfo', array('class' => 'input-xxlarge'));?>
        </div>
      </div>

      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Options', array('class' => 'control-label'));?>
        <div class="controls">
          <?foreach ($form->getOptionsData() as $key => $option):?>
          <label class="checkbox">
            <?=\CHtml::activeCheckBox($form, 'Options['.$key.']', array('checked' => in_array($key, $form->Options) ? true : null, 'uncheckValue' => null, 'value' => $key));?> <?=$option;?>
          </label>
          <?endforeach;?>
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <?=\CHtml::submitButton(\Yii::t('app', 'Отправить'), array('class' => 'btn btn-info'));?>
        </div>
      </div>
      <?=\CHtml::endForm();?>
    </div>
  </div>
</div>
<?endif;?>