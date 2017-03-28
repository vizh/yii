<?php
/**
 * @var StatController $this
 * @var array $allStat
 * @var \event\models\Event $event
 */

$this->pageTitle = "Статистика питания мероприятия \"{$event->Title}\"";

$counter = 0;
?>

<div class="container">

    <h2 class="text-center"><?=CHtml::encode($this->pageTitle)?></h2>

    <div>
        <ul id="food" class="nav nav-tabs">
            <?foreach(array_keys($allStat) as $tab):?>
                <li>
                    <a href="#<?='tab'.$counter++?>" data-toggle="tab"><?=$tab?></a>
                </li>
            <?endforeach?>
        </ul>

        <?$counter = 0?>

        <div class="tab-content">
            <?foreach($allStat as $tab => $data):?>
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
                            <?foreach($data as $date => $item):?>
                                <tr>
                                    <td><?=$date?></td>
                                    <td>
                                        <?if(isset($item['Завтрак'])):?>
                                            <?=CHtml::link('<b>'.($item['Завтрак']['total'] ?: 0).'</b> / '.($item['Завтрак']['touched'] ?: 0), $item['Завтрак']['users-list-url'], ['target' => '_blank'])?>
                                        <?endif?>
                                    </td>
                                    <td>
                                        <?if(isset($item['Обед'])):?>
                                            <?=CHtml::link('<b>'.($item['Обед']['total'] ?: 0).'</b> / '.($item['Обед']['touched'] ?: 0), $item['Обед']['users-list-url'], ['target' => '_blank'])?>
                                        <?endif?>
                                    </td>
                                    <td>
                                        <?if(isset($item['Ужин'])):?>
                                            <?=CHtml::link('<b>'.($item['Ужин']['total'] ?: 0).'</b> / '.($item['Ужин']['touched'] ?: 0), $item['Ужин']['users-list-url'], ['target' => '_blank'])?>
                                        <?endif?>
                                    </td>
                                </tr>
                            <?endforeach?>
                        </tbody>
                    </table>
                </div>
            <?endforeach?>
        </div>
    </div>
</div>
