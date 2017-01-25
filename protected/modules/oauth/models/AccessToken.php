<?php
namespace oauth\models;

use api\models\Account;
use application\components\ActiveRecord;
use user\models\User;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $AccountId
 * @property string $Token
 * @property string $CreationTime
 * @property string $EndingTime
 *
 * @property User $user
 *
 * Описание вспомогательных методов
 * @method AccessToken   with($condition = '')
 * @method AccessToken   find($condition = '', $params = [])
 * @method AccessToken   findByPk($pk, $condition = '', $params = [])
 * @method AccessToken   findByAttributes($attributes, $condition = '', $params = [])
 * @method AccessToken[] findAll($condition = '', $params = [])
 * @method AccessToken[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method AccessToken byId(int $id, bool $useAnd = true)
 * @method AccessToken byUserId(int $id, bool $useAnd = true)
 * @method AccessToken byAccountId(int $id, bool $useAnd = true)
 * @method AccessToken byToken(string $token, bool $useAnd = true)
 */
class AccessToken extends ActiveRecord
{

    /**
     * @param string $className
     * @return AccessToken
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'OAuthAccessToken';
    }

    public function relations()
    {
        return [
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
        ];
    }

    /**
     * @param Account $account
     * @return AccessToken
     */
    public function createToken(Account $account)
    {
        $solt = substr(md5(microtime()), 0, 16);
        $token = crypt($account->Key.$account->Secret, '$5$rounds=5000$'.$solt);
        $token = substr($token, strrpos($token, '$') + 1);
        $this->Token = $token;

        return $this;
    }
}