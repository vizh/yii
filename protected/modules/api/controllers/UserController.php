<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiContent;
use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiContent(
 *     title="Общие параметры",
 *     description="
<b>Общие параметры для всех методов</b>
Language – переключение языка приложения и его ответов в “ru” или “en”. По-умолчанию, значение устанавливается в 'ru'."
 * )
 * @ApiController(
 *     controller="User",
 *     title="Пользователи",
 *     description="Загрузка данных пользователя. Работа с пользователями."
 * )
 * @ApiObject(
 *     code="USER",
 *     title="Пользователь",
 *     json="{
'RocId': 454,
'RunetId': 454,
'LastName': 'Борзов',
'FirstName': 'Максим',
'FatherName': '',
'CreationTime': '2007-05-25 19:29:22',
'Visible': true,
'Verified': true,
'Gender': 'male',
'Photo': '{$PHOTO}',
'Attributes': {},
'Work': {
'Position': 'Генеральный директор',
'Company': {
'Id': 77529,
'Name': 'RUVENTS'
},
'StartYear': 2014,
'StartMonth': 4,
'EndYear': null,
'EndMonth': null
},
'Status': '{$STATUS}',
'Email': 'max.borzov@gmail.com',
'Phone': '79637654577',
'PhoneFormatted': '8 (963) 765-45-77',
'Phones': ['89637654577', '79637654577']
}",
 *     description="Объект пользователя.",
 *     params={
 *          "RocId":"Айди пользователя",
 *          "RunetId":"RunetId идентификатор пользователя",
 *          "LastName":"Фамилия пользователя",
 *          "FirstName":"Имя пользователя",
 *          "FatherName":"Отчество пользователя",
 *          "CreationTime":"Дата создания аккаунта",
 *          "Visible":"Видимость",
 *          "Verified" : "Подтвержден ли аккаунт",
 *          "Gender":"Пол",
 *          "Photo":"Фотографии пользователя в трех разрешениях",
 *          "Attributes":"Атрибуты",
 *          "Work":"Занимаемая должность",
 *          "Status":"Статус на мероприятии, привязанном к используемому аккаунта api",
 *          "Email":"Электронный адрес",
 *          "Phone":"Номер телефона в формате - 79637654577",
 *          "PhoneFormatted":"Номер телефона в формате - 8 (963) 765-45-77",
 *          "Phones":"Массив всех телефонов"
 *      }
 * )
 * @ApiObject(
 *     code="STATUS",
 *     title="Статус пользователя",
 *     json="{
'RoleId': 1,
'RoleName': 'Участник',
'RoleTitle': 'Участник',
'UpdateTime': '2012-04-18 12:06:49',
'TicketUrl': 'Ссылка на билет',
'Registered': false
}",
 *     description="Статус пользователя на мероприятии",
 *     params={}
 * )
 */
class UserController extends Controller
{
    public function actions()
    {
        return [
            'address' => '\api\controllers\user\AddressAction',
            'auth' => '\api\controllers\user\AuthAction',
            'badge' => '\api\controllers\user\BadgeAction',
            'create' => '\api\controllers\user\CreateAction',
            'edit' => '\api\controllers\user\EditAction',
            'get' => '\api\controllers\user\GetAction',
            'login' => '\api\controllers\user\LoginAction',
            'passwordChange' => '\api\controllers\user\PasswordChangeAction',
            'passwordRestore' => '\api\controllers\user\PasswordRestoreAction',
            'professionalinterests' => '\api\controllers\user\ProfessionalinterestsAction',
            'purposes' => '\api\controllers\user\PurposesAction',
            'search' => '\api\controllers\user\SearchAction',
            'sections' => '\api\controllers\user\SectionsAction',
            'setdata' => '\api\controllers\user\SetdataAction',
            'setphoto' => '\api\controllers\user\SetphotoAction',
            'settings' => '\api\controllers\user\SettingsAction'
        ];
    }
}
