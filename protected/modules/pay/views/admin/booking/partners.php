<?
/**
 * @var \pay\models\search\admin\booking\Partners $search
 * @var \application\components\controllers\AdminMainController $this
 */

use pay\models\search\admin\booking\PartnerData;
$this->setPageTitle('Партнеры');
?>

<div class="btn-toolbar">

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
                'type' => 'html',
                'value' => function (PartnerData $data) {
                    return \CHtml::link('Редактировать', $this->createUrl('/pay/admin/booking/partner', ['owner' => $data->Partner]), ['class' => 'btn btn-info']);
                }
            ]
        ]
    ]);?>


<?/*
  <table class="table">
    <thead>
      <th><?=\Yii::t('app', 'Партнер');?></th>
      <th><?=\Yii::t('app', 'Всего');?></th>
      <th><?=\Yii::t('app', 'Оплачено');?></th>
      <th><?=\Yii::t('app', 'Не оплачено');?></th>
      <th></th>
    </thead>
    <tbody>
      <?foreach ($results as $result):?>
      <tr>
        <td><strong><?=$result->Partner;?></strong></td>
        <td><?=$result->Ordered;?></td>
        <td class="text-success"><?=$result->Paid;?></td>
        <td><?=$result->Ordered-$result->Paid;?></td>
        <td style="width: 1px;"><a href="<?=$this->createUrl('/pay/admin/booking/partner', ['owner' => $result->Partner]);?>" class="btn btn-info"><?=\Yii::t('app', 'Редактировать');?></a></td>
      </tr>
      <?endforeach;?>
    </tbody>
  </table>
*/?>
</div>