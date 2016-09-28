<?php
use application\components\controllers\AdminMainController;
use application\helpers\Flash;
/**
 * @var AdminMainController $this
 */

$this->setPageTitle('Объединение пользователей');
?>
<?=\CHtml::beginForm(['merge'], 'GET')?>
    <div class="btn-toolbar">
        <?=\CHtml::submitButton('Объединить', ['class' => 'btn btn-success'])?>
    </div>
    <div class="well">
        <?=Flash::html()?>
        <div class="control-group">
            <?=\CHtml::label('Основной RUNET&ndash;ID', '',['class' => 'control-label'])?>
            <div class="controls">
                <?$this->widget('zii.widgets.jui.CJuiAutoComplete', [
                    'name' => 'idPrimary',
                    'source' => '/user/ajax/search',
                    'htmlOptions' => [
                        'class' => 'span4'
                    ],
                    'scriptFile' => false,
                    'cssFile' => false
                ])?>
            </div>
        </div>
        <div class="control-group">
            <?=\CHtml::label('Дубль RUNET&ndash;ID', '', ['class' => 'control-label'])?>
            <div class="controls">
                <?$this->widget('zii.widgets.jui.CJuiAutoComplete', [
                    'name' => 'idSecond',
                    'source' => '/user/ajax/search',
                    'htmlOptions' => [
                        'class' => 'span4'
                    ],
                    'scriptFile' => false,
                    'cssFile' => false
                ])?>
            </div>
        </div>
    </div>
<?=\CHtml::endForm()?>

