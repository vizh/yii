<?php
namespace api\controllers\ms;

use api\components\Action;
use api\components\Exception;
use user\models\User;

class CheckFastauthAction extends Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();

        $id = $request->getParam('RunetId');
        $hash = $request->getParam('AuthHash');

        $user = User::model()->byEventId($this->getAccount()->EventId)->byRunetId($id)->find();
        if ($user === null) {
            throw new Exception(202, [$id]);
        }
        $this->setResult(['Result' => ($user->getHash() === $hash)]);
    }
}