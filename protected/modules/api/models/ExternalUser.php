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
 * @method ExternalUser byUserId($id, $useAnd = true)
 * @method ExternalUser byAccountId($id, $useAnd = true)
 * @method ExternalUser byExternalId($id, $useAnd = true)
 * @method ExternalUser byPartner($partner, $useAnd = true)
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
            $model = new self();
            $model->UserId = $user->Id;
            $model->AccountId = $account->Id;
            $model->Partner = $account->Role;
            $model->ExternalId = $externalId;
            $model->save();

            $user->refreshUpdateTime(true);

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
}