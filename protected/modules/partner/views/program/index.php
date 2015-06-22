<?php
/**
 * @var \partner\components\Controller $this
 */

$this->setPageTitle(\Yii::t('app', 'Программа'));

$formatter = \Yii::app()->getDateFormatter();
$dt = new \DateTime();
$dt->setTimestamp($event->getTimeStampStartDate());
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><span class="fa fa-th"></span> <?=\Yii::t('app', 'Программа мероприятия');?></span>
        <div class="panel-heading-controls">
            <?=\CHtml::link(\Yii::t('app', 'Добавить секцию'), ['section'], ['class' => 'btn btn-xs btn-success btn-outline']);?>
            <?=\CHtml::link(\Yii::t('app', 'Список залов'), ['hall'], ['class' => 'btn btn-xs btn-warning btn-outline']);?>
        </div>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <ul class="nav nav-tabs nav-tabs-simple nav-tabs-sm">
            <?php while($dt->getTimestamp() <= $event->getTimeStampEndDate()):?>
                <li <?if ($date == $dt->format('Y-m-d')):?>class="active"<?endif;?>>
                    <?=\CHtml::link($formatter->format('dd MMMM yyyy', $dt->getTimestamp()), ['index', 'date' => $dt->format('Y-m-d')]);?>
                </li>
                <?$dt->modify('+1 day');?>
            <?php endwhile;?>
        </ul>
        <?php if (!empty($event->Halls)):?>
            <div id="program-grid">
                <div class="table-info m-top_20">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <?php $row = '';?>
                            <?foreach ($event->Halls as $hall):?>
                                <th><?=$hall->Title;?></th>
                                <?php $row .= '<td data-hall-id="'.$hall->Id.'"></td>';?>
                            <?endforeach;?>
                        </tr>
                        </thead>
                        <tbody>
                        <?for($t = 28800; $t <= (24*60*60); $t+=(15*60)):?>
                            <tr>
                                <td data-time="<?=gmdate('H:i', $t);?>"><?=gmdate('H:i', $t);?></td>
                                <?=$row;?>
                            </tr>
                        <?endfor;?>
                        </tbody>
                    </table>
                </div>

                <?php foreach($sections as $section):?>
                    <?php
                    $formatter = \Yii::app()->getDateFormatter();
                    $timeStart = $formatter->format('HH:mm', $section->StartTime);
                    $timeEnd = $formatter->format('HH:mm', $section->EndTime);
                    $hallStart = $section->LinkHalls[0]->Hall->Id;
                    $hallEnd = $section->LinkHalls[sizeof($section->LinkHalls)-1]->Hall->Id;
                    ?>
                    <div data-hall-start="<?=$hallStart;?>" data-hall-end="<?=$hallEnd;?>" data-time-start="<?=$timeStart;?>" data-time-end="<?=$timeEnd;?>" class="section alert alert-info alert-dark">
                        <?=\CHtml::link($section->Title, ['section', 'id' => $section->Id], ['style' => 'color: #fff;']);?>
                    </div>
                <?endforeach;?>
            </div>
        <?else:?>

        <?php endif;?>
    </div>
</div>



<?if (!empty($event->Halls)):?>

  <?else:?>
    <div class="alert alert-error">
      <?=\Yii::t('app', 'Для появления программной сетки, начните добавлять секции.');?>
    </div>
  <?endif;?>
</div>
