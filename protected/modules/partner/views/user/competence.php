<?php
/**
 * @var \application\modules\partner\models\search\Competence $search
 * @var Event $event
 * @var \competence\models\Test $test
 * @var \partner\components\Controller $this
 */

use user\models\User;
use event\models\Event;
use competence\models\Result;
use application\modules\competence\components\EventCode;

$controller = $this;
$this->setPageTitle(\Yii::t('app', 'Опрос участников'));
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-question-circle"></i> <?=\Yii::t('app', 'Опрос участников')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> $search->getDataProvider(),
                'filter' => $search,
                'summaryText' => 'Участники {start}-{end} из {count}.',
                'columns' => [
                    [
                        'header' => $search->getAttributeLabel('Name'),
                        'name'  => 'Name',
                        'type' => 'raw',
                        'value' => function (User $user) use ($controller) {
                            return $this->renderPartial('../partial/grid/user', ['user' => $user], true);
                        },
                        'htmlOptions' => ['class' => 'text-left'],
                        'width' => '40%'
                    ],
                    [
                        'header' => $search->getAttributeLabel('Status'),
                        'type'  => 'raw',
                        'value' => function (User $user) use ($event) {
                            if (empty($event->Parts)) {
                                return $user->Participants[0]->Role->Title;
                            } else {
                                $roles = [];
                                foreach ($user->Participants as $participant) {
                                    $roles[] = $participant->Part->Title . '&mdash;' . $participant->Role->Title;
                                }
                                return implode('<br/>', $roles);
                            }
                        },
                        'width' => '20%'
                    ],
                    [
                        'type' => 'html',
                        'header' => $search->getAttributeLabel('Finished'),
                        'value' => function (User $user) use ($test) {
                            $result = Result::model()->byUserId($user->Id)->byFinished(true)->byTestId($test->Id)->find();
                            if (!empty($result)) {
                                return \CHtml::tag('span', ['class' => 'label label-success'], \Yii::t('app', 'Да, {time}', ['{time}' => \Yii::app()->getDateFormatter()->format('dd MMMM HH:mm', $result->UpdateTime)]));
                            } else {
                                return \CHtml::tag('span', ['class' => 'label label-warning'], \Yii::t('app', 'Нет'));
                            }
                        },
                        'width' => 100
                    ],
                    [
                        'type'  => 'raw',
                        'value' => function (User $user) use ($controller, $test) {
                            $controller->beginWidget('\application\widgets\bootstrap\Modal', [
                                'id' => 'definitions_' . $user->RunetId,
                                'header' => \Yii::t('app', 'Код участника'),
                                'htmlOptions' => ['class' => 'modal-blur'],
                                'toggleButton' => [
                                    'class' => 'btn btn-info',
                                    'label' => \Yii::t('app', 'Код участника')
                                ]
                            ]);
                            echo \CHtml::tag('h2', ['class' => 'text-center'], EventCode::generate($user, $test));
                            $controller->endWidget();
                        },
                        'htmlOptions' => [
                            'class' => 'text-right'
                        ]
                    ]
                ]
            ])?>
        </div>
    </div> <!-- / .panel-body -->
</div>