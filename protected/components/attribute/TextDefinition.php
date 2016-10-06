<?php
namespace application\components\attribute;

use application\components\AbstractDefinition;
use CHtml;
use Yii;

class TextDefinition extends AbstractDefinition
{
    protected function internalActiveEdit(\CModel $container, array $htmlOptions = [])
    {
        return parent::internalActiveEdit($container, array_merge($htmlOptions, [
            'generator' => 'activeTextArea',
            'rows' => 8
        ]));
    }
}