<?php
namespace application\widgets;

class GroupBtnSelect extends \CWidget
{
    /**
     * @var array Значения
     */
    public $values;

    /**
     * @var \CModel
     */
    public $model;

    /**
     * @var string
     */
    public $attribute;

    /**
     * Инициализируем ресурсы
     */
    public function init()
    {
        if (!($this->model instanceof \CModel)) {
            throw new \CException('Атрибут model не задан или имеет неверный тип!');
        }

        if (!property_exists($this->model, $this->attribute)) {
            throw new \CException('Модель '.get_class($this->model).' не содержит атрибут с имененм '.$this->attribute);
        }

        \Yii::app()->getClientScript()->registerScriptFile(
            \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('application.widgets.assets.js').'/group-btn-select.js'),
            \CClientScript::POS_HEAD
        );
    }

    /**
     * Выводим виджет
     */
    public function run()
    {
        $this->render('group-btn-select', [
            'activeValues' => !is_array($this->model->{$this->attribute}) ? [$this->model->{$this->attribute}] : $this->model->{$this->attribute},
            'inputName' => \CHtml::activeName($this->model, $this->attribute.'[]')
        ]);
    }
}