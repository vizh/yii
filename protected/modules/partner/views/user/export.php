<?php
/**
 * @var $event \event\models\Event
 * @var $this \partner\components\Controller
 */

$this->setPageTitle(\Yii::t('app', 'Экспорт участников в CSV'));
?>
<?=\CHtml::beginForm();?>
<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-cogs"></i> <?=\Yii::t('app', 'Настройки экспорта');?></span>
    </div> <!-- / .panel-heading -->
    <div class="panel-body">
        <div class="form-group">
            <?=\CHtml::label(\Yii::t('app', 'Кодировка'), 'charset');?>
            <div class="radio">
                <label>
                    <?=\CHtml::radioButton('charset', false,['value' => 'utf8']);?> UTF8 (MacOS)
                </label>
            </div>
            <div class="radio">
                <label>
                    <?=\CHtml::radioButton('charset', true, ['value' => 'Windows-1251']);?> Windows-1251 (Microsoft Office)
                </label>
            </div>
        </div>
        <div class="form-group">
            <?=\CHtml::label(\Yii::t('app', 'Выберите роли для экспорта'), false);?>
            <?=\CHtml::listBox('roles[]', false, \CHtml::listData($event->getRoles(), 'Id', 'Title'), ['multiple' => 'multiple', 'class' => 'form-control']);?>
        </div>
        <div class="form-group">
            <?=\CHtml::label(\Yii::t('app', 'Язык выгрузки'), false);?>
            <div class="radio">
                <label>
                    <?=\CHtml::radioButton('language', true, ['value' => 'ru']);?> Руский
                </label>
            </div>
            <div class="radio">
                <label>
                    <?=\CHtml::radioButton('language', false, ['value' => 'en']);?> Английский
                </label>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?=\CHtml::submitButton(\Yii::t('app', 'Получить список'), ['class' => 'btn btn-primary']);?>
    </div>
</div>
<?=\CHtml::endForm();?>