<?php
namespace partner\widgets\grid;

use application\widgets\grid\FilterWidget;

class MultiSelect extends FilterWidget
{
    /**
     * @var array Элементы выбора
     */
    public $items = [];

    /**
     * @var string Текст, отображаемый когда ни один элемент не выбран
     */
    public $placeholder = 'Выберите элемент';

    /**
     * @var string Текст, отображаемый в раскрывающемся списке, когда все элементы выбраны
     */
    public $allSelectMessage = 'Выбраны все элементы';

    /**
     * @var string Текст, отображаемый в раскрывающемся списке, когда не найден элемент
     */
    public $notFoundMessage = 'Не найден элемент содержащий';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerClientScript();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo \CHtml::activeListBox($this->model, $this->attribute, $this->items, [
            'id' => $this->getId(),
            'multiple' => true,
            'class' => 'form-control',
            'placeholder' => \CHtml::encode($this->placeholder),
            'style' => 'width: 100%'
        ]);
    }

    /**
     * Публикует скрипт инициализации
     */
    public function registerClientScript()
    {
        $allSelectMessage = \CHtml::encode($this->allSelectMessage);
        $notFoundMessage  = \CHtml::encode($this->notFoundMessage);

        $initScript = <<<SCRIPT
            function {$this->getInitJsFunctionName()} () {
                $("#{$this->getId()}").select2({
                    formatNoMatches: function (term) {
                        if (term.length == 0) {
                            return '$allSelectMessage';
                        } else {
                            return '$notFoundMessage "'+term+'"';
                        }
                    }
                });
            }
SCRIPT;

        /** @var \CClientScript $clientScript */
        $clientScript = \Yii::app()->getClientScript();
        $clientScript->registerScript($this->getInitJsFunctionName(), $initScript);
    }

    /**
     * @inheritdoc
     */
    public function getInitJsFunctionName()
    {
        return 'initMultiSelectFilter_'.$this->getId();
    }
} 