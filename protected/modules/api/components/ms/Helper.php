<?php
namespace api\components\ms;

use api\models\Account;
use api\models\ExternalUser;
use api\components\Exception;
use user\models\User;

class Helper
{
    /**
     * @param Account $account
     * @param User $user
     * @return ExternalUser
     * @throws Exception
     */
    public static function getExternalUser(Account $account, User $user)
    {
        $externalUser = ExternalUser::model()->byAccountId($account->Id)->byUserId($user->Id)->find();
        if ($externalUser === null) {
            throw new Exception(3007, [$user->RunetId]);
        }
        return $externalUser;
    }

    /**
     * @param Account $account
     * @param string $id
     * @return ExternalUser
     * @throws Exception
     */
    public static function getExternalUserById(Account $account, $id)
    {
        $externalUser = ExternalUser::model()->byAccountId($account->Id)->byExternalId($id)->find();
        if ($externalUser === null) {
            throw new Exception(3007, [$id]);
        }
        return $externalUser;
    }

    /**
     * @param ExternalUser $externalUser
     * @return string
     */
    public static function generatePayHash(ExternalUser $externalUser)
    {
        return md5($externalUser->User->Id . 'ez?ZsXS*S$wNDKC153}COEGmle' . $externalUser->ExternalId);
    }

    /**
     * @param Account $account
     * @param User $user
     * @return string
     * @throws Exception
     */
    public static function getPayUrl(Account $account, User $user)
    {
        $externalUser = self::getExternalUser($account, $user);
        return 'http://msdevcon16.runet-id.com/?id=' . $externalUser->ExternalId . '&hash=' . self::generatePayHash($externalUser);
    }
}