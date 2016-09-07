<?php

/**
 * @var $event \event\models\Event
 */
/** @var array[]|null $counters */

$dateEnd = new DateTime($event->EndYear.'-'.$event->EndMonth.'-'.$event->EndDay);
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-info"></i> <?=Yii::t('app', 'Общая информация');?></span>
    </div>
    <div class="panel-body">
        <?php if (!empty($stat->Participants)):?>
            <div class="table-info">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>День</th>
                        <th>Участников</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($stat->Participants as $date => $participant):?>
                        <?php
                        $total = 0;
                        foreach($participant as $roleId => $count) {
                            $total += $count;
                        }
                        ?>
                        <tr>
                            <td><?php echo $date;?></td>
                            <td><?php echo $total;?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        <?php endif;?>

        <div class="table-info">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Всего участников</th>
                        <th>Всего выдано бейджей</th>
                        <th>Количество регистраторов</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=$stat->Users->Total;?></td>
                        <td><?=$stat->CountBadges;?></td>
                        <td><?=count($operators);?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> <!-- / .panel-body -->
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-info"></i> <?=Yii::t('app', 'Статистика по счётчикам');?></span>
    </div>
    <div class="panel-body">
        <?if($counters):?>
            <?foreach($counters as $counterKey => $counter):?>
                <div class="table-info">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>RUNET-ID</th>
                            <th>Посетитель</th>
                            <th>Email</th>
                            <th>Значение счётчика "<?=$counter['definitionName']?>"</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?foreach($counter['users'] as $runetid => $value):?>
                            <tr>
                                <td><?=$runetid?></td>
                                <td><a href="<?=$this->createUrl('user/edit', ['id' => $runetid])?>"><?=$value['userName']?></a></td>
                                <td><a href="mailto:<?=$value['userEmail']?>"><?=$value['userEmail']?></a></td>
                                <td><?=$value['count']?></td>
                            </tr>
                        <?endforeach?>
                        <tr>
                            <td colspan="3" class="text-right">Всего:</td>
                            <td><?=$counter['total']?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?endforeach?>
        <?endif?>
    </div>
</div>

<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-group"></i> <?=Yii::t('app', 'Участники');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body panel-body__scrollable">
        <div class="table-warning">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th><?=Yii::t('app', 'Роль');?></th>
                    <?foreach ($stat->Users->Dates as $date):?>
                        <th><?=date('d.m.Y', strtotime($date));?></th>
                    <?endforeach;?>
                    <th><?=Yii::t('app', 'Кол-во');?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($stat->Users->Roles as $roleId):?>
                    <tr>
                        <td><?=$stat->Roles[$roleId];?></td>
                        <?php $total = 0;?>
                        <?php foreach ($stat->Users->Dates as $date):?>
                            <td>
                                <?php
                                $count = isset($stat->Users->ByRoles[$date][$roleId]) ? $stat->Users->ByRoles[$date][$roleId] : 0;
                                $total += $count;
                                ?>
                                <?=$count;?>
                            </td>
                        <?php endforeach;?>
                        <td><?=$total;?></td>
                    </tr>
                <?php endforeach;?>
                <tr>
                    <td><strong>Итого</strong></td>
                    <?$total = 0;?>
                    <?php foreach ($stat->Users->Dates as $date):?>
                        <td>
                            <?
                            $total += $stat->Users->All[$date];
                            echo $stat->Users->All[$date];
                            ?>
                        </td>
                    <?php endforeach;?>
                    <td><?=$total;?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div> <!-- / .panel-body -->
</div>

<?php if (!empty($stat->Visits)):?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-history"></i> <?=Yii::t('app', 'Посещения');?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <div class="table-danger">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Метка</th>
                        <th>Кол-во посещений</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($stat->Visits as $mark => $count):?>
                        <tr>
                            <td><?=$mark;?></td>
                            <td><?=$count;?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div> <!-- / .panel-body -->
    </div>
<?php endif;?>

<?php if (isset($stat->PrintBadges)):?>
<div class="panel panel-success">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-square"></i> <?=Yii::t('app', 'Количество выданных бейджей');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-success">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Регистратор</th>
                    <?php for ($dateI = new DateTime($event->StartYear.'-'.$event->StartMonth.'-'.$event->StartDay); $dateI <= $dateEnd; $dateI->modify('+1 day')):?>
                        <th><?php echo $dateI->format('d.m.Y');?></th>
                    <?php endfor;?>
                    <?php if ($event->StartYear != $event->EndYear && $event->StartMonth != $event->EndMonth && $event->StartDay != $event->EndDay):?>
                        <th>Всего</th>
                    <?php endif;?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($operators as $opId => $opLogin):?>
                    <?php $total = 0;?>
                    <tr>
                        <td><?php echo $opLogin;?></td>
                        <?php for ($dateI = new DateTime($event->StartYear.'-'.$event->StartMonth.'-'.$event->StartDay); $dateI <= $dateEnd; $dateI->modify('+1 day')):?>
                            <td>
                                <?php if (isset($stat->PrintBadges[$dateI->format('d.m.Y')][$opId])):?>
                                    <?php echo $stat->PrintBadges[$dateI->format('d.m.Y')][$opId]->Count;?>
                                    <?php
                                    $total += $stat->PrintBadges[$dateI->format('d.m.Y')][$opId]->Count;
                                    ?>
                                <?php else:?>
                                    &ndash;
                                <?php endif;?>
                            </td>
                        <?php endfor;?>
                        <?php if ($event->StartYear != $event->EndYear && $event->StartMonth != $event->EndMonth && $event->StartDay != $event->EndDay):?>
                            <td><?php echo $total;?></td>
                        <?php endif;?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div> <!-- / .panel-body -->
</div>
<?php endif;?>

<?php if (isset($stat->RePrintBadges)):?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-history"></i> <?=Yii::t('app', 'Количество выданных бейджей');?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <div class="table-danger">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>RUNET-ID</th>
                        <th>ФИО</th>
                        <th>Печатей</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($stat->RePrintBadges as $item):?>
                        <tr>
                            <td><?=$item->User->RunetId;?></td>
                            <td><?=$item->User->LastName;?> <?php echo $item->User->FirstName;?></td>
                            <td><?=$item->Count;?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div> <!-- / .panel-body -->
    </div>
<?php endif;?>

