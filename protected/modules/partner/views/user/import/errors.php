<?php
/**
 * @var $users \partner\models\ImportUser[]
 */
?>

<div class="row">
  <div class="span12">
    <?=CHtml::beginForm();?>
    <h3>Исправление ошибок</h3>

    <table class="table table-bordered">
      <thead>
      <tr>
        <th class="span4">Ошибка</th>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Email</th>
      </tr>
      </thead>
      <tbody>
      <?foreach ($users as $user):?>
        <tr>
          <td><?=$user->ErrorMessage;?></td>
          <td><?=CHtml::textField('users['.$user->Id.'][LastName]', $user->LastName);?></td>
          <td><?=CHtml::textField('users['.$user->Id.'][FirstName]', $user->FirstName);?></td>
          <td><?=CHtml::textField('users['.$user->Id.'][Email]', $user->Email);?></td>
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