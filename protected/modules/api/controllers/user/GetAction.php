<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\builders\Builder;
use api\components\Exception;
use api\models\Account;
use api\models\ExternalUser;
use event\models\section\LinkUser;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\Action\Sample;
use nastradamus39\slate\annotations\ApiAction;
use user\models\User;

class GetAction extends Action
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
     *              @Param(title="RunetId", type="Число", defaultValue="", description="runetid пользователя. Обязателен, если не указан другой параметр."),
     *              @Param(title="Email", type="Строка", defaultValue="", description="email пользователя. Обязателен, если не указан другой параметр."),
     *              @Param(title="ExternalId", type="Строка", defaultValue="", description="внешний идентификатор пользователя для привязки его профиля к сторонним сервисам. Обязателен, если не указан другой параметр."),
     *              @Param(title="Builders", type="Список, разделённый запятами", defaultValue="", description="Набор идентификаторов, модифицирующий результат выполнения запроса. Возможные значения: Person, Birthday, Employment, Event, Data, Badge, Contacts, Address, Attributes, ExternalId, AuthData, Photo, DeprecatedData, Participations, Employments, Settings")
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

        /** @noinspection NotOptimalIfConditionsInspection */
        if ($this->hasRequestParam('RunetId') && $filtered = true) {
            $user->byRunetId($this->getRequestParam('RunetId'));
        }

        /** @noinspection NotOptimalIfConditionsInspection */
        if ($this->hasRequestParam('Email') && $filtered = true) {
            $user->byEmail($this->getRequestParam('Email'));
        }

        /** @noinspection NotOptimalIfConditionsInspection */
        if ($this->hasRequestParam('ExternalId') && $filtered = true) {
            $extuser = ExternalUser::model()
                ->byExternalId($this->getRequestParam('ExternalId'))
                ->byAccountId($this->getAccount()->Id)
                ->find();

            if ($extuser === null) {
                throw new Exception(212, [$this->getRequestParam('ExternalId')]);
            }

            $user->byId($extuser->UserId);
        }

        // Если не было определено ни одного фильтра, то ошибка
        if ($filtered === false) {
            throw new Exception(109, implode(', ', ['RunetId', 'Email', 'ExternalId']));
        }

        // Получим необходимый набор билдеров для определения какие связи необходимо загрузить жадно.
        $builders = $this->getRequestParamArray('Builders', [
            Builder::USER_PERSON,
            Builder::USER_PHOTO,
            Builder::USER_DATA,
            Builder::USER_ATTRIBUTES,
            Builder::USER_EMPLOYMENT,
            Builder::USER_EVENT,
            Builder::USER_BADGE,
            Builder::USER_CONTACTS,
            Builder::USER_EXTERNALID,
            Builder::USER_DEPRECATED_DATA
        ]);

        if (in_array(Builder::USER_PARTICIPATIONS, $builders)) {
            $user->with(['Participants' => ['with' => [
                'Role',
                'Event' => ['with' => [
                    'Type',
                    'LinkSite.Site',
                    'Parts',
                    'LinkPhones.Phone',
                    'LinkAddress.Address.City'
                ]]]]]);
        }

        if (in_array(Builder::USER_CONTACTS_EXTENDED, $builders)) {
            $user->with('LinkServiceAccounts.ServiceAccount');
        }

        // Производим посик пользователя, подготовительный этап закончен
        $user = $user->find();

        if ($user === null) {
            throw new Exception(208);
        }

        // Для данного мультиаккаунта позволено получать только спикеров для секций
        if ($this->getAccount()->Role === Account::ROLE_PROFIT) {
            $isSectionSpeaker = LinkUser::model()
                ->byUserId($user->Id)
                ->byEventId($this->getAccount()->EventId)
                ->byDeleted(false)
                ->exists();

            if ($isSectionSpeaker === false) {
                throw new Exception(231, [$user->RunetId]);
            }
        }

        $user = empty($user->MergeUserId)
            ? $user
            : $user->MergeUser;

        $userData = $this
            ->getDataBuilder()
            ->createUser($user, $builders);

        if (false === empty($user->MergeUserId)) {
            $userData->RedirectRunetId = $user->RunetId;
        }

        $this->setResult($userData);
    }
}
