<?=\CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'));?>
  <div class="well m-top_30">
    <div class="row-fluid">
      <div class="span12">

        <?if (isset($error)):?>
            <div class="alert alert-error">
              <?if ($error == 'main'):?>
                  <p>Не найден пользователь с основным RUNET-ID.</p>
              <?else:?>
                  <p>Не найден пользователь с дублем RUNET-ID</p>
              <?endif;?>
            </div>
        <?endif;?>

        <div class="control-group">
          <label for="RunetIdMain" class="control-label">Основной RUNET&ndash;ID</label>
          <div class="controls">
            <input id="RunetIdMain" type="text" class="span4" name="RunetIdMain" value="<?=isset($runetId) ? $runetId : '';?>">
          </div>
        </div>

        <div class="control-group">
          <label for="RunetIdSecond" class="control-label">Дубль RUNET&ndash;ID</label>
          <div class="controls">
            <input id="RunetIdSecond" type="text" class="span4"  name="RunetIdSecond" value="<?=isset($runetIdSecond) ? $runetIdSecond : '';?>">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="btn-toolbar">
    <?=\CHtml::submitButton(\Yii::t('app', 'Объеденить'), array('class' => 'btn'));?>
  </div>
<?=\CHtml::endForm();?>