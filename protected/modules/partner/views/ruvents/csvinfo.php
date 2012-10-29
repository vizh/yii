<div class="row indent-top2">
  <div class="span12">
    <a class="btn btn-info btn-large" href="<?=\Yii::app()->createUrl('/partner/ruvents/csvinfo', array('generate' => 1));?>">Генерировать новый список</a>
  </div>
</div>

<?if (!empty($fileList)):?>
<div class="row indent-top3">
  <div class="span12">
    <h3 class="indent-bottom1">Ранее генерированные списки</h3>

    <ol>
      <?foreach ($fileList as $file):?>
      <li><a target="_blank" href="<?=\Yii::app()->createUrl('/partner/ruvents/csvinfo', array('file' => $file));?>"><?=$file;?></a></li>
      <?endforeach;?>
    </ol>
  </div>
</div>
<?endif;?>