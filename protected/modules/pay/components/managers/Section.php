<?php
namespace pay\components\managers;

/**
 * Class Section
 * @package pay\components\managers
 *
 * @property int $SectionId
 */
class Section extends EventOnPart
{
    /**
     * @inheritdoc
     */
    public function getProductAttributeNames()
    {
        return array_merge(
            ['SectionId'],
            parent::getProductAttributeNames()
        );
    }

    /**
     * @inheritdoc
     */
    public function getRequiredProductAttributeNames()
    {
        return array_merge(
            ['SectionId'],
            parent::getRequiredProductAttributeNames()
        );
    }
} 