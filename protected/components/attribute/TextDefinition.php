<?php
namespace application\components\attribute;

class TextDefinition extends Definition
{
    protected function internalActiveEdit(\CModel $container)
    {
        return \CHtml::activeTextArea($container, $this->name, ['class' => $this->cssClass, 'style' => $this->cssStyle]);
    }
} 