<?php
namespace mail\models;

use application\components\ActiveRecord;
use mail\components\ILog;

/**
 * @property int $Id
 * @property string $From
 * @property string $To
 * @property string $Subject
 * @property string $Time
 * @property string $Hash
 * @property string $Error
 *
 * Описание вспомогательных методов
 * @method Log   with($condition = '')
 * @method Log   find($condition = '', $params = [])
 * @method Log   findByPk($pk, $condition = '', $params = [])
 * @method Log   findByAttributes($attributes, $condition = '', $params = [])
 * @method Log[] findAll($condition = '', $params = [])
 * @method Log[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Log byId(int $id, bool $useAnd = true)
 * @method Log byHash(string $hash, bool $useAnd = true)
 */
class Log extends ActiveRecord implements ILog
{
    /**
     * @param string $className
     * @return Log
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'MailLog';
    }

    public function setError($error)
    {
        $this->Error = $error;
    }
}
