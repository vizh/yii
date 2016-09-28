<?php
/**
 * @var partner\components\Controller $this
 * @var pay\models\forms\Juridical $form
 */

?>
<div class="table-info">
    <div class="table-header">
        <div class="table-caption">
            <?=\Yii::t('app', 'Состав счета')?>
        </div>
    </div>
    <table id="order-items" class="table table-striped">
        <thead>
            <tr>
                <th><?=Yii::t('app','Получатель')?></th>
                <th><?=Yii::t('app','Товар')?></th>
                <th><?=Yii::t('app','Цена')?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="item in orderItems" ng-if="!loading">
                <td ng-bind-html="item.owner" class="text-left"></td>
                <td>{{item.product.Title}}</td>
                <td>{{item.price}} <?=Yii::t('app', 'руб')?>.</td>
                <td style="width: 1px;" class="text-nowrap">
                    <a href="" ng-click="removeOrderItem(item, $index)" class="btn btn-danger"><i class="fa fa-times"></i></a>
                </td>
            </tr>
            <tr ng-if="loading">
                <td colspan="4" class="text-center"><?=Yii::t('app', 'Загрузка заказов...')?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr ng-if="newOrderItem.error !== undefined">
                <td colspan="4">
                    <div class="alert alert-danger m-bottom_0">{{newOrderItem.error}}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" placeholder="<?=Yii::t('app', 'Получатель')?>" class="form-control" userautocomplete>
                </td>
                <td colspan="2">
                    <?=CHtml::dropDownList('ProductId', '', $form->getProductData(), ['class' => 'form-control', 'ng-model' => 'newOrderItem.productId'])?>
                </td>
                <td class="text-nowrap" style="width: 1px;">
                    <button class="btn add-order-item" type="button" ng-click="addOrderItem()"><?=Yii::t('app', 'Добавить')?></button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>