<?php
/**
 * @var Participant $search
 * @var Event $event
 * @var \partner\models\forms\user\RoleBulkChange $bulkRoleChange
 * @var Controller $this
 */

use application\modules\partner\models\search\Participant;
use event\models\Event;
use event\models\Participant as EventParticipant;
use partner\components\Controller;
use user\models\User;

$this->setPageTitle(\Yii::t('app', 'Поиск участников мероприятия'));
$controller = $this;

?>
<? $this->beginClip(Controller::PAGE_HEADER_CLIP_ID) ?>
<?= \CHtml::link('<span class="btn-label fa fa-plus"></span> ' . \Yii::t('app', 'Добавить участника'), ['find'], ['class' => 'btn btn-primary btn-labeled']) ?>
<? $this->endClip() ?>


<div class="panel panel-info">

    <?php
    /** @var CActiveForm $form */
    $form = $this->beginWidget('CActiveForm');
    ?>

    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-group"></i> <?= \Yii::t('app', 'Участники') ?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <? $this->widget('\application\widgets\grid\GridView', [
                'dataProvider' => $search->getDataProvider(),
                'filter' => $search,
                'summaryText' => 'Пользователи {start}-{end} из {count}.',
                'columns' => [
                    [
                        'class' => 'zii.widgets.grid.CCheckBoxColumn',
                        'selectableRows' => 1000,
                        'checkBoxHtmlOptions' => [
                            'name' => 'RoleBulkChange[Ids][]',
                            'value' => '$data->Id'
                        ]
                    ],
                    [
                        'name' => 'Query',
                        'type' => 'raw',
                        'header' => 'RUNET-ID',
                        'value' => function (User $user) {
                            return \CHtml::link(\CHtml::tag('strong', ['class' => 'lead'], $user->RunetId), $user->getUrl(), ['target' => '_blank']);
                        },
                        'filterHtmlOptions' => [
                            'colspan' => 2
                        ],
                        'width' => 120
                    ],
                    [
                        'name' => 'Name',
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Name'),
                        'value' => function (User $user) use ($controller) {
                            return $controller->renderPartial('../partial/grid/user', ['user' => $user, 'hideId' => true, 'hideEmployment' => true], true);
                        },
                        'htmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'headerHtmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'width' => '20%'
                    ],
                    [
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Company'),
                        'name' => 'Company',
                        'value' => function (User $user) {
                            $employment = $user->getEmploymentPrimary();
                            if ($employment !== null) {
                                return \CHtml::tag('strong', [], $employment->Company->Name) .
                                    \CHtml::tag('p', [], $employment->Position);
                            } else {
                                return \Yii::t('app', 'Место работы не указано');
                            }
                        },
                        'htmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'headerHtmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'width' => '30%'
                    ],
                    [
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Role'),
                        'name' => 'Role',
                        'value' => function (User $user) use ($event) {
                            $dateFormatter = \Yii::app()->getDateFormatter();

                            /**
                             * Если у мероприятия нет частей, то может быть только один статус
                             */
                            if (empty($event->Parts)) {
                                $participant = EventParticipant::model()
                                    ->byUserId($user->Id)
                                    ->byEventId($event->Id)
                                    ->find();
                                return $participant->Role->Title . '<br/><em>' . $dateFormatter->formatDateTime($participant->CreationTime, 'long') . '</em>';
                                /**
                                 * Иначе берем все статусы
                                 */
                            } else {
                                $participants = EventParticipant::model()
                                    ->byUserId($user->Id)
                                    ->byEventId($event->Id)
                                    ->findAll();
                                $result = '';
                                foreach ($participants as $participant) {
                                    if (null === $participant->Part) {
                                        continue;
                                    }

                                    $result .= '<p>' .
                                        \CHtml::tag('strong', [], $participant->Part->Title) . ' - ' . $participant->Role->Title . '<br/>' .
                                        '<em>' . $dateFormatter->format($participant->CreationTime, 'long') . '</em>' .
                                        '</p>';
                                }
                                return $result;
                            }
                        },
                        'htmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'headerHtmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'filter' => [
                            'class' => '\partner\widgets\grid\MultiSelect',
                            'items' => $search->getRoleData()
                        ],
                        'width' => '20%'
                    ],
                    [
                        'type' => 'raw',
                        'name' => 'Document',
                        'header' => $search->getAttributeLabel('Document'),
                        'visible' => $event->getIsRequiredDocument(),
                        'value' => function (User $user) {
                            if (!empty($user->Documents)) {
                                return \CHtml::tag('span', ['class' => 'label label-success'], \Yii::t('app', 'Заполнен'));
                            } else {
                                return \CHtml::tag('span', ['class' => 'label label-danger'], \Yii::t('app', 'Не заполнен'));
                            }
                        },
                        'filter' => [0 => \Yii::t('app', 'Не заполнен'), 1 => \Yii::t('app', 'Заполнен')]
                    ],
                    [
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Ruvents'),
                        'name' => 'Ruvents',
                        'value' => function (User $user) use ($controller, $event) {
                            $result = '';
                            $badge = $user->getEventBage($event->Id);
                            if ($badge) {
                                $dateFormatter = \Yii::app()->getDateFormatter();
                                $result .= $dateFormatter->format('dd.MM.yyyy HH:mm', $badge->CreationTime) . '<br/>';
                                $result .= \CHtml::tag('em', [], $badge->Operator->Login);
                                if ($this->getAccessFilter()->checkAccess('partner', 'ruvents', 'userlog')) {
                                    $result .= \CHtml::tag('p', [], \CHtml::link(\Yii::t('app', 'Подробнее'), ['ruvents/userlog', 'runetId' => $user->RunetId, 'backUrl' => \Yii::app()->getRequest()->getRequestUri()], ['class' => 'btn btn-xs m-top_5']));
                                }

                            }
                            return $result;

                        },
                        'htmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'headerHtmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'filter' => false,
                        'width' => 150
                    ],
                    [
                        'class' => '\application\widgets\grid\ButtonColumn',
                        'buttons' => [
                            'ticket' => [
                                'label' => '<i class="fa fa-ticket"></i>',
                                'url' => function ($user) use ($event) {
                                    return EventParticipant::model()
                                        ->byUserId($user->Id)
                                        ->byEventId($event->Id)
                                        ->find()
                                        ->getTicketUrl();
                                },
                                'options' => [
                                    'class' => 'btn btn-default',
                                    'target' => '_blank',
                                    'title' => 'Билет'
                                ]
                            ]
                        ],
                        'template' => '{update}{ticket}',
                        'updateButtonUrl' => 'Yii::app()->controller->createUrl("edit",["id" => $data->RunetId])'
                    ]
                ]
            ]) ?>
        </div>
    </div> <!-- / .panel-body -->
    <div class="panel-footer">
        <div class="form-group">
            <?= $form->dropDownList(
                $bulkRoleChange,
                'RoleId',
                ['' => 'Выберите статус', '-1' => 'УДАЛИТЬ'] + $search->getRoleData(),
                ['name' => 'RoleBulkChange[RoleId]']
            ); ?>
        </div>

        <div class="form-group">
            <?= CHtml::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>