<?php
namespace api\models;

use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property string $Partner
 * @property int $AccountId
 * @property int $UserId
 * @property string $ExternalId
 *
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method ExternalUser   with($condition = '')
 * @method ExternalUser   find($condition = '', $params = [])
 * @method ExternalUser   findByPk($pk, $condition = '', $params = [])
 * @method ExternalUser   findByAttributes($attributes, $condition = '', $params = [])
 * @method ExternalUser[] findAll($condition = '', $params = [])
 * @method ExternalUser[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ExternalUser byUserId(int $id, $useAnd = true)
 * @method ExternalUser byAccountId(int $id, $useAnd = true)
 * @method ExternalUser byExternalId(int $id, $useAnd = true)
 * @method ExternalUser byPartner(string $partner, $useAnd = true)
 */
class ExternalUser extends ActiveRecord
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
     * Creates a new one model
     *
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
}
