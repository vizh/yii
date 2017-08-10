<?php

use api\components\Controller;
use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiController(
 *     controller="Section",
 *     title="Секции мероприятий",
 *     description="Раздел описывает методы для работы с секциями мероприятий."
 * )
 * @ApiObject(
 *     code="SECTION",
 *     title="Секция мероприятия",
 *     json="{
'Id': 'идентификатор',
'Title': 'название',
'Info': 'краткое описание',
'Start': 'время начала',
'End': 'время окончания',
'TypeCode': 'код типа секции',
'Places': ['{$PLACE}'],
'Halls': ['{$HALL}'],
'Attributes': ['атрибуты'],
'UpdateTime': 'дата/время последнего обновления',
'Deleted': 'true - если секция удалена, false - иначе'
}",
 *     description="Секция мероприятия.",
 *     params={
 *          "Id"        : "идентификатор",
"Title"     : "название",
"Info"      : "краткое описание",
"Start"     : "время начала",
"End"       : "время окончания",
"TypeCode"  : "код типа секции",
"Places"    : "массив с названиями залов, в которых проходит секция (deprecated)",
"Halls"     : "залы привязанные к секции",
"Attributes": "дополнительные аттрибуты (произвольный массив ключ => значение, набор ключей и значений зависит от мероприятия)",
"UpdateTime": "дата/время последнего обновления",
"Deleted"   : "true - если секция удалена, false - иначе"
 *     }
 * )
 * @ApiObject(
 *     code="REPORT",
 *     title="Доклад",
 *     description="User, Company, CustomText - всегда будет заполнено только одно из этих полей. Title, Thesis, FullInfo, Url - могут отсутствовать, если нет информации о докладе, либо роль не предполагает выступление с докладом (например, ведущий)",
 *     json="{
'Id': 'идентификатор',
'User': 'объект User (может быть пустым) - делающий доклад пользователь',
'Company': 'объект Company (может быть пустым) - делающая доклад компания',
'CustomText': 'произвольная строка с описанием докладчика',
'SectionRoleId': 'идентификатор роли докладчика на этой секции',
'SectionRoleTitle': 'название роли докладчика на этой секции',
'Order': 'порядок выступления докладчиков',
'Title': 'название доклада',
'Thesis': 'тезисы доклада',
'FullInfo': 'полная информация о докладе',
'Url': 'ссылка на презентацию',
'UpdateTime': 'дата/время последнего обновления',
'Deleted': 'true - если секция удалена, false - иначе.'
}",
 *     params={
 *          "Id"                : "идентификатор",
"User"              : "объект User (может быть пустым) - делающий доклад пользователь",
"Company"           : "объект Company (может быть пустым) - делающая доклад компания",
"CustomText"        : "произвольная строка с описанием докладчика",
"SectionRoleId"     : "идентификатор роли докладчика на этой секции",
"SectionRoleTitle"  : "название роли докладчика на этой секции",
"Order"             : "порядок выступления докладчиков",
"Title"             : "название доклада",
"Thesis"            : "тезисы доклада",
"FullInfo"          : "полная информация о докладе",
"Url"               : "ссылка на презентацию",
"UpdateTime"        : "дата/время последнего обновления",
"Deleted"           : "true - если секция удалена, false - иначе."
 *     }
 * )
 */
class SectionController extends Controller
{
    public function actions()
    {
        return [
            'addFavorite' => '\api\controllers\section\AddFavoriteAction',
            'deleteFavorite' => '\api\controllers\section\DeleteFavoriteAction',
            'favorites' => '\api\controllers\section\FavoritesAction',
            'info' => '\api\controllers\section\InfoAction',
            'list' => '\api\controllers\section\ListAction',
            'reports' => '\api\controllers\section\ReportsAction',
            'updated' => '\api\controllers\section\UpdatedAction',
            'user' => '\api\controllers\section\UserAction'
        ];
    }
}
