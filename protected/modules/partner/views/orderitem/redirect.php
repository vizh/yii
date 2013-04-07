<?php
/**
 * @var $orderItem \pay\models\OrderItem
 * @var $changedOwner \user\models\User
 */
?>

<script type="text/javascript">
//$( function () {
//  $('input[data-valuefield="RunetId"]').autocomplete({
//    source: "/user/ajax/search",
//    minLength: 2,
//    select: function(e, ui){
//      $('input[name="'+ $(this).data('valuefield')+ '"]').val(ui.item.id);
//    }
//  });
//})
</script>


<div class="row">
  <div class="span12 indent-bottom3">
    <h2>Перенос заказа</h2>
  </div>
</div>

<?=CHtml::beginForm();?>
<?if (\Yii::app()->user->hasFlash('error')):?>
<div class="row">
  <div class="span12 indent-bottom1">
    <div class="alert alert-error"><?=\Yii::app()->user->getFlash('error');?></div>
  </div>
</div>
<?endif;?>
<div class="row">
  <div class="span6">
    <label>Номер заказа:</label>
    <input type="text" value="<?=$orderItem!==null?$orderItem->Id:'';?>" <?=$orderItem!==null?'readonly="readonly"':'';?>  name="OrderItemId"/>
  </div>
  <div class="span6">
    <label>Получатель:</label>
    <input type="text" value="<??> <?php if (!empty($redirectUser)) echo $redirectUser->GetFullName();?>" name="Query" data-valuefield="RunetId" />
    <input type="hidden" value="<?php if (!empty($redirectUser)) echo $redirectUser->RocId;?>" name="RunetId"/>
    <p class="help-block">
      <strong>Заметка:</strong> Просто начните набирать фамилию и имя или rocID пользователя. Здесь автоматически будут отображаться результаты поиска. 
    </p>
  </div>
</div>
<div class="row">
  <div class="span12"><?php echo CHtml::submitButton('Перенести', array('class' => 'btn'));?></div>
</div>
<?php echo CHtml::endForm();?>