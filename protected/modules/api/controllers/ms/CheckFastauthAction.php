<?php
namespace api\controllers\ms;

use api\components\Action;
use api\components\Exception;
use user\models\User;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class CheckFastauthAction extends Action
{

    /**
     * @ApiAction(
     *     controller="ms",
     *     title="Проверка хеша",
     *     description="Проверяет переданный хеш",
     *     request=@Request(
     *          method="GET",
     *          url="/ms/checkfastauth",
     *          params={
     *              @Param(title="RunetId", mandatory="Y", description="RunetId пользователя"),
     *              @Param(title="AuthHash", mandatory="Y", description="Проверяемый хеш")
     *          },
     *          response=@Response(body="{'Result':true}")
     *     )
     * )
     */
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