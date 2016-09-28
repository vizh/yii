<div class="row-fluid">
  <div class="btn-toolbar">

  </div>
  <div class="well">
    <?if(\Yii::app()->getUser()->hasFlash('success')):?>
      <div class="alert alert-success">
        <?=\Yii::app()->getUser()->getFlash('success')?>
      </div>
    <?endif?>
    <h3><?=\Yii::t('app', 'Основная информация')?></h3>
    <?=\CHtml::beginForm('', 'POST', array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal'))?>
      <?=\CHtml::errorSummary($form, '<div class="alert alert-error">', '</div>')?>
      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Title', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'Title', array('class' => 'input-xxlarge'))?>
        </div>
      </div>
      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'CompanyId', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'CompanyId', array('class' => 'input-xxlarge'))?>
        </div>
      </div>
      <div class="control-group">
        <?=\CHtml::activeLabel($form, 'Url', array('class' => 'control-label'))?>
        <div class="controls">
          <?=\CHtml::activeTextField($form, 'Url', array('class' => 'input-xxlarge'))?>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <?=\CHtml::submitButton(\Yii::t('app', 'Сохранить'), array('class' => 'btn btn-primary'))?>
        </div>
      </div>
      <?=\CHtml::hiddenField('Form', get_class($form))?>
    <?=\CHtml::endForm()?>

    <?if(!$company->getIsNewRecord()):?>
      <h3 class="m-top_40"><?=\Yii::t('app', 'Логотипы')?></h3>
      <?=\CHtml::beginForm('', 'POST', array('enctype' => 'multipart/form-data'))?>
        <?=\CHtml::errorSummary($formLogo, '<div class="alert alert-error">', '</div>')?>
        <div class="row-fluid">
          <div class="span2 offset1">
            <?=\CHtml::activeLabel($formLogo, 'Raster')?>
            <?=\CHtml::activeFileField($formLogo, 'Raster')?>
          </div>
          <div class="span2">
            <?=\CHtml::activeLabel($formLogo, 'Vector')?>
            <?=\CHtml::activeFileField($formLogo, 'Vector')?>
          </div>
          <div class="span2">
            <?=\CHtml::activeLabel($formLogo, 'W100px')?>
            <?=\CHtml::activeFileField($formLogo, 'W100px')?>
          </div>
          <div class="span2">
            <?=\CHtml::submitButton(\Yii::t('app' , 'Загрузить'), array('class' => 'btn btn-success btn-large', 'style' => 'margin-top: 9px;'))?>
          </div>
        </div>
        <?=\CHtml::hiddenField('Form', get_class($formLogo))?>
      <?=\CHtml::endForm()?>

      <?if(!empty($form->Logos)):?>
        <?foreach($form->Logos as $fLogo):?>
          <?=\CHtml::beginForm('', 'POST', array('enctype' => 'multipart/form-data'))?>
            <hr class="m-top_40 m-bottom_40"/>
            <?=\CHtml::errorSummary($fLogo, '<div class="alert alert-error">', '</div>')?>
            <div class="row-fluid">
              <div class="span1">
                <?if($fLogo->getLogo()->get100px() !== null):?>
                  <?=\CHtml::image($fLogo->getLogo()->get100px())?>
                <?endif?>
              </div>
              <div class="span2">
                <label><?=$fLogo->getAttributeLabel('Raster')?>
                  <?if($fLogo->getLogo()->getOriginal()):?>
                    <a href="<?=$fLogo->getLogo()->getOriginal()?>" class="btn btn-mini btn-info"><?=\Yii::t('app', 'Скачать')?></a>
                  <?endif?>
                </label>
                <?=\CHtml::activeFileField($fLogo, 'Raster')?>
              </div>
              <div class="span2">
                <label><?=$fLogo->getAttributeLabel('Vector')?>
                  <?if($fLogo->getLogo()->getVector()):?>
                    <a href="<?=$fLogo->getLogo()->getVector()?>" class="btn btn-mini btn-info"><?=\Yii::t('app', 'Скачать')?></a>
                  <?endif?>
                </label>
                <?=\CHtml::activeFileField($fLogo, 'Vector')?>
              </div>
              <div class="span2">
                <label><?=$fLogo->getAttributeLabel('W100px')?></label>
                <?=\CHtml::activeFileField($fLogo, 'W100px')?>
              </div>
              <div class="span2">
                <div class="btn-group">
                  <button type="submit" name="" class="btn btn-success btn-large"><?=\Yii::t('app' , 'Загрузить')?></button>
                  <button type="submit" value="1" name="<?=\CHtml::activeName($fLogo, 'Delete')?>" class="btn btn-danger btn-large"><?=\Yii::t('app' , 'Удалить')?></button>
                </div>
              </div>
            </div>
            <?=\CHtml::activeHiddenField($fLogo, 'Id')?>
            <?=\CHtml::hiddenField('Form', get_class($formLogo))?>
          <?=\CHtml::endForm()?>
        <?endforeach?>
      <?endif?>
    <?endif?>
  </div>
</div>
