<?php
namespace api\controllers\user;

use api\components\Exception;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;

/**
 * Class GetAction
 */
class GetAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="User",
     *     title="Детальная информация",
     *     description="Возвращает данные пользователя, включая информацию о статусе участия в мероприятии.
При использовании php-API:
$user = \RunetID\Api\User::model($api)->getByRunetId(RunetId);",
     *     request=@Request(
     *          method="GET",
     *          url="/user/get",
     *          body="",
     *          params={
     *              @Param(title="RunetId", type="", defaultValue="", description="runetid пользователя. Обязательно.")
     *          },
     *          response="{
    'RunetId': 'идентификатор',
    'LastName': 'фамилия',
    'FirstName': 'имя',
    'FatherName': 'отчество',
    'CreationTime': 'дата регистрации пользователя',
    'Photo': 'объект Photo({Small, Medium, Large}) - ссылки на 3 размера фотографии пользователя',
    'Email': 'email пользователя',
    'Gender': 'пол посетителя. Возможные значения: null, male, female',
    'Phones': 'массив с телефонами пользователя, если заданы',
    'Work': 'объект с данными о месте работы пользователя',
    'Status': 'объект с данными о статусе пользователя на мероприятии'
}
Объект Status:
{
    'RoleId': 'идентификатор статуса на мероприятии',
    'RoleTitle': 'название статуса',
    'UpdateTime': 'время последнего обновления'
}"
     *     )
     * )
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
