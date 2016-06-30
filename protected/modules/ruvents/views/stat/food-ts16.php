<?php
/**
 * @var StatController $this
 * @var array $allStat
 */

$this->pageTitle = 'Статистика питания мероприятия "Территория смыслов"';

$counter = 0;
?>

<div class="container">

    <h2 class="text-center"><?=CHtml::encode($this->pageTitle)?></h2>

    <div>
        <ul id="food" class="nav nav-tabs">
            <?php foreach (array_keys($allStat) as $tab): ?>
                <li>
                    <a href="#<?='tab'.$counter++?>" data-toggle="tab"><?=$tab?></a>
                </li>
            <?php endforeach ?>
        </ul>

        <?php $counter = 0 ?>

        <div class="tab-content">
            <?php foreach ($allStat as $tab => $data): ?>
                <div class="tab-pane fade" id="<?='tab'.$counter++?>">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Завтрак</th>
                            <th>Обед</th>
                            <th>Ужин</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $date => $item): ?>
                                <tr>
                                    <td><?=$date?></td>
                                    <td>
                                        <?=CHtml::link('<b>'.($item['Завтрак']['total'] ?: 0).'</b> / '.($item['Завтрак']['touched'] ?: 0), $item['Завтрак']['users-list-url'], ['target' => '_blank'])?>
                                    </td>
                                    <td>
                                        <?=CHtml::link('<b>'.($item['Обед']['total'] ?: 0).'</b> / '.($item['Обед']['touched'] ?: 0), $item['Обед']['users-list-url'], ['target' => '_blank'])?>
                                    </td>
                                    <td>
                                        <?=CHtml::link('<b>'.($item['Ужин']['total'] ?: 0).'</b> / '.($item['Ужин']['touched'] ?: 0), $item['Ужин']['users-list-url'], ['target' => '_blank'])?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
