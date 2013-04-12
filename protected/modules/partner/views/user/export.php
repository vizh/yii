<?php
/**
 * @var $roles \event\models\Role[]
 */
?>
<div class="span12">
  <form class="form-horizontal" method="POST">
    <div class="control-group">
      <label class="control-label">Кодировка</label>
      <div class="controls">
        <label class="radio">
          <input type="radio" value="utf8" name="charset" checked="checked"> UTF8 (MacOS)
        </label>
        <label class="radio">
          <input type="radio" value="Windows-1251" name="charset"> Windows-1251 (Microsoft Office)
        </label>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Выберите роли для экспорта</label>
      <div class="controls">
        <select name="roles[]" id="" multiple="multiple" size="<?=sizeof($roles);?>">
          <?foreach ($roles as $role):?>
            <option value="<?= $role->Id;?>"><?=$role->Title;?></option>
          <?endforeach;?>
        </select>
      </div>
    </div>

    <div class="control-group">
      <div class="controls"><input type="submit" value="Получить список" class="btn"/></div>
    </div>
  </form>
</div>