<?
/**
 * @var \partner\components\Controller $this
 * @var \pay\models\Product[] $products
 */
?>
<div class="table-info">
    <div class="table-header">
        <div class="table-caption">
            <?=\Yii::t('app', 'Состав счета');?>
        </div>
    </div>
    <table id="order-items" class="table table-striped">
        <thead>
            <tr>
                <th><?=\Yii::t('app','Получатель');?></th>
                <th><?=\Yii::t('app','Товар');?></th>
                <th><?=\Yii::t('app','Цена');?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <td>
                    <input type="text" placeholder="<?=\Yii::t('app', 'Имя получателя');?>" class="form-control"/>
                    <input type="hidden" name="RunetId" value=""/>
                </td>
                <td colspan="2">
                    <?=\CHtml::dropDownList('ProductId', '', \CHtml::listData($products, 'Id', 'Title'), ['class' => 'form-control']);?>
                </td>
                <td class="text-right">
                    <button class="btn add-order-item" type="submit"><?=\Yii::t('app', 'Добавить');?></button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>