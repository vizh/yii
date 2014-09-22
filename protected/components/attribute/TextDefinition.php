<?php
namespace application\components\attribute;

class TextDefinition extends Definition
{
    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        $htmlOptions['class'] = $this->cssClass . (isset($htmlOptions['class']) ? $htmlOptions['class'] : '');
        $htmlOptions['style'] = $this->cssStyle . (isset($htmlOptions['style']) ? $htmlOptions['style'] : '');
        return \CHtml::activeTextArea($container, $this->name, $htmlOptions);
    }
} 