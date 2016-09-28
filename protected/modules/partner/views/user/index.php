<?php
/**
 * @var Participant $search
 * @var Event $event
 * @var Controller $this
 */

use \partner\components\Controller;

$this->setPageTitle(\Yii::t('app', 'Поиск участников мероприятия'));
$controller = $this;

use \application\modules\partner\models\search\Participant;
use user\models\User;
use event\models\Event;
use application\components\utility\Texts;
?>
<?$this->beginClip(Controller::PAGE_HEADER_CLIP_ID)?>
    <?=\CHtml::link('<span class="btn-label fa fa-plus"></span> ' . \Yii::t('app', 'Добавить участника'), ['find'], ['class' => 'btn btn-primary btn-labeled'])?>
<?$this->endClip()?>


<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-group"></i> <?=\Yii::t('app', 'Участники')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> $search->getDataProvider(),
                'filter' => $search,
                'summaryText' => 'Пользователи {start}-{end} из {count}.',
                'columns' => [
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
                        'width' =>  '30%'
                    ],
                    [
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Role'),
                        'name' => 'Role',
                        'value' => function (User $user) use ($event) {
                            $dateFormatter = \Yii::app()->getDateFormatter();
                            $participants  = $user->Participants;
                            if (empty($event->Parts)) {
                                return $participants[0]->Role->Title . '<br/><em>' . $dateFormatter->formatDateTime($participants[0]->CreationTime, 'long') . '</em>';
                            } else {
                                $result = '';
                                foreach ($participants as $participant) {
                                    if (empty($participant->Part)) {
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
                        'value' => function (User $user) use ($controller) {
                            $result = '';
                            if (!empty($user->Badges)) {
                                $badge = $user->Badges[0];
                                $dateFormatter = \Yii::app()->getDateFormatter();
                                $result.= $dateFormatter->format('dd.MM.yyyy HH:mm', $badge->CreationTime) . '<br/>';
                                $result.= \CHtml::tag('em', [], $badge->Operator->Login);
                                if ($this->getAccessFilter()->checkAccess('partner', 'ruvents', 'userlog')) {
                                    $result.= \CHtml::tag('p', [], \CHtml::link(\Yii::t('app','Подробнее'), ['ruvents/userlog', 'runetId' => $user->RunetId, 'backUrl' => \Yii::app()->getRequest()->getRequestUri()], ['class' => 'btn btn-xs m-top_5']));
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
                        'width' =>  150
                    ],
                    [
                        'class' => '\application\widgets\grid\ButtonColumn',
                        'buttons' => [
                            'ticket' => [
                                'label' => '<i class="fa fa-ticket"></i>',
                                'url' => '$data->Participants[0]->getTicketUrl()',
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
            ])?>
        </div>
    </div> <!-- / .panel-body -->
</div>