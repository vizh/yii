<?php
namespace application\components\attribute;

class UrlDefinition extends Definition
{
    /**
     * @inheritdoc
     */
    public function getPrintValue($container)
    {
        $value = parent::getPrintValue($container);
        if (!empty($value)) {
            $value = \CHtml::link($value, $value, ['target' => '_blank']);
        }
        return $value;
    }
}