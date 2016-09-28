<?php
use company\models\Company;

/**
 * @var \application\components\controllers\AdminMainController $this
 * @var \company\models\search\admin\Company $search
 */

$this->setPageTitle('Компании');
?>
<div class="btn-toolbar">
    <?=\CHtml::link('<i class="fa fa-plus"></i> Добавить компанию', ['edit'], ['class' => 'btn btn-info'])?>
</div>
<div class="well">
    <?$this->widget('\application\widgets\grid\GridView', [
        'dataProvider'=> $search->getDataProvider(),
        'filter' => $search,
        'summaryText' => 'Компании {start}-{end} из {count}.',
        'columns' => [
            [
                'value' => '$data->Id',
                'htmlOptions' => [
                    'style' => 'width:1px;',
                    'class' => 'text-center'
                ]
            ],
            [
                'type' => 'raw',
                'value' => '\CHtml::image($data->getLogo()->get30px());'
            ],
            [
                'name' => 'Name',
                'header' => $search->getAttributeLabel('Name'),
                'type' => 'raw',
                'value' => function (Company $company) {
                    return \CHtml::link($company->Name, ['edit', 'id' => $company->Id]);
                }
            ],
            [
                'header' => $search->getAttributeLabel('Moderators'),
                'value' => 'sizeof($data->LinkModerators)',
                'htmlOptions' => [
                    'class' => 'text-center'
                ],
                'headerHtmlOptions' => [
                    'class' => 'text-center'
                ]
            ],
            [
                'header' => $search->getAttributeLabel('Employments'),
                'value' => 'sizeof($data->EmploymentsAllWithInvisible)',
                'htmlOptions' => [
                    'class' => 'text-center'
                ],
                'headerHtmlOptions' => [
                    'class' => 'text-center'
                ]
            ],
            [
                'type' => 'raw',
                'value' => function (Company $company) {
                    if (!empty($company->RaecUsers)) {
                        return \CHtml::image('/images/icon-raec-red_50.png');
                    }
                    return '';
                }
            ],
            [
                'class' => '\application\widgets\grid\ButtonColumn',
                'template' => '{update}'
            ]
        ],
        'pagerCssClass' => 'pagination text-center'
    ])?>
</div>
