<?
/**
 * @var \pay\models\search\admin\booking\Partners $search
 * @var \application\components\controllers\AdminMainController $this
 */

use pay\models\search\admin\booking\PartnerData;
$this->setPageTitle('Партнеры');
?>

<div class="btn-toolbar clearfix">
    <?=\CHtml::link('Выставить счет на питание', ['orderfood'], ['class' => 'btn btn-success pull-right'])?></a>
</div>
<div class="well">
    <?$this->widget('\application\widgets\grid\GridView', [
        'dataProvider'=> $search->getDataProvider(),
        'filter' => $search,
        'columns' => [
            [
                'name' => 'Partner',
                'header' => $search->getAttributeLabel('Partner')
            ],
            [
                'name' => 'Ordered',
                'filter' => false,
                'header' => $search->getAttributeLabel('Ordered')
            ],
            [
                'name' => 'Paid',
                'filter' => false,
                'header' => $search->getAttributeLabel('Paid')
            ],
            [
                'header' => 'Не оплачено',
                'value'  => '$data->Ordered - $data->Paid'
            ],
            [
                'header' => 'Счетов на питание',
                'value'  => '$data->Food'
            ],
            [
                'type' => 'html',
                'value' => function (PartnerData $data) {
                    return \CHtml::link('Редактировать', $this->createUrl('/pay/admin/booking/partner', ['owner' => $data->Partner]), ['class' => 'btn btn-info']);
                }
            ]
        ]
    ])?>
</div>