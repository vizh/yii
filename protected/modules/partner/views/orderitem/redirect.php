<script type="text/javascript">
$( function () {
  $('input[data-valuefield="RocId"]').autocomplete({
    source: "/user/ajaxget/",
    minLength: 2,
    select: function(e, ui){
      $('input[name="'+ $(this).data('valuefield')+ '"]').val(ui.item.id);
    }
  });
})
</script>


<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Перенос заказа</h2>
  </div>
</div>

<?php echo CHtml::beginForm();?>
<?php if (\Yii::app()->user->hasFlash('error')):?>
<div class="row">
  <div class="span12 indent-bottom1">
    <div class="alert alert-error"><?php echo \Yii::app()->user->getFlash('error');?></div>
  </div>
</div>
<?php endif;?>
<div class="row">
  <div class="span6">
    <label>Номер заказа:</label>
    <input type="text" value="<?php if (!empty($_REQUEST['OrderItemId'])) echo $_REQUEST['OrderItemId'];?>" name="OrderItemId"/>
  </div>
  <div class="span6">
    <label>Получатель:</label>
    <input type="text" value="<?php if (!empty($redirectUser)) echo $redirectUser->GetFullName();?>" name="" data-valuefield="RocId" />
    <input type="hidden" value="<?php if (!empty($redirectUser)) echo $redirectUser->RocId;?>" name="RocId"/>
    <p class="help-block">
      <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска. 
    </p>
  </div>
</div>
<div class="row">
  <div class="span12"><?php echo CHtml::submitButton('Перенести', array('class' => 'btn'));?></div>
</div>
<?php echo CHtml::endForm();?>