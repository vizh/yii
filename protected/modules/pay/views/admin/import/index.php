<?php
/**
 * @var $imports \pay\models\Import[]
 * @var \pay\components\Controller $this
 */

$this->setPageTitle(\Yii::t('app', 'Импорт выписки из банка'));
?>

<div class="row-fluid">

    <div class="btn-toolbar clearfix">
        <?=CHtml::beginForm(['index'], 'post', ['enctype' => 'multipart/form-data'])?>
        <div class="form-group">
            <label>Загрузите файл для импорта</label>
            <input type="file" name="import_file">
        </div>
        <?=CHtml::submitButton(\Yii::t('app', 'Загрузить'), ['class' => 'btn btn-primary'])?>
        <?=CHtml::endForm()?>
    </div>

    <div class="well">
        <table class="table">
            <thead>
            <tr>
                <th><?=Yii::t('app', 'Дата')?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?foreach($imports as $import):?>
                <tr>
                    <td><?=Yii::app()->getDateFormatter()->format('dd MMMM yyyy, HH:mm', $import->CreationTime)?></td>
                    <td><?=CHtml::link(\Yii::t('app', 'Результат'), ['result', 'id' => $import->Id], ['class' => 'btn btn-sm'])?></td>
                </tr>
            <?endforeach?>
            </tbody>
        </table>
    </div>

</div>