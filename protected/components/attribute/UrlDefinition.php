<?php
namespace application\components\attribute;

class UrlDefinition extends Definition
{
    /**
     * @inheritdoc
     */
    public function getPrintValue($container)
    {
        $value = $this->getExportValue($container);
        if (!empty($value)) {
            $value = \CHtml::link($value, $value, ['target' => '_blank']);
        }
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function getExportValue($container)
    {
        $value = parent::getExportValue($container);
        if (!empty($value)) {
            if (strpos($value, 'http') !== 0) {
                $value = 'http://' . $value;
            }
        }
        return $value;
    }
}