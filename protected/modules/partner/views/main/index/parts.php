<?php
/**
 * @var $event \event\models\Event
 * @var $statistics array
 * @var $timeSteps array
 */
?>
<div class="panel panel-dark panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-bar-chart"></i> <?=\Yii::t('app', 'Распределение участников по частям мероприятия')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <?foreach($timeSteps as $key => $time):?>
                            <th><?=$key?></th>
                        <?endforeach?>
                    </tr>
                </thead>
                <tbody>
                    <?foreach($event->Parts as $part):?>
                        <tr>
                            <td><?=$part->Title?></td>
                            <?foreach($timeSteps as $key => $time):?>
                                <td><?=isset($statistics['Parts'][$key][$part->Id]) ? $statistics['Parts'][$key][$part->Id] : 0?></td>
                            <?endforeach?>
                        </tr>
                    <?endforeach?>

                    <tr>
                        <td class="text-right"><strong><?=\Yii::t('app', 'Всего')?>:</strong></td>
                        <?foreach($timeSteps as $key => $time):?>
                            <td><?=$statistics['Parts'][$key]['Total']?></td>
                        <?endforeach?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> <!-- / .panel-body -->
</div>
