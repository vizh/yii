<?php
namespace partner\models;

use application\components\ActiveRecord;

/**
 * Class CallbackUser
 *
 * @package partner\models
 *
 * @property int $Id
 * @property int $UserId
 * @property int $PartnerCallbackId
 * @property string $Key
 * @property string $CreationTime
 *
 * @property PartnerCallback $PartnerCallback
 *
 * Описание вспомогательных методов
 * @method CallbackUser   with($condition = '')
 * @method CallbackUser   find($condition = '', $params = [])
 * @method CallbackUser   findByPk($pk, $condition = '', $params = [])
 * @method CallbackUser   findByAttributes($attributes, $condition = '', $params = [])
 * @method CallbackUser[] findAll($condition = '', $params = [])
 * @method CallbackUser[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method CallbackUser byId(int $id, bool $useAnd = true)
 * @method CallbackUser byUserId(int $id, bool $useAnd = true)
 * @method CallbackUser byPartnerCallbackId(int $id, bool $useAnd = true)
 * @method CallbackUser byKey(string $key, bool $useAnd = true)
 */
class CallbackUser extends ActiveRecord
{
    /**
     * @param string $className
     * @return CallbackUser
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PartnerCallbackUser';
    }

    public function relations()
    {
        return [
            'PartnerCallback' => [self::BELONGS_TO, 'partner\models\PartnerCallback', 'PartnerCallbackId']
        ];
    }

    /**
     * @param string $creationTime
     * @param bool $useAnd
     *
     * @return $this
     */
    public function byCreationTimeBefore($creationTime, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."CreationTime" < :CreationTimeBefore';
        $criteria->params = ['CreationTimeBefore' => $creationTime];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param string $creationTime
     * @param bool $useAnd
     *
     * @return $this
     */
    public function byCreationTimeFrom($creationTime, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."CreationTime" > :CreationTimeFrom';
        $criteria->params = ['CreationTimeFrom' => $creationTime];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }

    /**
     * @param string $creationTime
     * @param bool $useAnd
     *
     * @return $this
     */
    public function byCreationTimeTo($creationTime, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."CreationTime" < :CreationTimeTo';
        $criteria->params = ['CreationTimeTo' => $creationTime];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);

        return $this;
    }
}