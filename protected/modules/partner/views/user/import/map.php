<?php
/**
 * @var $worksheet \PHPExcel_Worksheet
 * @var $form \partner\models\forms\user\ImportPrepare
 */
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
        <?foreach ($form->getColumns() as $column):?>
          <th><?=$column;?></th>
        <?endforeach;?>
      </tr>
      </thead>
      <tbody>
      <?for ($i = 2; $i < 12; $i++):?>
        <tr>
          <?foreach ($form->getColumns() as $column):?>
            <td><?=$worksheet->getCell($column.$i)->getValue();?></td>
          <?endforeach;?>
        </tr>
      <?endfor;?>
      <tr>
        <?foreach ($form->getColumns() as $column):?>
          <td>
            <?=CHtml::activeDropDownList($form, $column, $form->getColumnValues(), ['class' => 'span2']);?>
          </td>
        <?endforeach;?>
      </tr>
      </tbody>
    </table>

    <div class="control-group">
      <label class="checkbox"><?=CHtml::activeCheckBox($form, 'Notify');?> Уведомлять пользователей о регистрации в RUNET-ID</label>
    </div>

    <div class="control-group">
      <label class="checkbox"><?=CHtml::activeCheckBox($form, 'NotifyEvent');?> Уведомлять пользователей о регистрации на мероприятии</label>
    </div>

    <div class="control-group">
      <label class="checkbox"><?=CHtml::activeCheckBox($form, 'Visible');?> НЕ скрывать новых пользователей</label>
    </div>

    <div class="control-group">
      <div class="controls">
        <input type="submit" value="Продолжить" class="btn"/>
      </div>
    </div>

    <?=CHtml::endForm();?>
  </div>
</div>