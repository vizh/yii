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
            if (strpos($value, 'http') !== 0) {
                $value = 'http://' . $value;
            }
            $value = \CHtml::link($value, $value, ['target' => '_blank']);
        }
        return $value;
    }
}