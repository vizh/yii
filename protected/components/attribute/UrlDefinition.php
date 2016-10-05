<?php
namespace application\components\attribute;

use application\components\AbstractDefinition;
use CHtml;
use event\components\UserDataManager;

class UrlDefinition extends AbstractDefinition
{
    /**
     * @inheritdoc
     */
    public function getPrintValue(UserDataManager $manager, $useHtml = false)
    {
        $value = $this->getExportValue($manager);

        return $value ?: ($useHtml ? CHtml::link($value, $value, ['target' => '_blank']) : $value);
    }

    /**
     * @inheritdoc
     */
    public function getExportValue(UserDataManager $manager)
    {
        $value = parent::getExportValue($manager);

        return $value !== null && strpos($value, 'http') !== 0
            ? 'http://'.$value
            : null;
    }
}