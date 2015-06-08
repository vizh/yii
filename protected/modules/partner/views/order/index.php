<?php
/**
 * @var \partner\components\Controller $this
 * @var \application\modules\partner\models\search\Orders $search
 */

use pay\models\Order;
use pay\models\OrderType;

$this->setPageTitle(\Yii::t('app', 'Поиск счетов'));
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-ticket"></i> <?=\Yii::t('app', 'Промо-коды мероприятия');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> $search->getDataProvider(),
                'filter' => $search,
                'summaryCssClass' => 'table-header',
                'summaryText' => 'Счета {start}-{end} из {count}.',
                'columns' => [
                    [
                        'name'  => 'Number',
                        'type'  => 'raw',
                        'header'=> $search->getAttributeLabel('Number'),
                        'value' => function (Order $order) {
                            return \CHtml::tag('span', ['class' => 'lead'], $order->Number);
                        }
                    ],
                    [
                        'name'  => 'Type',
                        'type'  => 'raw',
                        'header'=> $search->getAttributeLabel('Type'),
                        'value' => function (Order $order) {
                            if ($order->Type == OrderType::Juridical) {
                                $result = \CHtml::tag('span', ['class' => 'label label-info'], \Yii::t('app', 'Юр. счет'));
                                $result.= '<p class="small m-top_5">' . $order->OrderJuridical->Name. ', ' . \Yii::t('app', 'ИНН/КПП:') . ' ' . $order->OrderJuridical->INN . '/' . $order->OrderJuridical->KPP . '</p>';
                                return $result;
                            } elseif ($order->Type == OrderType::Receipt) {
                                return \CHtml::tag('span', ['class' => 'label label-warning'], \Yii::t('app', 'Квитанция'));
                            } else {
                                return \CHtml::tag('span', ['class' => 'label label-primary'], \Yii::t('app', 'Через платежную систему.'));
                            }
                        }
                    ],
                    [
                        'name'  => 'Payer',
                        'type'  => 'raw',
                        'header'=> $search->getAttributeLabel('Payer'),
                        'value' => '\CHtml::link(\CHtml::tag("span", ["class" => "lead"], $data->Payer->RunetId), ["user/edit", "id" => $data->Payer->RunetId], ["target" => "_blank"]);',
                        'headerHtmlOptions' => [
                            'colspan' => 2
                        ],
                        'filterHtmlOptions' => [
                            'colspan' => 2
                        ],
                    ],
                    [
                        'type' => 'raw',
                        'value' => function (Order $order) {
                            $user = $order->Payer;
                            $result = \CHtml::tag('strong', [], $user->getFullName());
                            if (($employment = $user->getEmploymentPrimary()) !== null) {
                                $result .= '<br/>' . $employment;
                            }
                            $result.='<p class="m-top_5"><i class="fa fa-envelope-o"></i> ' . $user->Email;
                            if (($phone = $user->getPhone()) !== null) {
                                $result.='<br/><i class="fa fa-phone"></i> ' . $phone;
                            }
                            $result.='</p>';
                            return $result;
                        },
                        'htmlOptions' => ['class' => 'text-left']
                    ],
                    [
                        'name' => 'CreationTime',
                        'header' => $search->getAttributeLabel('CreationTime'),
                        'value' => 'Yii::app()->locale->getDateFormatter()->format("d MMMM y", $data->CreationTime)',
                        'filter' => false
                    ],
                    [
                        'name' => 'Status',
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Status'),
                        'value' => function (Order $order) {
                            if ($order->Paid) {
                                $result = \CHtml::tag('span', ['class' => 'label label-success'], \Yii::t('app', 'Оплачен'));
                                $result.= '<p class="small m-top_5">' . \Yii::app()->getDateFormatter()->format('d MMMM y', $order->PaidTime) . '</p>';
                                return $result;
                            } elseif ($order->Deleted) {
                                return \CHtml::tag('span', ['class' => 'label label-danger'], \Yii::t('app', 'Удален'));
                            } else {
                                return \CHtml::tag('span', ['class' => 'label'], \Yii::t('app', 'Не оплачен'));
                            }
                        }
                    ],
                    [
                        'name' => 'Price',
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Price'),
                        'value' => '$data->getPrice() . "&nbsp;руб."',
                        'filter' => false
                    ],
                    [
                        'class' => '\application\widgets\grid\ButtonColumn',
                        'template' => '{view}{update}{print}',
                        'buttons' => [
                            'update' => [
                                'visible' => '$data->getIsBankTransfer() && !$data->Paid'
                            ],
                            'print' => [
                                'label' => '<i class="fa fa-print"></i>',
                                'url' => '$data->getUrl(true)',
                                'options' => [
                                    'class'  => 'btn btn-default',
                                    'target' => '_blank',
                                    'title'  => 'Печать'
                                ],
                                'visible' => '$data->getIsBankTransfer()'
                            ]
                        ]
                    ]
                ]
            ]);?>
        </div>
    </div>
