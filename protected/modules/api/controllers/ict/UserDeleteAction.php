<?php
namespace api\controllers\ict;

use api\components\Action;
use api\components\Exception;
use application\models\ProfessionalInterest;
use ict\models\Role;
use user\models\User;
use ict\models\User as IctUser;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

class UserDeleteAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Ict",
     *     title="Удалить пользователя",
     *     description="Удаляет пользователя ICT. Поиск пользователя на выход из ICT осуществляется по всем переданным параметрам.",
     *     request=@Request(
     *          method="GET",
     *          url="/ict/userdelete",
     *          params={
     *              @Param(title="RunetId", mandatory="Y", description="RunetId пользователя"),
     *              @Param(title="RoleId", mandatory="Y", description="Роль пользователя ICT. 1- Ведущий эксперт. 2- Эксперт ЭС ICT. 3 - Член программного коммитета."),
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

        $ictUser = IctUser::model()
            ->byUserId($user->Id)
            ->byType($type)
            ->byRoleId($role->Id)
            ->byProfessionalInterestId($profInterest !== null ? $profInterest->Id : null)
            ->find();

        if ($ictUser === null || !empty($ictUser->ExitTime)) {
            throw new Exception(1003, [$user->RunetId, $role->Id]);
        }

        $ictUser->ExitTime = date('Y-m-d H:i:s');
        $ictUser->save();
        $this->setResult(['Success' => true]);
    }
} 