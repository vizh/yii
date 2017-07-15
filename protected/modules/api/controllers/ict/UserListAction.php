<?php

namespace api\controllers\ict;

use api\components\Action;
use ict\models\User;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use Yii;

class UserListAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Ict",
     *     title="Список пользователей",
     *     description="Отдает список пользователей ICT",
     *     request=@Request(
     *          method="GET",
     *          url="/ict/userlist",
     *          params={
     *              @Param(title="Type", mandatory="Y", description="Тип пользователя(expert)")
     *          },
     *          response=@Response(body="")
     *     )
     * )
     */
    public function run()
    {
        $request = Yii::app()->getRequest();
        $type = $request->getParam('Type');

        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."ExitTime" IS NULL OR "t"."ExitTime" > NOW()');
        $users = User::model()->byType($type)->orderBy('"t"."JoinTime"')->findAll($criteria);

        $result = [];
        foreach ($users as $user) {
            $result[] = $this->getDataBuilder()->createIctUser($user);
        }
        $this->setResult($result);
    }
}
