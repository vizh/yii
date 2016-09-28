<?php
/**
 * @var \event\models\Role[] $roles
 * @var \ruvents\models\Visit[] $visits
 * @var array $textStatistics
 * @var array $timeSteps
 */

?>

<div class="panel panel-info">
    <div class="panel-body">
        <div class="table-info">
            <h2 style="margin-top:0"><?=Yii::t('app', 'Участники')?></h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Роль</th>
                    <?foreach($timeSteps as $key => $time):?>
                        <th><?=$key?></th>
                    <?endforeach?>
                </tr>
                </thead>
                <tbody>
                <?foreach($roles as $role):?>
                    <tr>
                        <td><?=$role->Title?></td>
                        <?foreach($timeSteps as $key => $time):?>
                            <td><?=isset($textStatistics[$key][$role->Id]) ? $textStatistics[$key][$role->Id] : 0?></td>
                        <?endforeach?>
                    </tr>
                <?endforeach?>

                <tr>
                    <td class="text-right"><strong>Всего:</strong></td>
                    <?foreach($timeSteps as $key => $time):?>
                        <td><?=$textStatistics[$key]['Total']?></td>
                    <?endforeach?>
                </tr>
                </tbody>
            </table>

            <?$visitMarksIds = array_diff(array_keys(array_values($visits)[0]), ['Total'])?>
            <?if(!empty($visitMarksIds)):?>
                <h2><?=Yii::t('app', 'Отметки интерактивных стендов')?></h2>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Метка</th>
                        <?foreach($timeSteps as $key => $time):?>
                            <th><?=$key?></th>
                        <?endforeach?>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($visitMarksIds as $markId):?>
                        <tr>
                            <td><?=$markId?></td>
                            <?foreach($timeSteps as $key => $time):?>
                                <td><?=isset($visits[$key][$markId]) ? $visits[$key][$markId] : 0?></td>
                            <?endforeach?>
                        </tr>
                    <?endforeach?>

                    <tr>
                        <td class="text-right"><strong>Всего:</strong></td>
                        <?foreach($timeSteps as $key => $time):?>
                            <td><?=$visits[$key]['Total']?></td>
                        <?endforeach?>
                    </tr>
                    </tbody>
                </table>
            <?endif?>
        </div>
    </div>
</div>