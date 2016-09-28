<?php
/**
 * @var partner\components\Controller $this
 * @var ParticipantData $search
 */

use application\modules\partner\models\search\ParticipantData;

$this->setPageTitle(Yii::t('app', 'Атрибуты пользователей'));
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">
            <i class="fa fa-list-alt"></i> <?=Yii::t('app', 'Атрибуты пользователей')?>
        </span>
    </div>

    <div class="panel-body">
        <div class="table-info">
            <?$this->widget('application\widgets\grid\GridView', [
                'dataProvider' => $search->getDataProvider(),
                'filter' => $search,
                'summaryText' => 'Пользователи {start}-{end} из {count}.',
                'columns' => $search->getColumns()
            ])?>
        </div>
    </div>
</div>

