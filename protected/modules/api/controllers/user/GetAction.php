<?php
namespace api\controllers\user;

use api\components\Exception;
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

        $user = User::model()
            ->byRunetId($id)
            ->find();

        if ($user === null) {
            throw new Exception(202, [$id]);
        }

        $user = empty($user->MergeUserId)
            ? $user
            : $user->MergeUser;

        $userData = $this
            ->getDataBuilder()
            ->createUser($user);

        if (!empty($user->MergeUserId)) {
            $userData->RedirectRunetId = $user->RunetId;
        }

        $data = $this->getEvent()->getUserData($user);

        if (count($data) > 0) {
            $user->Attributes = [];
            $row = array_pop($data);
            foreach ($row->getManager()->getDefinitions() as $definition) {
                $value = $definition->getExportValue($row->getManager());
                $user->Attributes[$definition->name] = $value;
            }
        }

        $this->setResult($userData);
    }
}
