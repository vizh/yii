<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 23.06.2015
 * Time: 14:14
 */

namespace api\controllers\iri;


use api\components\Action;
use iri\models\User;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class UserListAction extends Action
{

    /**
     * @ApiAction(
     *     controller="Iri",
     *     title="Список пользователей",
     *     description="Отдает список пользователей ИРИ (Ошибка)",
     *     request=@Request(
     *          method="GET",
     *          url="/iri/userlist",
     *          params={
     *              @Param(title="Type", mandatory="Y", description="Тип пользователя(expert)")
     *          },
     *          response=@Response(body="")
     *     )
     * )
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $type = $request->getParam('Type');

        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."ExitTime" IS NULL OR "t"."ExitTime" > NOW()');
        $users = User::model()->byType($type)->orderBy('"t"."JoinTime"')->findAll($criteria);

        $result = [];
        foreach ($users as $user) {
            $result[] = $this->getDataBuilder()->createIriUser($user);
        }
        $this->setResult($result);
    }
} 