<?php
/**
 * @var StatController $this
 * @var array $allStat
 */

$this->pageTitle = 'Статистика питания';
?>

<div class="container">

    <h2 class="text-center"><?=CHtml::encode($this->pageTitle)?></h2>

    <h4 style="margin-top: 50px;">Общая статистика</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Наименование услуги</th>
                <th>Количество человек, получивших услугу</th>
                <th>Количество прикладываний</th>
            </tr>
        </thead>
        <tbody>
            <?foreach($allStat as $item):?>
                <tr>
                    <td><?=CHtml::link($item['group'], $item['listUrl'], ['target' => '_blank'])?></td>
                    <td><?=$item['users']?></td>
                    <td><?=$item['count']?></td>
                </tr>
            <?endforeach?>
        </tbody>
    </table>
</div>
