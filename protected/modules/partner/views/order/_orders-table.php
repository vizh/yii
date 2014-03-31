<?
/**
 * @var OrderController $this
 * @var \pay\models\Product[] $products
 */
?>
<table id="order-items" class="table">
  <thead>
  <th><?=\Yii::t('app','Получатель');?></th>
  <th><?=\Yii::t('app','Товар');?></th>
  <th><?=\Yii::t('app','Цена');?></th>
  <th></th>
  </thead>
  <tbody>

  </tbody>
  <tfoot>
  <tr>
    <td>
      <input type="text" placeholder="<?=\Yii::t('app', 'Имя получателя');?>"/>
      <input type="hidden" name="RunetId" value=""/>
    </td>
    <td colspan="2">
      <?=\CHtml::dropDownList('ProductId', '', \CHtml::listData($products, 'Id', 'Title'), ['class' => 'input-xxlarge']);?>
    </td>
    <td style="padding-top: 11px;">
      <button class="btn btn-mini pull-right add-order-item" type="submit"><?=\Yii::t('app', 'Добавить');?></button>
    </td>
  </tr>
  </tfoot>
</table>