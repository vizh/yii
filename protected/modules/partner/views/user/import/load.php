<?php
/**
 * @var $activeFields array
 * @var $rows array
 * @var $form \partner\models\forms\user\ImportPrepare
 */
$form->clearErrors('Submit');
?>

<div class="row">
  <div class="span12">

    <?=CHtml::beginForm();?>

    <h3>Выберите соответствие столбцов и полей данных</h3>

    <?if ($form->hasErrors()):?>
        <?=CHtml::errorSummary($form, '', null, array('class' => 'alert alert-error'));?>
    <?endif;?>

    <table class="table table-bordered">
      <thead>
      <tr>
        <?foreach ($activeFields as $field):?>
          <th>Столбец <?=$field+1;?></th>
        <?endforeach;?>
      </tr>
      </thead>
      <tbody>
      <?foreach ($rows as $row):?>
        <tr>
          <?foreach ($form->getFields() as $key => $value):?>
            <?if (in_array($value, $activeFields)):?>
              <td><?=$row->$key;?></td>
            <?endif;?>
          <?endforeach;?>
        </tr>
      <?endforeach;?>

      <tr>
        <?foreach ($form->getFields() as $key => $value):?>
          <?if (in_array($value, $activeFields)):?>
            <td>
              <?=CHtml::activeDropDownList($form, $key, $form->getFieldNames());?>
            </td>
          <?endif;?>
        <?endforeach;?>
      </tr>
      </tbody>
    </table>

    <div class="control-group">
      <label class="checkbox"><?=CHtml::activeCheckBox($form, 'Notify');?> Уведомлять пользователей о регистрации в RUNET-ID</label>
    </div>

    <div class="control-group">
      <label class="checkbox"><?=CHtml::activeCheckBox($form, 'NotifyEvent');?> Уведомлять пользователей о регистрации в RUNET-ID</label>
    </div>

    <div class="control-group">
      <label class="checkbox"><?=CHtml::activeCheckBox($form, 'Visible');?> Скрывать новых пользователей</label>
    </div>

    <div class="control-group">
      <div class="controls">
        <input type="submit" value="Продолжить" class="btn"/>
        <?=CHtml::activeHiddenField($form, 'Submit', array('value' => 1));?>
      </div>
    </div>

    <?=CHtml::endForm();?>
  </div>
</div>