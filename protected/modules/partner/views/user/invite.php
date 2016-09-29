<?php
/**
 * @var \partner\components\Controller $this
 * @var \partner\models\search\InviteRequest $search
 * @var \event\models\Event $event
 */

use event\models\InviteRequest;
use event\models\Approved;

$controller = $this;
$this->setPageTitle(\Yii::t('app', 'Приглашения'))
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-question-circle"></i> <?=\Yii::t('app', 'Заявки от пользователей')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> $search->getDataProvider(),
                'filter' => $search,
                'summaryText' => 'Приглашения {start}-{end} из {count}.',
                'columns' => [
                    [
                        'header' => $search->getAttributeLabel('Sender'),
                        'name' => 'Sender',
                        'type' => 'raw',
                        'value' => function (InviteRequest $inviteRequest) use ($controller) {
                            return $controller->renderPartial('../partial/grid/user', ['user' => $inviteRequest->Sender], true);
                        },
                        'htmlOptions' => ['class' => 'text-left'],
                        'width' => '25%'
                    ],
                    [
                        'header' => $search->getAttributeLabel('Owner'),
                        'name' => 'Owner',
                        'type' => 'raw',
                        'value' => function (InviteRequest $inviteRequest) use ($event, $controller) {
                            $user = $inviteRequest->Owner;
                            $result = $controller->renderPartial('../partial/grid/user', ['user' => $user], true);

                            $data = $event->getUserData($user);
                            if (!empty($data)) {
                                $result .= '<p class="m-top_5">' . \CHtml::link(\Yii::t('app', 'Дополнительные параметры'), '#definitions_' . $user->RunetId, ['class' => 'btn btn-sm', 'role' => 'button', 'data-toggle' => 'modal']) . '</p>';
                                $result .= $controller->renderPartial('invite/definitions', [
                                    'data' => $data,
                                    'user' => $user
                                ], true);
                            }
                            return $result;
                        },
                        'htmlOptions' => ['class' => 'text-left'],
                        'width' => '25%'
                    ],
                    [
                        'header' => \Yii::t('app', 'Дата подачи'),
                        'name'   => 'CreationTime',
                        'value'  => '\Yii::app()->getDateFormatter()->format("dd MMMM yyyy HH:mm", $data->CreationTime)',
                        'filter' => false,
                        'width'  => 120,
                    ],
                    [
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Approved'),
                        'name' => 'Approved',
                        'value' => function (InviteRequest $inviteRequest) use ($event) {
                            if ($inviteRequest->Approved == Approved::Yes) {
                                return \CHtml::tag('span', ['class' => 'label label-success'], Approved::getLabels()[Approved::Yes]);
                            } else {
                                $result = '';
                                if ($inviteRequest->Approved == Approved::No) {
                                    $result .= \CHtml::tag('p', [], \CHtml::tag('span', ['class' => 'label label-danger'], Approved::getLabels()[Approved::No]));
                                }
                                $result .= \CHtml::beginForm();
                                $result .= '<div class="input-group">';
                                $result .= \CHtml::dropDownList('RoleId', 1, \CHtml::listData($event->getRoles(), 'Id', 'Title'), ['class' => 'form-control']);
                                $result .= '<div class="input-group-btn">';
                                $result .= \CHtml::tag('button', ['class' => 'btn btn-outline btn-success', 'name' => 'Action', 'value' => 'approved', 'title' => \Yii::t('app', 'Подтвердить')], '<span class="fa fa-check"></span>');
                                if ($inviteRequest->Approved != Approved::No) {
                                    $result .= \CHtml::tag('button', ['class' => 'btn btn-outline btn-danger', 'name' => 'Action', 'value' => 'disapproved', 'title' => \Yii::t('app', 'Отклонить')], '<span class="fa fa-times"></span>');
                                }
                                $result .= '</div>';
                                $result .= '</div>';
                                $result .= \CHtml::hiddenField('InviteId', $inviteRequest->Id);
                                $result .= \CHtml::endForm();
                                return $result;
                            }
                        },
                        'filter' => [
                            'class' => '\partner\widgets\grid\MultiSelect',
                            'items' => Approved::getLabels()
                        ]
                    ]
                ]
            ])?>
        </div>
    </div> <!-- / .panel-body -->
</div>