</div>

<?/*
<div class="row">

  <div class="span12">
    <?=CHtml::beginForm('', 'get');?>
    <div class="row">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Order');?>
        <?=CHtml::activeTextField($form, 'Order');?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Paid');?>
        <?=CHtml::activeDropDownList($form, 'Paid', $form->getListValues());?>
      </div>
      <div class="span4">
        <label>&nbsp;</label>
        <label class="checkbox">
          <?=CHtml::activeCheckBox($form, 'Deleted');?>
          <?=$form->getAttributeLabel('Deleted');?>
        </label>
      </div>
    </div>

    <div class="row">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Company');?>
        <?=CHtml::activeTextField($form, 'Company');?>
      </div>
      <div class="span4">
        <?=CHtml::activeLabel($form, 'INN');?>
        <?=CHtml::activeTextField($form, 'INN');?>
      </div>
    </div>

    <div class="row">
      <div class="span4">
        <?=CHtml::activeLabel($form, 'Payer');?>
        <?=CHtml::activeTextField($form, 'Payer', array('placeholder' => 'RUNET-ID'));?>
      </div>
      <div class="offset4 span4">
        <button class="btn btn-large" type="submit"><i class="icon-search"></i> Искать</button>
      </div>
    </div>
    <?=CHtml::endForm();?>
  </div>

  <div class="span12">
    <?if ($paginator->getCount() > 0):?>
      <table class="table table-striped">
        <thead>
        <tr>
          <th>№ счета</th>
          <th class="span4">Краткие данные</th>
          <th class="span3">Выставил</th>
          <th>Дата создания</th>
            <th>Оплата</th>
          <th>Сумма</th>
          <th class="span2">Управление</th>
        </tr>
        </thead>

        <tbody>
        <?foreach ($orders as $order):?>
          <tr>
            <td>






              <?=CHtml::beginForm(\Yii::app()->createUrl('/partner/order/view', array('orderId' => $order->Id)));?>
                <div class="btn-group">

                  <a class="btn btn-info" href="<?=\Yii::app()->createUrl('/partner/order/view', array('orderId' => $order->Id));?>"><i class="icon-list icon-white"></i></a>
                  <?if (!$order->Paid && ($order->getIsBankTransfer() || Yii::app()->partner->getAccount()->getIsAdmin())):?>
                    <button class="btn btn-success" type="submit" onclick="return confirm('Вы уверены, что хотите отметить данный счет оплаченным?');" name="SetPaid"><i class="icon-ok icon-white"></i></button>
                  <?else:?>
                    <button class="btn btn-success disabled" disabled type="submit" name="SetPaid"><i class="icon-ok icon-white"></i></button>
                  <?endif;?>



                  <?if ($order->getIsBankTransfer()):?>
                    <a class="btn" target="_blank" href="<?=$order->getUrl(true);?>"><i class="icon-print"></i></a>
                  <?else:?>
                    <a class="btn disabled" target="_blank"><i class="icon-print"></i></a>
                  <?endif;?>
                </div>
              <?=CHtml::endForm();?>
              
            </td>
          </tr>
        <?endforeach;?>
        </tbody>

      </table>


      <?$this->widget('\application\widgets\Paginator', array('paginator' => $paginator));?>

    <?else:?>
      <div class="alert">
        <strong>Внимание!</strong> Нет ни одного счета с заданными параметрами.
      </div>
    <?endif;?>
  </div>

  <div class="span12 indent-bottom3"></div>
</div>
*/?>