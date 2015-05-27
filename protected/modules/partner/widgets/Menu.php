<?php
namespace partner\widgets;


use application\components\helpers\ArrayHelper;

\Yii::import('zii.widgets.CMenu');

/**
 * Class Menu
 * @package partner\widgets
 *
 * Расширяет класс Menu, добавляя новый функционал
 */
class Menu extends \CMenu
{
    /**
     * @inheritdoc
     */
    protected function renderMenuItem($item)
    {
        $item['label'] = \CHtml::tag('span', ['class' => 'mm-text mmc-dropdown-delay animated'], $item['label']);
        $item['label'] = isset($item['icon']) ? (\CHtml::tag('i', ['class' => 'fa fa-'.$item['icon']], '') . '&nbsp;' . $item['label']) : $item['label'];
        return parent::renderMenuItem($item);
    }
}