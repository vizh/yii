<?php
/**
 * @var StatController $this
 * @var \application\components\web\ArrayDataProvider $dataProvider
 */

$this->pageTitle = 'Участники мероприятия "Територия смыслов"';
?>

<div class="container">
    <h2 class="text-center"><?=CHtml::encode($this->pageTitle)?></h2>

    <h4 style="margin-top: 50px;"><?=CHtml::encode($groupName)?></h4>
    <?php $this->widget('zii.widgets.grid.CGridView', [
        'dataProvider'=> $dataProvider,
        'itemsCssClass' => 'table table-bordered',
        'template' => '{items}',
        'columns' => [
            [
                'name' => 'group',
                'header' => 'Название смены',
                'sortable' => false
            ],
            [
                'name' => 'total',
                'header' => 'Количество участников',
                'sortable' => false
            ],
            [
                'name' => 'registered',
                'header' => 'Количество зарегистированных участников',
                'sortable' => false
            ]
        ]
    ]) ?>
</div>
