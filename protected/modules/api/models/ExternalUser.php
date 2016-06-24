<?php
namespace api\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * Class ExternalUser
 *
 * Fields
 * @property int $Id
 * @property string $Partner
 * @property int $AccountId
 * @property int $UserId
 * @property string $ExternalId
 *
 * @property User $User
 *
 * Вспомогательные описания методов методы
 * @method ExternalUser find($condition='',$params=array())
 * @method ExternalUser findByPk($pk,$condition='',$params=array())
 * @method ExternalUser[] findAll($condition='',$params=array())
 */
class ExternalUser extends ActiveRecord
{
    /**
     * Creates a new one model
     * @param User $user The user
     * @param Account $account Api account
     * @param string|int $externalId An external identifier
     * @return ExternalUser|null Created model
     */
    public static function create(User $user, Account $account, $externalId)
    {
        try {
            $user->refreshUpdateTime(true);

            $model = new self();
            $model->UserId = $user->Id;
            $model->AccountId = $account->Id;
            $model->Partner = $account->Role;
            $model->ExternalId = $externalId;
            $model->save();

            return $model;
        } catch (\CDbException $e) {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'ApiExternalUser';
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, 'user\models\User', 'UserId']
        ];
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