<?php
namespace application\components\attribute;

class TextDefinition extends Definition
{
    protected function internalActiveEdit(\CModel $container, $htmlOptions = [])
    {
        $htmlOptions['class'] = $this->cssClass . (isset($htmlOptions['class']) ? $htmlOptions['class'] : '');
        $htmlOptions['style'] = $this->cssStyle . (isset($htmlOptions['style']) ? $htmlOptions['style'] : '');
        if (!empty($this->placeholder)) {
            $htmlOptions['placeholder'] = $this->placeholder;
        }
        return \CHtml::activeTextArea($container, $this->name, $htmlOptions);
    }
} 