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
        <table>
          <thead>
          <tr>
            <th>Название файла</th>
            <th>Дата</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <?foreach ($imports as $import):?>
          <?endforeach;?>
          </tbody>
        </table>
    <?else:?>
        <h4>Еще не было ни одного импорта</h4>
    <?endif;?>


  </div>
</div>

