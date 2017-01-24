<?php
namespace event\models\section;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property string $ColorBackground
 * @property string $ColorTitle
 *
 * Описание вспомогательных методов
 * @method Theme   with($condition = '')
 * @method Theme   find($condition = '', $params = [])
 * @method Theme   findByPk($pk, $condition = '', $params = [])
 * @method Theme   findByAttributes($attributes, $condition = '', $params = [])
 * @method Theme[] findAll($condition = '', $params = [])
 * @method Theme[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Theme byId(int $id, bool $useAnd = true)
 * @method Theme byEventId(int $id, bool $useAnd = true)
 */
class Theme extends ActiveRecord
{
    /**
     * @param string $className
     * @return Theme
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionTheme';
    }
}