<?php

namespace api\controllers\user;

use api\components\Exception;
use api\models\ExternalUser;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use user\models\User;

/**
 * Class GetAction
 */
class GetAction extends \api\components\Action
{
    /**
     * @ApiAction(
     *     controller="User",
     *     title="Детальная информация",
     *     description="Возвращает данные пользователя, включая информацию о статусе участия в мероприятии.",
     *     samples={
     *          @Sample(lang="php",code="<?php $user = \RunetID\Api\User::model($api)->getByRunetId(RunetId); ")
     *     },
     *     request=@Request(
     *          method="GET",
     *          url="/user/get",
     *          body="",
     *          params={
     *              @Param(title="RunetId", type="Число", defaultValue="", description="runetid пользователя. Обязателен, если не указан ExternalId."),
     *              @Param(title="ExternalId", type="Строка", defaultValue="", description="внешний идентификатор пользователя для привязки его профиля к сторонним сервисам. Не обязателен.")
     *          },
     *          response=@Response(body="{
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
    'Status': {'RoleId': 'идентификатор статуса на мероприятии','RoleTitle': 'название статуса','UpdateTime': 'время последнего обновления'}
    }")
     *     )
     * )
     */
    public function run()
    {
        $filtered = false;
        $user = User::model();

        if ($this->hasRequestParam('RunetId')) {
            $user->byRunetId($this->getRequestParam('RunetId'));
            $filtered = true;
        }

        if ($this->hasRequestParam('ExternalId')) {
            $extuser = ExternalUser::model()
                ->byExternalId($this->getRequestParam('ExternalId'))
                ->byAccountId($this->getAccount()->Id)
                ->find();

            if ($extuser === null) {
                throw new Exception(212, [$this->getRequestParam('ExternalId')]);
            }

            $user->byId($extuser->UserId);
            $filtered = true;
        }

        // Если не было определено ни одного фильтра, то ошибка
        if ($filtered === false) {
            throw new Exception(109, ['RunetId']);
        }

        $user = $user->find();

        if ($user === null) {
            throw new Exception(208);
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

        $this->setResult($userData);
    }
}
