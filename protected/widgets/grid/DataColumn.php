<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 29.05.2015
 * Time: 12:49
 */

namespace application\widgets\grid;

class DataColumn extends \CDataColumn
{
    /** @var null|int Фиксированная ширина колонки */
    public $width;

    public $filterInputHtmlOptions = [];

    /**
     * @inheritdoc
     */
    protected function renderFilterCellContent()
    {
        $filter = $this->filter;
        if ($this->getFilterWidget() !== null) {
            $this->getFilterWidget()->init();
            $this->getFilterWidget()->run();
        } elseif (is_string($filter)) {
            echo $filter;
        } elseif ($filter !== false && $this->grid->filter !== null && $this->name !== null && strpos($this->name, '.') === false) {
            $htmlOptions = array_merge(['id' => false, 'class' => 'form-control'], $this->filterInputHtmlOptions);
            if (is_array($filter)) {
                $htmlOptions['prompt'] = '';
                echo \CHtml::activeDropDownList($this->grid->filter, $this->name, $filter, $htmlOptions);
            } elseif ($filter === null) {
                echo \CHtml::activeTextField($this->grid->filter, $this->name, $htmlOptions);
            }
        } else {
            parent::renderFilterCellContent();
        }
    }

    private $filterWidget = false;

    /**
     * @return FilterWidget|null
     */
    public function getFilterWidget()
    {
        if ($this->filterWidget === false) {
            $filter = $this->filter;
            if (is_array($filter) && isset($filter['class'])) {
                $class = $filter['class'];
                unset($filter['class']);
                $filter['grid'] = $this->grid;
                if (!isset($filter['model'])) {
                    $filter['model'] = $this->grid->filter;
                }
                if (!isset($filter['attribute'])) {
                    $filter['attribute'] = $this->name;
                }
                $this->filterWidget = \Yii::app()->getWidgetFactory()->createWidget($this->grid->getController(), $class, $filter);
            } else {
                $this->filterWidget = null;
            }
        }
        return $this->filterWidget;
    }
}