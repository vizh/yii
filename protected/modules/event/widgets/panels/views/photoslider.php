<?if (!empty($photos)):?>
<div class="row-fluid">
  <ul class="thumbnails">
    <?foreach ($photos as $photo):?>
      <li class="span2">
        <div class="thumbnail">
          <?=\CHtml::image($photo->get240px());?>
          <div class="caption">
            <a href="" class="btn btn-danger"><i class="icon icon-trash icon-white"></i> Удалить</a>
          </div>
        </div>
      </li>
    <?endforeach;?>
  </ul>
</div>
<?else:?>
  <div class="alert alert-info"><?=\Yii::t('app', 'Нет загруженных фотографий для этого мероприятия.');?></div>
<?endif;?>
  
<div class="row-fluid">
  <div class="span2">
    <?=\CHtml::form('','POST',['class' => 'well','enctype' => 'multipart/form-data']);?>
      <?=\CHtml::activeFileField($form, 'Image');?>
      <input type="submit" class="btn btn-info m-top_5" value="<?=\Yii::t('app', 'Добавить фотографию');?>" />
    <?=\CHtml::endForm();?>
  </div>
</div>