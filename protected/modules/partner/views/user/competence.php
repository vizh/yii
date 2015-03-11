<?php
/**
 * @var \application\modules\partner\models\search\Competence $search
 * @var Event $event
 * @var \competence\models\Test $test
 */

use user\models\User;
use event\models\Event;
use competence\models\Result;
use application\modules\competence\components\EventCode;

$this->initActiveBottomMenu('competence');
$this->setPageTitle(\Yii::t('app', 'Опрос участников'));
?>
<h2 class="indent-bottom2"><?=$this->getPageTitle();?></h2>
<?$this->widget('\application\widgets\grid\GridView', [
    'dataProvider'=> $search->getDataProvider(),
    'filter' => $search,
    'columns' => [
        [
            'type' => 'raw',
            'header' => $search->getAttributeLabel('Name'),
            'name' => 'Name',
            'value' => function (User $user) {
                return '<strong>' . $user->RunetId . '</strong>' . ', ' . \CHtml::link($user->getFullName(), $user->getUrl(), ['target' => '_blank']);
            }
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
            }
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
            'htmlOptions' => [
                'class' => 'text-center'
            ],
            'headerHtmlOptions' => [
                'class' => 'text-center'
            ]
        ],
        [
            'type'  => 'raw',
            'value' => function (User $user) use ($test) {
                $result = '
                    <div class="modal hide fade" id="modal' . $user->RunetId . '">
                        <div class="modal-body">
                            <h2 class="text-center muted">' . \Yii::t('app', 'Код участника') .':</h2>
                            <h2 class="text-center">' . EventCode::generate($user, $test) . '</h2>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Заркыть</a>
                        </div>
                    </div>';
                $result .= \CHtml::link(\Yii::t('app', 'Код участника'), '#modal'.$user->RunetId, ['class' => 'btn btn-info btn-small', 'data-toggle' => 'modal']);
                return $result;
            }
        ]
    ]
]);?>