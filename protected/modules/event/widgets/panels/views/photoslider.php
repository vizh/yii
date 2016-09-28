<?if(!empty($photos)):?>
<script type="text/javascript">
  $(function () {
    $('.thumbnails').sortable({
      update : function (event,ui) {
        var positions = new Object();
        $.each($(this).find('li.span2'), function (i, item) {
          positions[$(item).data('photo-id')] = i+1;
          $(item).data('photo-id', i+1);
        });
        $.post('', {Positions : positions, Action : 'AjaxSort'});
      }
    }).disableSelection();

    $('.thumbnails .thumbnail .btn-danger').click(function (e) {
      if (confirm("<?=\Yii::t('app', 'Вы точно хотите удалить фотографию')?>")) {
        var li = $(e.currentTarget).parents('li');
        $.post('', {Action : 'AjaxDelete', PhotoId : li.data('photo-id')});
        li.remove();
      }
      return false;
    });
  });
</script>
<div class="row-fluid">
  <ul class="thumbnails">
    <?foreach($photos as $photo):?>
      <li class="span2" data-photo-id="<?=$photo->getId()?>" style="margin-left: 0; margin-right: 30px;">
        <div class="thumbnail">
          <?=\CHtml::image($photo->get240px().'?'.time())?>
          <div class="caption">
            <a href="#" class="btn btn-danger"><i class="icon icon-trash icon-white"></i> <?=\Yii::t('app', 'Удалить')?></a>
          </div>
        </div>
      </li>
    <?endforeach?>
  </ul>
</div>
<?else:?>
  <div class="alert alert-info"><?=\Yii::t('app', 'Нет загруженных фотографий для этого мероприятия.')?></div>
<?endif?>

<div class="row-fluid">
  <div class="span2">
    <?=\CHtml::form('','POST',['class' => 'well','enctype' => 'multipart/form-data'])?>
      <?=\CHtml::activeFileField($form, 'Image')?>
      <input type="submit" class="btn btn-info m-top_5" value="<?=\Yii::t('app', 'Добавить фотографию')?>" />
    <?=\CHtml::endForm()?>
  </div>
</div>