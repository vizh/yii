<?php
namespace partner\widgets\grid;

use application\components\helpers\ArrayHelper;
use application\widgets\grid\FilterWidget;

class MultiSelect extends FilterWidget
{
    /**
     * @var array Элементы выбора
     */
    public $items = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $widget = \Yii::app()->getController()->createWidget('\partner\widgets\ui\MultiSelect', [
            'items' => $this->items,
            'model' => $this->model,
            'attribute' => $this->attribute
        ]);

        $clientScript = \Yii::app()->getClientScript();
        $script = ArrayHelper::getColumn($clientScript->scripts, $widget->getId(), false)[0];
        $script = <<<SCRIPT
            function {$this->getInitJsFunctionName()}() {{$script}}
SCRIPT;
        $clientScript->registerScript($widget->getId(), $script);

        $widget->run();
    }

    /**
     * @inheritdoc
     */
    public function getInitJsFunctionName()
    {
        return 'initMultiSelectFilter_'.$this->getId();
    }
}