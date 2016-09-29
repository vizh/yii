<div class="btn-toolbar"></div>
<div class="well">
  <?=\CHtml::form('','POST',['class' => 'form-horizontal'])?>
    <div class="control-group">
      <label class="control-label"><?=\Yii::t('app','Кодировка')?></label>
      <div class="controls">
        <label class="radio">
          <input type="radio" checked="checked" name="charset" value="utf8"> UTF8 (MacOS)
        </label>
        <label class="radio">
          <input type="radio" name="charset" value="Windows-1251"> Windows-1251 (Microsoft Office)
        </label>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label"><?=\Yii::t('app','Комиссия')?></label>
      <div class="controls">
        <select name="commissionId">
          <option value=""><?=\Yii::t('app', 'Все')?></option>
          <?foreach($commissions as $commission):?>
            <option value="<?=$commission->Id?>"><?=$commission->Title?></option>
          <?endforeach?>
        </select>
      </div>
    </div>
    <div class="control-group">
      <div class="controls">
        <?=\CHtml::submitButton(\Yii::t('app','Получить список'), ['class' => 'btn'])?>
      </div>
    </div>
  <?=\CHtml::endForm()?>
</div>