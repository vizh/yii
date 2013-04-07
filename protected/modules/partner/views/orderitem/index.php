<?php
/**
 * @var $form \partner\models\forms\OrderItemSearch
 * @var $products \pay\models\Product[]
 * @var $orderItems \pay\models\OrderItem[]
 * @var $paySystemStat array
 * @var $paginator \application\components\utility\Paginator
 *
 * @var $this \partner\components\Controller
 */
?>
  <div class="row">
    <div class="span12">
      <?=CHtml::beginForm(Yii::app()->createUrl('/partner/orderitem/index/'), 'get');?>
      <div class="row">
        <div class="span4">
          <?=CHtml::activeLabel($form, 'OrderItem');?>
          <?=CHtml::activeTextField($form, 'OrderItem');?>
        </div>
        <div class="span4">
          <?=CHtml::activeLabel($form, 'Order');?>
          <?=CHtml::activeTextField($form, 'Order');?>
        </div>
        <!--<div class="span4">
          <?=CHtml::activeLabel($form, 'Product');?>
          <?=CHtml::activeTextField($form, 'Product');?>
        </div>-->
        <div class="span4">
          <?=CHtml::activeLabel($form, 'Paid');?>
          <?=CHtml::activeDropDownList($form, 'Paid', $form->getListValues());?>
        </div>
      </div>

      <div class="row">
        <div class="span4">
          <?=CHtml::activeLabel($form, 'Payer');?>
          <?=CHtml::activeTextField($form, 'Payer', array('placeholder' => 'RUNET-ID'));?>
        </div>
        <div class="span4">
          <?=CHtml::activeLabel($form, 'Owner');?>
          <?=CHtml::activeTextField($form, 'Owner', array('placeholder' => 'RUNET-ID'));?>
        </div>
        <div class="span4">
          <?=CHtml::activeLabel($form, 'Deleted');?>
          <?=CHtml::activeDropDownList($form, 'Deleted', $form->getListValues());?>
        </div>
      </div>

      <div class="row indent-top2">
        <div class="span4">
          <button class="btn btn-large" type="submit"><i class="icon-search"></i> Искать</button>
        </div>
      </div>
      <?=CHtml::endForm();?>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
      $('.table a.btn-activation').click( function (e) {
        var msg = 'Вы точно хотите '+ ( $(e.currentTarget).hasClass('btn-success') ? 'активировать' : 'деактивировать') + ' оплату'
        if ( confirm (msg)) {
          $.post('/orderitem/activateajax/', {
                'action'      : $(e.currentTarget).hasClass('btn-success') ? 'activate' : 'deactivate',
                'orderItemId' : $(e.currentTarget).data('orderitemid')
              },
              function (response) {
                if (response.success) {
                  window.location.reload();
                }
                else {
                  alert('Произошла ошибка при активации!');
                }
              }, 'json');
        }
        return false;
      });
    });
  </script>
<?if (!empty($orderItems)):?>
  <div class="row">
    <div class="span12">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>Id</th>
          <th>Дата</th>
          <th>Товар</th>
          <th>Сумма</th>
          <th>Тип&nbsp;оплаты</th>
          <th>Плательщик</th>
          <th>Получатель</th>
          <th>Управление</th>
        </tr>
        </thead>
        <tbody>
        <?foreach ($orderItems as $orderItem):?>
          <?$this->renderPartial('item-row', array('orderItem' => $orderItem));?>
        <?endforeach;?>
        </tbody>
      </table>
    </div>
  </div>
<?else:?>
  <div class="alert">По Вашему запросу заказов не найдено.</div>
<?endif;?>

<?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>