<?php
namespace partner\widgets;


use application\components\helpers\ArrayHelper;
use CHtml;

\Yii::import('zii.widgets.CMenu');

/**
 * Class Menu
 * @package partner\widgets
 *
 * Расширяет класс Menu, добавляя новый функционал
 */
class Menu extends \CMenu
{
    public $itemHtmlOptions = [];

    /**
     * @inheritdoc
     */
    protected function renderMenuItem($item)
    {
        $item['label'] = CHtml::tag('span', ['class' => 'mm-text mmc-dropdown-delay animated'], $item['label']);
        $item['label'] = isset($item['icon']) ? (CHtml::tag('i', ['class' => 'fa fa-'.$item['icon']], '') . '&nbsp;' . $item['label']) : $item['label'];
        return parent::renderMenuItem($item);
    }

    /**
     * @inheritdoc
     */
    protected function renderMenuRecursive($items)
    {
        $count = count($items);
        $lines = [];

        foreach ($items as $i => $item) {
            $visible = !isset($item['visible']) || $item['visible'];
            if (!$this->checkAccess($item['url']) || !$visible) {
                continue;
            }

            $options = array_merge($this->itemHtmlOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $count - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }

            $menu = $this->renderMenuItem($item);
            if (!empty($item['items'])) {
                $class = 'mm-dropdown' . ($item['active'] ? ' open' : '');
                $options['class'] = isset($options['class']) ? $options['class'] . ' ' . $class : $class;
                $menu .= CHtml::tag('ul', [], $this->renderMenuRecursive($item['items']));
            }
            $lines[] = CHtml::tag($tag, $options, $menu);
        }
        return implode("\n", $lines);
    }

    /**
     * @inheritdoc
     */
    protected function renderMenu($items)
    {
        if(count($items)) {
            echo
                CHtml::openTag('ul',$this->htmlOptions),"\n",
                $this->renderMenuRecursive($items),
                CHtml::closeTag('ul');
        }
    }

    /**
     * @param $url
     * @return mixed
     */
    protected function checkAccess($url)
    {
        $parts = explode('/', $url[0]);
        if (count($parts) != 2){
            return true;
        }
        return $this->getController()->getAccessFilter()->checkAccess('partner', $parts[0], $parts[1]);
    }
}