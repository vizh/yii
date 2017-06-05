<?php
namespace api\controllers\ms;

use api\components\Action;
use api\components\Exception;
use api\models\ExternalUser;

/**
 * Class CreateUserAction
 * @package api\controllers\ms
 *
 * @method \MsController getController()
 */
class PayUrlAction extends Action
{
    public function run()
    {
        $id = \Yii::app()->getRequest()->getParam('ExternalId');
        $account = ExternalUser::model()->byExternalId($id)->byAccountId($this->getAccount()->Id)->find();
        if (empty($account)) {
            throw new Exception(3003, [$id]);
        }
        $this->setResult([
            'PayUrl' => 'http://msdevcon16.runet-id.com/fastauth?id='.$account->User->RunetId.'&hash='.$account->User->getHash()
        ]);
    }

}