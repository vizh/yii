<?php
/**
 * @var \partner\components\Controller $this
 */

$this->setPageTitle('Генерация итоговых данных мероприятия');
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-file-excel-o"></i> <?=\Yii::t('app', 'Итоговые данные мероприятия')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <p class="text-center">
            <?=\CHtml::link(\Yii::t('app', 'Генерировать новый список'), ['csvinfo', 'generate' => 1], ['class' => 'btn btn-info'])?>
        </p>
        <?if(!empty($fileList)):?>
            <hr/>
            <h4><?=\Yii::t('app', 'Ранее генерированные списки')?></h4>
            <ul class="list-group">
                <?php foreach($fileList as $file):?>
                    <li class="list-group-item"><?=\CHtml::link($file, ['csvinfo', 'file' => $file], ['target' => '_blank'])?></li>
                <?endforeach?>
            </ul>
        <?endif?>
    </div> <!-- / .panel-body -->
</div>