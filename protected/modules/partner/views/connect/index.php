<?php
/**
 * @var Participant $search
 * @var Event $event
 * @var \partner\models\forms\user\RoleBulkChange $bulkRoleChange
 * @var Controller $this
 */

use \partner\components\Controller;
use connect\models\Meeting;
use connect\models\MeetingLinkUser;

$this->setPageTitle(\Yii::t('app', 'Встречи'));
$controller = $this;

use \application\modules\partner\models\search\Participant;
use user\models\User;
use event\models\Event;
use application\components\utility\Texts;
?>
<div class="panel panel-info">

    <?php
    /** @var CActiveForm $form */
    $form = $this->beginWidget('CActiveForm');
    ?>

    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-group"></i> <?=\Yii::t('app', 'Встречи')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <?$this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> $search->getDataProvider(),
                'filter' => $search,
                'summaryText' => 'Пользователи {start}-{end} из {count}.',
                'columns' => [
                    [
                        'name' => 'Id',
                        'filter' => false,
                        'width' => '10%'
                    ],
                    [
                        'name' => 'Creator',
                        'type' => 'raw',
                        'value' => function (Meeting $meeting) use ($controller) {
                            return $controller->renderPartial('../partial/grid/user', ['user' => $meeting->Creator], true);
                        },
                        'htmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'headerHtmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'width' => '20%',
                    ],
                    [
                        'name' => 'UserLinks',
                        'type' => 'raw',
                        'value' => function (Meeting $meeting) use ($controller) {
                            $output = '';
                            foreach ($meeting->UserLinks as $link) {
                                $output .= $controller->renderPartial('../partial/grid/user', ['user' => $link->User], true);

                                $output .= CHtml::openTag('p');
                                if ($link->Status == MeetingLinkUser::STATUS_SENT){
                                    $output .= Html::tag('span', ['class' => 'label label-warning'], 'Отправлено');
                                }
                                if ($link->Status == MeetingLinkUser::STATUS_ACCEPTED){
                                    $output .= Html::tag('span', ['class' => 'label label-success'], 'Принято');
                                }
                                if ($link->Status == MeetingLinkUser::STATUS_DECLINED){
                                    $output .= Html::tag('span', ['class' => 'label label-danger'], 'Отклонено');
                                    $output .= ' ('.$link->Response.')';
                                }
                                if ($link->Status == MeetingLinkUser::STATUS_CANCELLED){
                                    $output .= Html::tag('span', ['class' => 'label label-danger'], 'Отменено');
                                    $output .= ' ('.$link->Response.')';
                                }
                                $output .= CHtml::closeTag('p');
                            }
                            return $output;
                        },
                        'htmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'headerHtmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'width' => '20%',
                    ],
                    [
                        'name' => 'Date',
                    ],
                    [
                        'name' => 'Place.Name',
                        'filter' => false
                    ],
                    [
                        'name' => 'Status',
                        'type' => 'raw',
                        'value' => function(Meeting $meeting){
                            if ($meeting->Type == Meeting::TYPE_PRIVATE){
                                if ($meeting->Status == Meeting::STATUS_CANCELLED){
                                    return Html::tag('span', ['class' => 'label label-danger'], 'Отменена') . ' ('.$meeting->CancelResponse.')';
                                }
                                else{
                                    $link = $meeting->UserLinks[0];
                                    if ($link->Status == MeetingLinkUser::STATUS_SENT){
                                        return Html::tag('span', ['class' => 'label label-warning'], 'Отправлено');
                                    }
                                    if ($link->Status == MeetingLinkUser::STATUS_ACCEPTED){
                                        return Html::tag('span', ['class' => 'label label-success'], 'Принято');
                                    }
                                    if ($link->Status == MeetingLinkUser::STATUS_DECLINED){
                                        return Html::tag('span', ['class' => 'label label-danger'], 'Отклонено') . ' ('.$link->Response.')';
                                    }
                                    if ($link->Status == MeetingLinkUser::STATUS_CANCELLED){
                                        return Html::tag('span', ['class' => 'label label-danger'], 'Отменено') . ' ('.$link->Response.')';
                                    }
                                }
                            }
                            else{
                                if ($meeting->Status == Meeting::STATUS_OPEN){
                                    return Html::tag('span', ['class' => 'label label-success'], 'Активна');
                                }
                                if ($meeting->Status == Meeting::STATUS_CANCELLED){
                                    return Html::tag('span', ['class' => 'label label-danger'], 'Отменена') . ' ('.$meeting->CancelResponse.')';
                                }
                            }
                            return '';
                        },
                        'filter' => $search->getStatusData()
                    ],
                    [
                        'name' => 'CreateTime',
                        'filter' => false
                    ]
                ]
            ])?>
        </div>
    </div> <!-- / .panel-body -->

    <?php $this->endWidget(); ?>
</div>