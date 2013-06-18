<?php
/**
 * @var string[] $roleNames
 * @var \event\models\Role[] $roles
 * @var array $values
 * @var string $error
 */
?>

<div class="row">
  <div class="span12">

    <?=CHtml::beginForm();?>

    <h3>Выберите соответствие столбцов и полей данных</h3>

    <?if (!empty($error)):?>
      <div class="alert alert-error">
        <p><?=$error;?></p>
      </div>
    <?endif;?>

    <table class="table table-bordered">
      <thead>
      <tr>
        <td>Поле из файла</td>
        <td>Роль</td>
      </tr>
      </thead>
      <tbody>
      <?foreach ($roleNames as $name):?>
          <tr>
            <td><?=$name;?></td>
            <td>
              <select name="values[<?=$name;?>]">
                <option value="0">не задана</option>
                <?foreach ($roles as $role):?>
                  <option value="<?=$role->Id;?>" <?=isset($values[$name]) && $values[$name] == $role->Id ? 'selected="selected"' : '';?>><?=$role->Title;?></option>
                <?endforeach;?>
              </select>
            </td>
          </tr>
      <?endforeach;?>
      </tbody>
    </table>

    <div class="control-group">
      <div class="controls">
        <input type="submit" value="Продолжить" class="btn"/>
      </div>
    </div>

    <?=CHtml::endForm();?>
  </div>
</div>