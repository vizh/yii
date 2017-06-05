<?php
namespace partner\widgets\ui;

class MultiSelect extends \CInputWidget
{
    /** @var string[] */
    public $items;

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

    public function run()
    {
        list($name, $id) = parent::resolveNameID();
        $this->htmlOptions = array_merge($this->htmlOptions, [
            'multiple' => true,
            'placeholder' => \CHtml::encode($this->placeholder),
            'style' => 'width: 100%',
            'id' => $this->getId()
        ]);

        $value = !empty($this->model) ? \CHtml::resolveValue($this->model, $this->attribute) : $this->value;
        echo \CHtml::listBox($name, $value, $this->items, $this->htmlOptions);
    }

    /**
     * Публикует скрипт инициализации
     */
    public function registerClientScript()
    {
        $allSelectMessage = \CHtml::encode($this->allSelectMessage);
        $notFoundMessage = \CHtml::encode($this->notFoundMessage);

        $initScript = <<<SCRIPT
            $("#{$this->getId()}").select2({
                formatNoMatches: function (term) {
                    if (term.length == 0) {
                        return '$allSelectMessage';
                    } else {
                        return '$notFoundMessage "'+term+'"';
                    }
                }
            });
SCRIPT;

        /** @var \CClientScript $clientScript */
        $clientScript = \Yii::app()->getClientScript();
        $clientScript->registerScript($this->getId(), $initScript);
    }
}