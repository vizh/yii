<?php
/**
 * @var Statistics $statistics
 */

use main\components\admin\Statistics;
$numberFormatter = \Yii::app()->getNumberFormatter();
?>
<div class="row-fluid">
    <div class="block">
        <a class="block-heading" href="#">Статистика</a>
        <div class="block-body in collapse">
            <div class="stat-widget-container">
                <div class="stat-widget" style="width:33%;">
                    <div class="stat-button">
                        <p class="title"><?=$numberFormatter->formatDecimal($statistics->users->all)?></p>
                        <p class="detail">Пользователей</p>
                        <p class="detail">
                            <span class="label label-success"><?=$numberFormatter->formatDecimal($statistics->users->subscribes)?> подписаны  на рассылки</span>
                        </p>
                        <p class="detail">
                            <span class="label"><?=$numberFormatter->formatDecimal($statistics->users->hidden)?> скрытых</span>
                        </p>
                    </div>
                </div>

                <div class="stat-widget" style="width:33%;">
                    <div class="stat-button">
                        <p class="title"><?=$numberFormatter->formatDecimal($statistics->events)?></p>
                        <p class="detail">Мероприятий</p>
                    </div>
                </div>

                <div class="stat-widget" style="width:33%;">
                    <div class="stat-button">
                        <p class="title"><?=$numberFormatter->formatDecimal($statistics->company)?></p>
                        <p class="detail">Компаний</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>