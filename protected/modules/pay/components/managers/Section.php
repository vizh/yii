<?php
namespace pay\components\managers;

use event\models\section\Section as SectionModel;
use pay\components\MessageException;

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

    /**
     * @inheritdoc
     */
    public function checkProduct($user, $params = [])
    {
        $section = SectionModel::model()->byEventId($this->product->EventId)->findByPk($this->SectionId);
        if ($section == null) {
            throw new MessageException('Не корректно задан SectionId для товара категории Section');
        }
        return parent::checkProduct($user, $params);
    }
} 