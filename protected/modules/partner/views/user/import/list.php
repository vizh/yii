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
            <th>&nbsp;</th>
          </tr>
          </thead>
          <tbody>
          <?foreach ($imports as $import):?>
            <tr>
              <td><?=$import->CreationTime;?></td>
              <td><?=sizeof($import->Users);?></td>
              <td><?=sizeof($import->Users(['condition' => '"Users"."Imported"']));?></td>
              <td><a class="btn btn-mini" href="<?=Yii::app()->createUrl('/partner/user/import', ['importId' => $import->Id]);?>">Редактировать</a></td>
            </tr>
          <?endforeach;?>
          </tbody>
        </table>
    <?else:?>
        <h4>Еще не было ни одного импорта</h4>
    <?endif;?>


  </div>
</div>

