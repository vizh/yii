<?php

use \application\components\helpers\ArrayHelper;

/**
 * @var $this \pay\components\Controller
 * @var $entry \pay\models\ImportEntry
 */

echo CHtml::beginForm(['edit', 'entryId' => $entry->Id], 'post');

echo CHtml::openTag('div', ['class' => 'form-group']);
echo CHtml::textArea('value', ArrayHelper::getValue($entry, 'Data.НазначениеПлатежа'), ['rows' => 5, 'class' => 'span12']);
echo CHtml::closeTag('div');

echo CHtml::openTag('div', ['class' => 'form-group']);
echo CHtml::submitButton('Сохранить', ['class' => 'btn btn-primary']);
echo CHtml::closeTag('div');

echo CHtml::endForm();

foreach ($entry->Data as $key => $data) {
    echo $key, ' = ', $data, '<br/>';
}