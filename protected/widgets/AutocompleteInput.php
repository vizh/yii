<?php
namespace application\widgets;

class AutocompleteInput extends \CInputWidget
{
    public $options = [];

    public $source;

    public $adminMode = false;

    public $targetHtmlOptions = [];

    /**
     * Имя поля, на который вешается автокомплит.
     * Можно указать имя поля и тогда его значение
     * будет попадать в POST
     *
     * @var null
     */
    public $inputFieldName;

    /** @var string|\Closure */
    public $label = '';

    /**
     *
     */
    public function init()
    {
        if ($this->hasModel()) {
            $this->name = \CHtml::resolveName($this->model, $this->attribute);
            $this->value = \CHtml::resolveValue($this->model, $this->attribute);
        }
        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->getId();
        }
        $this->targetHtmlOptions['id'] = $this->htmlOptions['id'].'target';
        $this->htmlOptions['data-target'] = '#'.$this->targetHtmlOptions['id'];

        if (!isset($this->options['select'])) {
            $this->options['select'] = 'js:function (event, ui) {
                $(this).val(ui.item.label);
                var target = $(this).data("target");
                $(target).val(ui.item.value);
                return false;
            }';
        }
        $this->options['source'] = $this->source;
    }

    /**
     * Регистрация ресурсов виджета
     *
     * @throws \CException
     */
    protected function initResources()
    {
        $clientScript = \Yii::app()->getClientScript();
        $clientScript->registerPackage($this->adminMode ? 'runetid.admin.jquery.ui' : 'runetid.jquery.ui');

        $id = $this->htmlOptions['id'];
        $options = \CJavaScript::encode($this->options);
        $clientScript->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').autocomplete($options);");
    }

    /**
     *
     */
    public function run()
    {
        $this->initResources();
        if ($this->hasModel()) {
            echo \CHtml::activeHiddenField($this->model, $this->attribute, $this->targetHtmlOptions);
        } else {
            echo \CHtml::hiddenField($this->name, $this->value, $this->targetHtmlOptions);
        }

        $value = null;
        if (!empty($this->value)) {
            $label = $this->label;
            $value = $label instanceof \Closure ? $label($this->value) : $label;
        }
        echo \CHtml::textField($this->inputFieldName, $value, $this->htmlOptions);
    }
}