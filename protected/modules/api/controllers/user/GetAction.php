<?php
namespace api\controllers\user;

use api\components\Exception;

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
        $user = $this->getRequestedUser();

        $user = empty($user->MergeUserId)
            ? $user
            : $user->MergeUser;

        $userData = $this
            ->getDataBuilder()
            ->createUser($user);

        if (!empty($user->MergeUserId)) {
            $userData->RedirectRunetId = $user->RunetId;
        }

        $this->setResult($userData);
    }
}
