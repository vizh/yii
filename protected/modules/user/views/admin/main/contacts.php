<?php
use user\models\search\admin\Contacts;
use user\models\User;
use application\components\controllers\AdminMainController;

/**
 * @var AdminMainController $this
 * @var Contacts $search
 */
$this->setPageTitle('Контакты польльзователей');
?>
<div class="btn-toolbar"></div>
<div class="well">
    <?$this->widget('\application\widgets\grid\GridView', [
        'dataProvider'=> $search->getDataProvider(),
        'filter' => $search,
        'itemsCssClass' => 'table table-bordered',
        'htmlOptions' => ['style' => 'font-size: 70%'],
        'pager' => [
            'pageSize' => 100,
        ],
        'columns' => [
            [
                'header' => $search->getAttributeLabel('RunetId'),
                'name' => 'Query',
                'value' => '$data->RunetId',
                'filterHtmlOptions' => [
                    'colspan' => 11
                ],
                'filterInputHtmlOptions' => [
                    'class' => 'input-block-level'
                ]
            ],
            [
                'header' => $search->getAttributeLabel('FirstName'),
                'value' => '$data->FirstName'
            ],
            [
                'header' => $search->getAttributeLabel('LastName'),
                'value' => '$data->LastName'
            ],
            [
                'header' => $search->getAttributeLabel('FatherName'),
                'value' => '$data->FatherName'
            ],
            [
                'header' => $search->getAttributeLabel('Email'),
                'value' => '$data->Email'
            ],
            [
                'header' => $search->getAttributeLabel('Phone'),
                'value' => '$data->getPhone()'
            ],
            [
                'header' => $search->getAttributeLabel('Birthday'),
                'value' => '\Yii::app()->getDateFormatter()->format(\'dd.MM.yyyy\', $data->Birthday);'
            ],
            [
                'header' => $search->getAttributeLabel('Company'),
                'value' => function (User $user) {
                    $employment = $user->getEmploymentPrimary();
                    return $employment !== null ? $employment->Company->Name : '';
                }
            ],
            [
                'header' => $search->getAttributeLabel('Position'),
                'value' => function (User $user) {
                    $employment = $user->getEmploymentPrimary();
                    return $employment !== null ? $employment->Position : '';
                }
            ],
            [
                'header' => $search->getAttributeLabel('IriEcoSystem'),
                'value' => function (User $user) {
                    $iri = $user->IRIParticipantsActive;
                    return !empty($iri) && !empty($iri[0]->ProfessionalInterest) ? $iri[0]->ProfessionalInterest->Title : '';
                }
            ],
            [
                'header' => $search->getAttributeLabel('IriRole'),
                'value' => function (User $user) {
                    $iri = $user->IRIParticipantsActive;
                    return !empty($iri) ? $iri[0]->Role->Title : '';
                }
            ]
        ],
        'pagerCssClass' => 'pagination text-center'
    ])?>
</div>
