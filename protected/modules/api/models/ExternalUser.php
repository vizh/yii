<?php
namespace api\models;

/**
 * Class ExternalUser
 * @package api\models
 *
 * @property int $Id
 * @property string $Partner
 * @property int $AccountId
 * @property int $UserId
 * @property string $ExternalId
 *
 * @property \user\models\User $User
 *
 * Вспомогательные описания методов методы
 * @method \api\models\ExternalUser find($condition='',$params=array())
 * @method \api\models\ExternalUser findByPk($pk,$condition='',$params=array())
 * @method \api\models\ExternalUser[] findAll($condition='',$params=array())
 */
class ExternalUser extends \CActiveRecord
{
    /**
     * @param string $className
     *
     * @return ExternalUser
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ApiExternalUser';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array(
            'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
        );
    }

    /**
     * @param string $partner
     * @param bool $useAnd
     *
     * @return $this
     */
    public function byPartner($partner, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Partner" = :Partner';
        $criteria->params = ['Partner' => $partner];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $accountId
     * @param bool $useAnd
     * @return $this
     */
    public function byAccountId($accountId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."AccountId" = :AccountId';
        $criteria->params = ['AccountId' => $accountId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     *
     * @return $this
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId';
        $criteria->params = ['UserId' => (int)$userId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param string $externalId
     * @param bool $useAnd
     *
     * @return $this
     */
    public function byExternalId($externalId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."ExternalId" = :ExternalId';
        $criteria->params = ['ExternalId' => $externalId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
}