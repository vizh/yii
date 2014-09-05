<?php
namespace application\components\attribute;

class BooleanDefinition extends Definition
{
    public $cssClass = 'checkbox';

    public function typecast($value)
    {
        return (boolean)$value;
    }

    protected function internalActiveEdit(\CModel $container)
    {
        $checkbox = \CHtml::activeCheckBox($container, $this->name, ['uncheckValue' => null]);
        return \CHtml::label($checkbox . ' ' . $this->title, false, ['class' => $this->cssClass, 'style' => $this->cssStyle]);
    }
}