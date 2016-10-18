<?php
/**
 * @var IDataProvider $stats
 * @var Event $event
 * @var Controller $this
 */

use event\models\Event;
use partner\components\Controller;

$this->setPageTitle(\Yii::t('app', 'Статистика'));
$controller = $this;

?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-group"></i> <?=\Yii::t('app', 'Встречи')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="table-info">
            <?php $this->widget('\application\widgets\grid\GridView', [
                'dataProvider'=> $stats,
                'columns' => [
                    ['header' => 'Дата', 'name' => 'date'],
                    ['header' => 'Отправлено', 'name' => 'sent'],
                    ['header' => 'Принято', 'name' => 'accepted'],
                    ['header' => 'Отклонено', 'name' => 'declined'],
                    ['header' => 'Отменено', 'name' => 'cancelled'],
                ]
            ])?>
        </div>
    </div> <!-- / .panel-body -->
</div>