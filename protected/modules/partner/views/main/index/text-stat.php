<?php
/**
 * @var \event\models\Role[] $roles
 * @var array $textStatistics
 * @var array $timeSteps
 */
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-bar-chart"></i> <?=\Yii::t('app', 'Текстовые данные');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Роль</th>
                    <?foreach ($timeSteps as $key => $time):?>
                        <th><?=$key;?></th>
                    <?endforeach;?>
                </tr>
                </thead>
                <tbody>
                <?foreach ($roles as $role):?>
                    <tr>
                        <td><?=$role->Title;?></td>
                        <?foreach ($timeSteps as $key => $time):?>
                            <td><?=isset($textStatistics[$key][$role->Id]) ? $textStatistics[$key][$role->Id] : 0;?></td>
                        <?endforeach;?>
                    </tr>
                <?endforeach;?>

                <tr>
                    <td><strong>Всего:</strong></td>
                    <?foreach ($timeSteps as $key => $time):?>
                        <td><?=$textStatistics[$key]['Total'];?></td>
                    <?endforeach;?>
                </tr>
                </tbody>
            </table>
        </div>
    </div> <!-- / .panel-body -->
</div>