<?php
/**
 * @var $imports \partner\models\Import[]
 * @var \partner\components\Controller $this
 */

$this->setPageTitle(Yii::t('app', 'Импорт участников мероприятия'));
?>
<form action="" method="post" enctype="multipart/form-data">
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-download"></i> <?=Yii::t('app', 'Новый импорт')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="form-group">
            <label>Загрузите файл для импорта</label>
            <input type="file" name="import_file">
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(Yii::t('app', 'Загрузить'), ['class' => 'btn btn-primary'])?>
    </div>
</div>
</form>

<div class="panel panel-warning">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-history"></i> <?=Yii::t('app', 'Ранее импортировано')?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <?php if (!empty($imports)):?>
            <div class="table-warning">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?=Yii::t('app', 'ID')?></th>
                            <th><?=Yii::t('app', 'Дата')?></th>
                            <th><?=Yii::t('app', 'Всего')?></th>
                            <th><?=Yii::t('app', 'Импортировано')?></th>
                            <th><?=Yii::t('app', 'Ошибок')?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?foreach ($imports as $import):?>
                            <?php
                            $countImported = count($import->Users(['condition' => '"Users"."Imported"']));
                            $countErrorUsers = count($import->Users(['condition' => '"Users"."Error"']));
                            ?>
                            <tr>
                                <td><?=$import->Id?></td>
                                <td><?=Yii::app()->getDateFormatter()->format('dd MMMM yyyy, HH:mm', $import->CreationTime)?></td>
                                <td><?=count($import->Users)?></td>
                                <td><?=$countImported?></td>
                                <td><?=$countErrorUsers?></td>
                                <td>
                                    <?php if ($countImported > 0 && $countImported === count($import->Users)):?>
                                        <span class="label label-success">Импорт завершен</span>
                                    <?php elseif ($countErrorUsers > 0):?>
                                        <?=\CHtml::link(Yii::t('app', 'Исправить ошибки'), ['importerrors', 'id' => $import->Id], ['class' => 'btn btn-sm'])?>
                                    <?php elseif ($import->Fields == null):?>
                                        <?=\CHtml::link(Yii::t('app', 'Задать поля'), ['importmap', 'id' => $import->Id], ['class' => 'btn btn-sm'])?>
                                    <?php elseif ($import->Roles == null):?>
                                        <?=\CHtml::link(Yii::t('app', 'Задать роли'), ['importroles', 'id' => $import->Id], ['class' => 'btn btn-sm'])?>
                                    <?php elseif ($import->Products == null):?>
                                        <?=\CHtml::link(Yii::t('app', 'Задать товары'), ['importproducts', 'id' => $import->Id], ['class' => 'btn btn-sm'])?>
                                    <?php endif?>
                                </td>
                            </tr>
                        <?endforeach?>
                    </tbody>
                </table>
            </div>
        <?php else:?>
            <div class="alert alert-warning text-center"><?=Yii::t('app', 'Еще не было ни одного импорта')?></div>
        <?php endif?>
    </div>
</div>
