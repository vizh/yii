<?php
namespace api\controllers\iri;

use api\components\Action;
use api\components\Exception;
use application\models\ProfessionalInterest;
use iri\models\Role;
use user\models\User;
use iri\models\User as IriUser;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class UserDeleteAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Iri",
     *     title="Удалить пользователя",
     *     description="Удаляет пользователя ИРИ. Поиск пользователя на выход из ИРИ осуществляется по всем переданным параметрам.",
     *     request=@Request(
     *          method="GET",
     *          url="/iri/userdelete",
     *          params={
     *              @Param(title="RunetId", mandatory="Y", description="RunetId пользователя"),
     *              @Param(title="RoleId", mandatory="Y", description="Роль пользователя ИРИ. 1- Ведущий эксперт. 2- Эксперт ЭС ИРИ. 3 - Член программного коммитета."),
     *              @Param(title="Type", mandatory="Y", description="Тип пользователя(expert)"),
     *              @Param(title="ProfessionalInterestId", mandatory="N", description="Профессиональные интересы.")
     *          },
     *          response=@Response(body="{'Success':true}")
     *     )
     * )
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();

        $runetId = $request->getParam('RunetId');
        $roleId = $request->getParam('RoleId');
        $type = $request->getParam('Type');
        $profInterestId = $request->getParam('ProfessionalInterestId');

        $user = User::model()->byRunetId($runetId)->find();
        if (empty($user)) {
            throw new Exception(202, [$runetId]);
        }

        $role = Role::model()->findByPk($roleId);
        if (empty($role)) {
            throw new Exception(1001, [$roleId]);
        }

        if (empty($type)) {
            throw new Exception(1004);
        }

        $profInterest = null;
        if (!empty($profInterestId)) {
            $profInterest = ProfessionalInterest::model()->findByPk($profInterestId);
            if (empty($profInterest)) {
                throw new Exception(901, [$profInterestId]);
            }
        }

        $iriUser = IriUser::model()
            ->byUserId($user->Id)
            ->byType($type)
            ->byRoleId($role->Id)
            ->byProfessionalInterestId($profInterest !== null ? $profInterest->Id : null)
            ->find();

        if ($iriUser === null || !empty($iriUser->ExitTime)) {
            throw new Exception(1003, [$user->RunetId, $role->Id]);
        }

        $iriUser->ExitTime = date('Y-m-d H:i:s');
        $iriUser->save();
        $this->setResult(['Success' => true]);
    }
} 