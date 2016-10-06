<?php
namespace application\components\attribute;

use application\components\AbstractDefinition;

/**
 * Class Definition Класс определяющий тип аттрибута и его визуальное представление при редактировании
 */
class Definition extends AbstractDefinition
{
    /**
     * @inheritdoc
     */
    public static function isTranslatableAllowed()
    {
        return true;
    }
}
