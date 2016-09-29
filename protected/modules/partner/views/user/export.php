<?php
/**
 * @var \partner\components\Controller $this
 * @var \partner\models\forms\user\Export $form
 * @var \application\widgets\ActiveForm $activeForm
 * @var \partner\models\Export[] $exports
 * @var \event\models\Event $event
 */

$formatter = \Yii::app()->getDateFormatter();
$this->setPageTitle(\Yii::t('app', 'Экспорт участников в Excel'));
?>
<?if(!empty($exports)):?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <span class="panel-title"><i class="fa fa-history"></i> <?=\Yii::t('app', 'Ранее экспортировано')?></span>
        </div> <!-- / .panel-heading -->
        <div class="panel-body">
            <?if($form->hasRunningExports()):?>
                <div class="alert alert-warning">
                    <?=\Yii::t('app', 'Выполняется процесс экспорта участников, в течении нескольких минут он будет завершен. Статус выполнения вы можете увидеть ниже.')?>
                    <?=\CHtml::link('<span class="btn-label fa fa-refresh"></span>' . \Yii::t('app', 'Обновить'), [''], ['class' => 'btn btn-warning btn-labeled btn-xs btn-labeled'])?>
                </div>
            <?endif?>

            <div class="table-info">
                <table class="table table-bordered">
                    <thead>
                        <th><?=\Yii::t('app', 'Дата запуска')?></th>
                        <th><?=\Yii::t('app', 'Параметры')?></th>
                        <th><?=\Yii::t('app', 'Количество участников')?></th>
                        <th><?=\Yii::t('app', 'Статус')?></th>
                    </thead>
                    <tbody>
                        <?php foreach($exports as $export):?>
                            <tr>
                                <td><?=$formatter->format('dd MMMM yyyy HH:mm', $export->CreationTime)?></td>
                                <td class="text-left"><?=$export->getDescription()?></td>
                                <td><?=!empty($export->TotalRow) ? $export->TotalRow : \Yii::t('app', 'Идет процесс инициализаци...')?></td>
                                <td>
                                    <?if($export->Success):?>
                                        <div class="m-bottom_5">
                                            <span class="label label-success"><?=\Yii::t('app', 'Экспорт завершен')?></span>
                                        </div>
                                        <?=\CHtml::link('<span class="btn-label icon fa fa-file-excel-o"></span>' . \Yii::t('app', 'Скачать '), ['exportdownload', 'id' => $export->Id], ['class' => 'btn btn-success btn-labeled btn-xs m-top_5'])?>
                                    <?php else:?>
                                        <span class="label label-default">
                                            <?=\Yii::t('app', 'Выполнено на {percent}%', ['{percent}' => $export->getExportedPercent()])?>
                                        </span>
                                    <?endif?>
                                </td>
                            </tr>
                        <?endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?endif?>


<?$activeForm = $this->beginWidget('\application\widgets\ActiveForm')?>
<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-cogs"></i> <?=\Yii::t('app', 'Новый экспорт')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?=$activeForm->errorSummary($form)?>
        <div class="form-group">
            <?=$activeForm->label($form, 'Roles')?>
            <?=$activeForm->dropDownList($form, 'Roles', \CHtml::listData($event->getRoles(), 'Id', 'Title'), ['multiple' => 'multiple', 'class' => 'form-control'])?>
        </div>
        <?if($event->getIsRequiredDocument()):?>
            <div class="checkbox">
                <label>
                    <?=$activeForm->checkBox($form, 'Document')?> <?=$form->getAttributeLabel('Document')?>
                </label>
            </div>
        <?endif?>
        <?if(!empty($event->Parts)):?>
            <div class="form-group">
                <?=$activeForm->label($form, 'PartId')?>
                <?=$activeForm->dropDownList($form, 'PartId', $form->getEventPartsData(), ['class' => 'form-control'])?>
            </div>
        <?endif?>
        <div class="form-group">
            <?=$activeForm->label($form, 'Language')?>
            <?php foreach($form->getLanguageData() as $lang => $label):?>
                <div class="radio">
                    <label>
                        <?=$activeForm->radioButton($form, 'Language', ['value' => $lang, 'uncheckValue' => null])?> <?=$label?>
                    </label>
                </div>
            <?endforeach?>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Получить список'), ['class' => 'btn btn-primary'])?>
        <?=\CHtml::hiddenField('run', true)?>
    </div>
</div>
<?$this->endWidget()?>