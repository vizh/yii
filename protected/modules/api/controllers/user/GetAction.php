<?php
namespace api\controllers\user;

use api\components\Exception;
use api\models\Account;
use competence\models\Question;
use competence\models\Result;
use oauth\models\Permission;
use user\models\User;

/**
 * Class GetAction
 */
class GetAction extends \api\components\Action
{
    /**
     * @throws Exception
     */
    public function run()
    {
        $id = \Yii::app()->getRequest()->getParam('RunetId', null);
        if ($id === null) {
            $id = \Yii::app()->getRequest()->getParam('RocId', null);
        }

        $originalUser = User::model()->byRunetId($id)->find();
        if ($originalUser !== null) {
            $user = !empty($originalUser->MergeUserId) ? $originalUser->MergeUser : $originalUser;
            $this->getDataBuilder()->createUser($user);
            $this->getDataBuilder()->buildUserEmployment($user);
            $this->getDataBuilder()->buildUserEvent($user);
            $this->getDataBuilder()->buildUserData($user);
            $userData = $this->getDataBuilder()->buildUserBadge($user);

            if ($this->hasContactsPermission($user, $userData)) {
                $userData = $this->getDataBuilder()->buildUserContacts($user);
            }

            if (!empty($originalUser->MergeUserId)) {
                $userData->RedirectRunetId = $originalUser->RunetId;
            }

            $this->setResult($userData);
        } else {
            throw new Exception(202, [$id]);
        }
    }

    /**
     * @param User   $user
     * @param object $userData
     * @return bool
     */
    private function hasContactsPermission(User $user, $userData)
    {
        switch ($this->getAccount()->Role) {
            case Account::ROLE_OWN:
                return true;
                break;

            case Account::ROLE_PARTNER_WOC:
                return false;
                break;

            default:
                $permissionModel = Permission::model()->byUserId($user->Id)->byAccountId($this->getAccount()->Id)
                    ->byDeleted(false);

                return isset($userData->Status) || $permissionModel->exists();
        }
    }
}
