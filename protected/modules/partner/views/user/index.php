<?php
/**
 * @var Participant $search
 * @var Event $event
 * @var \partner\components\Controller $this
 */

$this->setPageTitle(\Yii::t('app', 'Поиск участников мероприятия'));
$controller = $this;

use \application\modules\partner\models\search\Participant;
use user\models\User;
use event\models\Event;
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-file-excel-o"></i> <?=\Yii::t('app', 'Итоговые данные мероприятия');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <?$this->widget('\partner\widgets\grid\GridView', [
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
                        ]
                    ],
                    [
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Name'),
                        'value' => function (User $user) {
                            $result  = \CHtml::tag('strong', [], $user->getFullName());
                            $result .= '<p><em>' . $user->Email . '</em></p>';
                            return $result;
                        },
                        'htmlOptions' => [
                            'class' => 'text-left'
                        ],
                        'headerHtmlOptions' => [
                            'class' => 'text-left'
                        ]
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
                        ]
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
                                        \CHtml::tag('strong', $participant->Part->Title) . ' - ' . $participant->Role->Title . '<br/>' .
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
                        'filter' => $search->getRoleData()
                    ],
                    [
                        'type' => 'raw',
                        'header' => $search->getAttributeLabel('Ruvents'),
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
                        ]
                    ],
                    [
                        'class' => '\application\widgets\grid\ButtonColumn',
                        'buttons' => [
                            'ticket' => [
                                'label' => '<i class="fa fa-ticket"></i>',
                                'title' => 'Билет',
                                'url' => '$data->Participants[0]->getTicketUrl()',
                                'options' => [
                                    'class' => 'btn btn-default',
                                    'target' => '_blank'
                                ]
                            ]
                        ],
                        'template' => '{update}{ticket}',
                        'updateButtonUrl' => 'Yii::app()->controller->createUrl("edit",["runetId" => $data->RunetId])'
                    ]
                ]
            ]);?>
        </div>
    </div> <!-- / .panel-body -->
</div>


<?/*
  <div class="row">
    <div class="span12">
      <?=CHtml::beginForm(Yii::app()->createUrl('/partner/user/index/'), 'get');?>
      <div class="row">
        <div class="span3">
          <?=CHtml::activeLabel($form, 'User');?>
          <?=CHtml::activeTextField($form, 'User', array('placeholder' => 'ФИО, RUNET-ID или E-mail'));?>
        </div>
          <div class="span3">
              <?=CHtml::activeLabel($form, 'Company');?>
              <?=CHtml::activeTextField($form, 'Company');?>
          </div>
        <div class="span3">
          <?=CHtml::activeLabel($form, 'Role');?>
          <?=CHtml::activeDropDownList($form, 'Role', $form->getRoleData());?>
        </div>
        <div class="span3">
          <?=CHtml::activeLabel($form, 'Sort');?>
          <?=CHtml::activeDropDownList($form, 'Sort', $form->getSortValues(), array('encode' => false));?>
        </div>
      </div>
      <div class="row m-top_10">
        <div class="span4">
          <label class="checkbox"><?=\CHtml::activeCheckBox($form, 'Ruvents', ['uncheckValue' => null]);?> <?=$form->getAttributeLabel('Ruvents');?></label>
        </div>
      </div>

      <div class="row indent-top2">
        <div class="span2">
          <button class="btn btn-large" type="submit"><i class="icon-search"></i> Искать</button>
        </div>
        <div class="span3">
          <button class="btn btn-large" type="submit" name="reset" value="reset">Сбросить</button>
        </div>
      </div>
      <?=CHtml::endForm();?>
    </div>
  </div>

  <h3>Всего по запросу <?=\Yii::t('', '{n} участник|{n} участника|{n} участников|{n} участника', $paginator->getCount());?></h3>

*/?>