<?=\CHtml::beginForm('', 'POST', array('class' => 'form-horizontal'))?>
  <div class="well m-top_30">
    <div class="row-fluid">
      <div class="span12">

        <?if(isset($error)):?>
            <div class="alert alert-error">
              <?if($error == 'main'):?>
                  <p>Не найдена основная компания.</p>
              <?else:?>
                  <p>Не найдена ни одна дублирующая компания из списка</p>
              <?endif?>
            </div>
        <?endif?>

        <div class="control-group">
          <label for="CompanyIdMain" class="control-label">ID основной компании</label>
          <div class="controls">
            <input id="CompanyIdMain" type="text" class="span4" name="CompanyIdMain" value="<?=isset($companyId) ? $companyId : ''?>">
          </div>
        </div>

        <div class="control-group">
          <label for="CompanyIdSecond" class="control-label">ID компаний-дублей</label>
          <div class="controls">
            <input id="CompanyIdSecond" type="text" class="span4"  name="CompanyIdSecond" value="<?=isset($companyIdSecond) ? $companyIdSecond : ''?>">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="btn-toolbar">
    <?=\CHtml::submitButton(\Yii::t('app', 'Объединить'), array('class' => 'btn'))?>
  </div>
<?=\CHtml::endForm()?>