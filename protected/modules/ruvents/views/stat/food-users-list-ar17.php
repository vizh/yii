<?php
/**
 * @var StatController $this
 * @var CActiveDataProvider $dataProvider
 * @var string $groupName
 * @var int $eventId
 */

use ruvents\models\Visit;

$this->pageTitle = 'Статистика питания';
?>

<div class="container">

    <h2 class="text-center"><?=CHtml::encode($this->pageTitle)?></h2>

    <h4 style="margin-top: 50px;"><?=CHtml::encode($groupName)?></h4>

    <?=Html::link('скачать список', ['stat/downloadlist', 'eventId' => $eventId, 'group' => $groupName], [
        'class' => 'btn btn-warning btn-lg',
        'target' => '_blank'
    ])?>

    <?$this->widget('zii.widgets.grid.CGridView', [
        'dataProvider'=> $dataProvider,
        'itemsCssClass' => 'table table-bordered',
        'summaryText' => 'Всего {count} человек(а)',
        'rowCssClassExpression' => function ($row, Visit $visit, $grid) use ($eventId) {
            $errorClass = 'error';

            if (!$visit->UserData) {
                return $errorClass;
            }

            $man = $visit->UserData->getManager();
            if( !isset($man->pitanie) ){
                return '';
            }
            $pitanie = $man->pitanie;
            return !is_null($pitanie) && strtolower($pitanie) === 'net' ? 'error' : '';
        },
        'rowHtmlOptionsExpression' => function ($row, Visit $visit, $grid) {
            return ['key' => $visit->User->RunetId];
        },
        'columns' => [
            [
                'name' => 'Name',
                'header' => 'RUNET-ID',
                'value' => function (Visit $visit) {
                    return $visit->User->RunetId;
                }
            ],
            [
                'name' => 'Name',
                'header' => 'Ф.И.О.',
                'value' => function (Visit $visit) {
                    return $visit->User->getFullName();
                }
            ],
            [
                'name' => 'CreationTime',
                'header' => 'Дата / время',
                'value' => function (Visit $visit) {
                    return \Yii::app()->getDateFormatter()->format('dd.MM.yyyy HH:mm:ss', $visit->CreationTime);
                },
                'sortable' => false
            ],
            [
                'name' => 'Status',
                'header' => 'Статус',
                'value' => function (Visit $visit) {
                    $status = $visit->Participants[0]->Role;
                    $man = $visit->UserData->getManager();

                    $subStatus = '';
                    if( isset($man->last_status) ) {
                        $subStatus = $man->last_status;
                    }

                    return Html::tag('b', [], $status) . '<br>' . ($subStatus ? "($subStatus)" : '');
                },
                'type' => 'raw',
                'filter' => false
            ]
        ]
    ])?>
</div>