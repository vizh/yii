<?php
/**
 * @var $worksheet \PHPExcel_Worksheet
 * @var $form \partner\models\forms\user\ImportPrepare
 * @var $this \partner\components\Controller
 */

$this->setPageTitle(\Yii::t('app', 'Импорт участников мероприятия'));
?>
<?= CHtml::beginForm() ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">
            <i class="fa fa-caret-square-o-down"></i>
            <?= Yii::t('app', 'Выберите соответствие столбцов и полей данных') ?>
        </span>
    </div>

    <div class="panel-body">
        <?= CHtml::errorSummary($form, '', null, ['class' => 'alert alert-danger']) ?>
        <div class="table-info">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <?php foreach ($form->getColumns() as $column): ?>
                        <th><?= $column ?></th>
                    <?php endforeach ?>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 2; $i < 12; $i++): ?>
                    <tr>
                        <?php foreach ($form->getColumns() as $column): ?>
                            <td><?= $worksheet->getCell($column . $i)->getFormattedValue() ?></td>
                        <?php endforeach ?>
                    </tr>
                <?php endfor ?>
                <tr>
                    <?php foreach ($form->getColumns() as $column): ?>
                        <td>
                            <?= CHtml::activeDropDownList($form, $column, $form->getColumnValues(), [
                                'class' => 'form-control'
                            ]) ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <?= CHtml::activeCheckBox($form, 'Notify') ?> Уведомлять пользователей о регистрации в RUNET-ID
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <?= CHtml::activeCheckBox($form, 'NotifyEvent') ?> Уведомлять пользователей о регистрации на
                    мероприятии
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <?= CHtml::activeCheckBox($form, 'Visible') ?> НЕ скрывать новых пользователей
                </label>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?= CHtml::submitButton(\Yii::t('app', 'Продолжить'), ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?= CHtml::endForm() ?>
