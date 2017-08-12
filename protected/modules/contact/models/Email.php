<?php
namespace contact\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property string $Email
 * @property string $Title
 * @property bool $Verified
 *
 * Описание вспомогательных методов
 * @method Email   with($condition = '')
 * @method Email   find($condition = '', $params = [])
 * @method Email   findByPk($pk, $condition = '', $params = [])
 * @method Email   findByAttributes($attributes, $condition = '', $params = [])
 * @method Email[] findAll($condition = '', $params = [])
 * @method Email[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Email byId(int $id, bool $useAnd = true)
 * @method Email byEmail(int $id, bool $useAnd = true)
 * @method Email byVerifed(bool $verifed = true, bool $useAnd = true)
 */
class Email extends ActiveRecord
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ContactEmail';
    }
}