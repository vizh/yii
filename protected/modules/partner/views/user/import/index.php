<?php
/**
 * @var $imports \partner\models\Import[]
 */
?>

<div class="row">
  <div class="span12">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="control-group">
        <label class="control-label">Загрузите файл для импорта</label>
        <div class="controls">
          <input type="file" name="import_file">
        </div>
      </div>

      <div class="control-group">
        <div class="controls"><input type="submit" value="Загрузить" class="btn"/></div>
      </div>
    </form>




    <?if (sizeof($imports) > 0):?>
        <table class="table table-bordered">
          <thead>
          <tr>
            <th>Дата</th>
            <th>Всего</th>
            <th>Импортировано</th>
            <th>Ошибок</th>
            <th>&nbsp;</th>
          </tr>
          </thead>
          <tbody>
          <?foreach ($imports as $import):?>
            <tr>
              <td><?=$import->CreationTime;?></td>
              <td><?=sizeof($import->Users);?></td>
              <?$countImported = sizeof($import->Users(['condition' => '"Users"."Imported"']));?>
              <td><?=$countImported;?></td>
              <?$countErrorUsers = sizeof($import->Users(['condition' => '"Users"."Error"']));?>
              <td><?=$countErrorUsers;?></td>
              <td>
                <?if ($countImported > 0 && $countImported == sizeof($import->Users)):?>
                  <span class="label label-success">Импорт завершен</span>
                <?elseif ($countErrorUsers > 0):?>
                  <a class="btn btn-mini" href="<?=Yii::app()->createUrl('/partner/user/importerrors', ['id' => $import->Id]);?>">Исправить ошибки</a>
                  <?elseif ($import->Fields == null):?>
                  <a class="btn btn-mini" href="<?=Yii::app()->createUrl('/partner/user/importmap', ['id' => $import->Id]);?>">Задать поля</a>
                <?elseif ($import->Roles == null):?>
                  <a class="btn btn-mini" href="<?=Yii::app()->createUrl('/partner/user/importroles', ['id' => $import->Id]);?>">Задать роли</a>
                <?endif;?>
              </td>
            </tr>
          <?endforeach;?>
          </tbody>
        </table>
    <?else:?>
        <h4>Еще не было ни одного импорта</h4>
    <?endif;?>


  </div>
</div>

