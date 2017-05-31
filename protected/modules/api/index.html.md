---
language_tabs:
  - shell: cURL
  - php

---

# 1. Разработчикам

<aside class='notice'><br />
<b>POSTMAN</b><br/><br />
<p>Для удобства сделана коллекция для postman( GUI для выполнения HTTP запросов ). Можно скачать c оф.<br />
<a target='blank' href='https://www.getpostman.com/'>сайта</a>.<br />
Псле установки нужно:<br />
&nbsp;&nbsp;&nbsp;&nbsp;- скачать и импортировать <a target='blank' href='runet-id.com.postman_collection.json'>коллекцию</a> запросов.<br />
&nbsp;&nbsp;&nbsp;&nbsp;- загрузить и импортировать <a target='blank' href='api.runet-id.com.postman_environment.json'>окружение</a><br />
&nbsp;&nbsp;&nbsp;&nbsp;- ApiKey и Hash в окружении заменить на Ваши<br />
</p><br />
<b>SDK</b><br/><br />
Для интеграции с API можно использовать готовый клиент. Описание методов так же можно найти на странице клиента.<br />
&nbsp;&nbsp;&nbsp;&nbsp;- PHP SDK находится <a target='blank' href='https://bitbucket.org/ruvents/runet-id-api-client'>тут</a><br />

</aside>

# 2. Общая информация

<aside class='notice'><br />
Запрос к методам API представляет собой обращение по HTTP-протоколу к URL вида http://api.runet-id.com/<название метода>.<br />
Переменные методов передаются с помощью GET или POST параметров. В качестве результата возвращается JSON объект.<br />
Для каждого мероприятия генерируются ApiKey и Secret. Доступ к API для каждого ApiKey ограничивается списком ip-адресов.<br />
<strong>Обязательные для всех методов заголовки:</strong><br />
1. ApiKey<br />
2. Hash - вычисляется по формуле md5(ApiKey+Secret)<br />
<strong>Формат возвращаемых ошибок:</strong><br />
{<br />
Error: {Code: int, Message: string}<br />
}<br />
<strong>При использовании php-API:</strong><br />
$api = new \RunetID\Api\Api(ApiKey, Secret, Cache = null);<br />
где Cache - объект класса, реализующего интерфейс \RunetID\Api\ICache
</aside>

# 3. Общие параметры

<aside class='notice'><br />
<b>Общие параметры для всех методов</b><br />
Language – переключение языка приложения и его ответов в “ru” или “en”. По-умолчанию, значение устанавливается в 'ru'.
</aside>

# 4. Авторизация

<aside class='notice'><br />
<b>Шаг 1</b><br />
Добавить следующий код на страницу с вызовом диалога авторизации<br />
window.rIDAsyncInit = function() {<br />
&nbsp;&nbsp;&nbsp;&nbsp;rID.init({<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;apiKey: <key><br />
&nbsp;&nbsp;&nbsp;&nbsp;});<br />
&nbsp;&nbsp;&nbsp;&nbsp;// Additional initialization code here<br />
};<br />
<br />
// Load the SDK Asynchronously<br />
(function(d){<br />
var js, id = 'runetid-jssdk', ref = d.getElementsByTagName('script')[0];<br />
if (d.getElementById(id)) {return;}<br />
js = d.createElement('script'); js.id = id; js.async = true;<br />
js.src = '//runet-id.com/javascripts/api/runetid.js';<br />
ref.parentNode.insertBefore(js, ref);<br />
}(document));<br />
<br />
<b>Шаг 2</b><br />
Вызвать метод rID.login(); для создания окна авторизации<br />
<br />
<b>Шаг 3</b><br />
После авторизации, пользователь будет переадресован на исходную страницу с GET-параметром token (переадресация происходит в рамках окна авторизации)<br />
<br />
<b>Шаг 4</b><br />
После получения token - необходимо сделать запрос к API методу user/auth передав параметр token, полученный выше.<br />
API вернет данные авторизованного пользователя (RUNET-ID, ФИО, Место работы, Контакты).<br />
<br />
<b>При использовании php-API:</b><br />
$user = \RunetID\Api\User::model($api)->getByToken(token);<br />

</aside>


# 5. Описание объектов

## 5.1. Компания
Компания


> Объект: 

```json
{
    "Id": 77529,
    "Name": "RUVENTS",
    "FullName": "ООО «РУВЕНТС»",
    "Info": null,
    "Logo": "LNK[Лого компании](#5-2)",
    "Url": "http:\/\/ruvents.com",
    "Phone": "+7 (495) 6385147",
    "Email": "info@ruvents.com",
    "Address": "г. Москва, Пресненская наб., д. 12",
    "Cluster": "РАЭК",
    "ClusterGroups": [],
    "OGRN": null,
    "Employments": [
        "LNK[Пользователь](#5-17)"
    ]
}
```

Параметр | Описание
-------- | --------
Id | Идентификатор компании
Name | Название
FullName | Полное название
Info | Информация о компании
Logo | Массив ссылок на логотипы в трех разрешениях
Url | Сылка на сайт компании
Phone | Телефон
Email | Email компании
Address | Адрес компании
Cluster | Кластер,к которому относится компания. Пока только РАЭК
ClusterGroups | Список груп кластеров
OGRN | ОГРН компании
Employments | Массив сотрудников компании

## 5.2. Лого компании
Логотипы компании в трех разрешениях


> Объект: 

```json
{
    "Small": "Ссылка на лого компании (50px*50px)",
    "Medium": "Ссылка на лого компании (90px*90px)",
    "Large": "Ссылка на лого компании (200px*200px)"
}
```

Параметр | Описание
-------- | --------
Small | Логотип размерами 50px на 50px
Medium | Логотип размерами 90px на 90px
Large | Логотип размерами 200px на 200px

## 5.3. Фото пользователя
Фото пользователя в трех разрешениях


> Объект: 

```json
{
    "Small": "http:\/\/runet-id.com\/files\/photo\/0\/454_50.jpg?t=1475191745",
    "Medium": "http:\/\/runet-id.com\/files\/photo\/0\/454_90.jpg?t=1475191306",
    "Large": "http:\/\/runet-id.com\/files\/photo\/0\/454_200.jpg?t=1475191317"
}
```

Параметр | Описание
-------- | --------
Small | Фото размерами 50px на 50px
Medium | Фото размерами 90px на 90px
Large | Фото размерами 200px на 200px

## 5.4. Тест
Тест


> Объект: 

```json
{
    "Id": 1,
    "Title": "Исследование профессионального <br>интернет-сообщества",
    "Questions": {
        "C2": {
            "Title": "Укажите Ваш пол",
            "Values": {
                "1": "Мужской",
                "2": "Женский"
            }
        },
        "Q10": {
            "Title": "С какого курса вы работаете на постоянной основе?",
            "Values": {
                "1": "не работаю и никогда не работал на постоянной основе",
                "2": "работал еще до поступления в вуз",
                "3": "с первого курса",
                "4": "со второго курса",
                "5": "с третьего курса",
                "6": "с четвертого курса",
                "7": "с пятого курса",
                "8": "с шестого курса",
                "9": "со времен учебы в аспирантуре или получения второго высшего образования",
                "10": "начал работать на постоянной основе после завершения обучения"
            }
        }
    }
}
```

Параметр | Описание
-------- | --------
Id | Идентификатор теста
Title | Название теста
Questions | Список вопросов к тесту. Каждый вопрос состоит из кода вопроса(например C2), текста вопроса (например - Укажите Ваш пол) и варианты ответа в виде списка.

## 5.5. Результаты теста
Результаты теста


> Объект: 

```json
{
    "competence\\models\\tests\\mailru2013\\First": {
        "Value": "2"
    },
    "competence\\models\\tests\\mailru2013\\S2": {
        "Value": "5"
    },
    "competence\\models\\tests\\mailru2013\\E1_1": {
        "Value": [
            "1",
            "3",
            "7"
        ]
    },
    "competence\\models\\tests\\mailru2013\\E2": {
        "Value": {
            "1": "4",
            "3": "6",
            "7": "1"
        }
    }
}
```

Параметр | Описание
-------- | --------

## 5.6. Место
Место встречи.


> Объект: 

```json
{
    "Id": 4,
    "Name": "Meeting point 1",
    "Reservation": "true",
    "ReservationTime": 20
}
```

Параметр | Описание
-------- | --------
Id | Айди места встречи
Name | Название
Reservation | Возможность бронирования

## 5.7. Встреча
Встреча.


> Объект: 

```json
{
    "Id": 2817,
    "Place": "LNK[Место](#5-6)",
    "Creator": "LNK[Пользователь](#5-17)",
    "Users": [
        {
            "Status": 1,
            "Response": "",
            "User": "LNK[Пользователь](#5-17)"
        }
    ],
    "UserCount": 1,
    "Start": "2009-02-15 00:00:00",
    "Date": "2009-02-15",
    "Time": "00:00",
    "Type": 1,
    "Purpose": "",
    "Subject": "",
    "File": "",
    "CreateTime": "2017-02-12 23:12:34",
    "Status": 2,
    "CancelResponse": ""
}
```

Параметр | Описание
-------- | --------
Id | Идентификатор встречи
Place | Место встречи
Creator | Создатель встречи
Users | Пользователи, приглашенные на встречу
UserCount | Колличество пользователей приглашенных на встречу
Start | Время начала встречи
Date | Дата встречи
Time | Время встречи
Type | Тип встречи. 1-закрытая,2-открытая
Purpose | Цель встречи
Subject | Тема встречи
File | Прилагаемые материалы. Файл.
CreateTime | Дата создания
Status | Статус. 1-открыта,2-отменена.

## 5.8. Зал
Зал, где может проходить часть или все мероприятие. Залы привязываются к секциям.


> Объект: 

```json
{
    "Id": "599",
    "Title": "Зал 1",
    "UpdateTime": "2017-02-19 12:29:58",
    "Order": "0",
    "Deleted": false
}
```

Параметр | Описание
-------- | --------
Id | Идентификатор
Title | Название зала
UpdateTime | Время последнего обновления зала в формате (Y-m-d H:i:s)
Order | Порядок вывода залов
Deleted | true - если зал удален, false - иначе

## 5.9. Мероприятие
Информация о мероприятии.


> Объект: 

```json
{
    "EventId": 3206,
    "IdName": "Meropriyatiegoda",
    "Name": "Мероприятие 2017 года",
    "Title": "Мероприятие 2017 года",
    "Info": "Краткое описание мероприятия 2017",
    "Place": "г. Волгоград, пр-т Ленина, д. 123",
    "Url": "http:\/\/www.runet-id.com",
    "UrlRegistration": "",
    "UrlProgram": "",
    "StartYear": 2017,
    "StartMonth": 2,
    "StartDay": 22,
    "EndYear": 2017,
    "EndMonth": 2,
    "EndDay": 22,
    "Image": {
        "Mini": "http:\/\/runet-id.dev\/files\/event\/Meropriyatiegoda\/50.png",
        "MiniSize": {
            "Width": 50,
            "Height": 50
        },
        "Normal": "http:\/\/runet-id.dev\/files\/event\/Meropriyatiegoda\/120.png",
        "NormalSize": {
            "Width": 120,
            "Height": 120
        }
    },
    "GeoPoint": [
        "",
        ""
    ],
    "Address": "г. Волгоград, пр-т Ленина, д. 123",
    "Menu": [
        {
            "Type": "program",
            "Title": "Программа"
        }
    ],
    "Statistics": {
        "Participants": {
            "ByRole": {
                "24": 1
            },
            "TotalCount": 1
        }
    },
    "FullInfo": "<p>Подробное описание мероприятия 2017<\/p>\r\n"
}
```

Параметр | Описание
-------- | --------
EventId | Идентификатор мероприятия
IdName | Символьный код мероприятия
Name | Название мероприятия
Title | Название мероприятия
Info | Информация о мероприятии
Place | Место проведения мероприятия
Url | Сайт мероприятия
UrlRegistration | 
UrlProgram | 
StartYear | Год начала мероприятия
StartMonth | Месяц начала мероприятия
StartDay | День начала мероприятия
EndYear | Год окончания мероприятия
EndMonth | Месяц окончания мероприятия
EndDay | День окончания мероприятия
Image | Ссылки на логотип мероприятия в двух разрешениях
GeoPoint | Координаты места проведеня мероприятия
Address | Адрес места проведения мероприятия
Menu | 
Statistics | Статистика мероприятия по участникам/ролям
FullInfo | Подробное описание мероприятия

## 5.10. Статус на мероприятии
Статус на мероприятии.


> Объект: 

```json
{
    "RoleId": "идентификатор статуса на мероприятии",
    "RoleTitle": "название статуса",
    "UpdateTime": "время последнего обновления"
}
```

Параметр | Описание
-------- | --------
RoleId | Идентификатор роли участника мероприятия.
RoleTitle | Название роли
UpdateTime | Время последнего обновления

## 5.11. Материал
Материал.


> Объект: 

```json
{
 *         'Id': 1,
 *         'Name': '',
 *         'File': '',
 *         'Comment': true,
 *         'Partner':{
 *             'Name': '',
 *             'Site': '',
 *             'Logo': ''
 *     }
```

Параметр | Описание
-------- | --------
Id | Идентификатор
Name | Название
Comment | Комментарий
File | Файл для скачивания

## 5.12. Заказ
Зал.


> Объект: 

```json
{
    "Id": "идентификатор элемента заказа",
    "Product": "объект Product",
    "Owner": "объект User (сокращенный, только основные данные пользователя)",
    "PriceDiscount": "цена с учетом скидки",
    "Paid": "статус оплаты",
    "PaidTime": "время оплаты",
    "Attributes": "массив с атрибутами (если заданы)",
    "Discount": "размер скидки от 0 до 1, где 0 - скидки нет, 1 - скидка 100%",
    "CouponCode": "код купона, по которому была получена скидка",
    "GroupDiscount": "была скидка групповая или нет"
}
```

Параметр | Описание
-------- | --------
Id | идентификатор

## 5.13. Оплаченный заказ
Оплаченный заказ.


> Объект: 

```json
{
    "Id": "идентификатор элемента заказа",
    "Product": "объект Product",
    "Owner": "объект User (сокращенный, только основные данные пользователя)",
    "PriceDiscount": "цена с учетом скидки",
    "Paid": "статус оплаты",
    "PaidTime": "время оплаты",
    "Attributes": "массив с атрибутами (если заданы)",
    "Discount": "размер скидки от 0 до 1, где 0 - скидки нет, 1 - скидка 100%",
    "CouponCode": "код купона, по которому была получена скидка",
    "GroupDiscount": "была скидка групповая или нет"
}
```

Параметр | Описание
-------- | --------
Id | идентификатор

## 5.14. Товар
Оплаченный заказ.


> Объект: 

```json
{
    "Id": "идентификатор",
    "Manager": "строка, название менеджера (участие, питание и другие)",
    "Title": "название товара",
    "Price": "текущая цена",
    "Attributes": "массив ключ-значение с атрибутами товара"
}
```

Параметр | Описание
-------- | --------
Id | идентификатор

## 5.15. Секция мероприятия
Секция мероприятия.


> Объект: 

```json
{
    "Id": "идентификатор",
    "Title": "название",
    "Info": "краткое описание",
    "Start": "время начала",
    "End": "время окончания",
    "TypeCode": "код типа секции",
    "Places": [
        "LNK[Место](#5-6)"
    ],
    "Halls": [
        "LNK[Зал](#5-8)"
    ],
    "Attributes": [
        "атрибуты"
    ],
    "UpdateTime": "дата\/время последнего обновления",
    "Deleted": "true - если секция удалена, false - иначе"
}
```

Параметр | Описание
-------- | --------
Id | идентификатор
Title | название
Info | краткое описание
Start | время начала
End | время окончания
TypeCode | код типа секции
Places | массив с названиями залов, в которых проходит секция (deprecated)
Halls | залы привязанные к секции
Attributes | дополнительные аттрибуты (произвольный массив ключ => значение, набор ключей и значений зависит от мероприятия)
UpdateTime | дата/время последнего обновления
Deleted | true - если секция удалена, false - иначе

## 5.16. Доклад
User, Company, CustomText - всегда будет заполнено только одно из этих полей. Title, Thesis, FullInfo, Url - могут отсутствовать, если нет информации о докладе, либо роль не предполагает выступление с докладом (например, ведущий)


> Объект: 

```json
{
    "Id": "идентификатор",
    "User": "объект User (может быть пустым) - делающий доклад пользователь",
    "Company": "объект Company (может быть пустым) - делающая доклад компания",
    "CustomText": "произвольная строка с описанием докладчика",
    "SectionRoleId": "идентификатор роли докладчика на этой секции",
    "SectionRoleTitle": "название роли докладчика на этой секции",
    "Order": "порядок выступления докладчиков",
    "Title": "название доклада",
    "Thesis": "тезисы доклада",
    "FullInfo": "полная информация о докладе",
    "Url": "ссылка на презентацию",
    "UpdateTime": "дата\/время последнего обновления",
    "Deleted": "true - если секция удалена, false - иначе."
}
```

Параметр | Описание
-------- | --------
Id | идентификатор
User | объект User (может быть пустым) - делающий доклад пользователь
Company | объект Company (может быть пустым) - делающая доклад компания
CustomText | произвольная строка с описанием докладчика
SectionRoleId | идентификатор роли докладчика на этой секции
SectionRoleTitle | название роли докладчика на этой секции
Order | порядок выступления докладчиков
Title | название доклада
Thesis | тезисы доклада
FullInfo | полная информация о докладе
Url | ссылка на презентацию
UpdateTime | дата/время последнего обновления
Deleted | true - если секция удалена, false - иначе.

## 5.17. Пользователь
Объект пользователя.


> Объект: 

```json
{
    "RocId": 454,
    "RunetId": 454,
    "LastName": "Борзов",
    "FirstName": "Максим",
    "FatherName": "",
    "CreationTime": "2007-05-25 19:29:22",
    "Visible": true,
    "Verified": true,
    "Gender": "male",
    "Photo": "LNK[Фото пользователя](#5-3)",
    "Attributes": {},
    "Work": {
        "Position": "Генеральный директор",
        "Company": {
            "Id": 77529,
            "Name": "RUVENTS"
        },
        "StartYear": 2014,
        "StartMonth": 4,
        "EndYear": null,
        "EndMonth": null
    },
    "Status": "LNK[Статус пользователя](#5-18)",
    "Email": "max.borzov@gmail.com",
    "Phone": "79637654577",
    "PhoneFormatted": "8 (963) 765-45-77",
    "Phones": [
        "89637654577",
        "79637654577"
    ]
}
```

Параметр | Описание
-------- | --------
RocId | Айди пользователя
RunetId | RunetId идентификатор пользователя
LastName | Фамилия пользователя
FirstName | Имя пользователя
FatherName | Отчество пользователя
CreationTime | Дата создания аккаунта
Visible | Видимость
Verified | Подтвержден ли аккаунт
Gender | Пол
Photo | Фотографии пользователя в трех разрешениях
Attributes | Атрибуты
Work | Занимаемая должность
Status | Статус на мероприятии, привязанном к используемому аккаунта api
Email | Электронный адрес
Phone | Номер телефона в формате - 79637654577
PhoneFormatted | Номер телефона в формате - 8 (963) 765-45-77
Phones | Массив всех телефонов

## 5.18. Статус пользователя
Статус пользователя на мероприятии


> Объект: 

```json
{
    "RoleId": 1,
    "RoleName": "Участник",
    "RoleTitle": "Участник",
    "UpdateTime": "2012-04-18 12:06:49",
    "TicketUrl": "Ссылка на билет",
    "Registered": false
}
```

Параметр | Описание
-------- | --------



# 6. Компании

Описаие методов для работы с компаниями

## 6.1. Информация о компании
Возвращает подробную информацию о компании. Так же в ответе будет список сотрудников компании (Employments).


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
        'http://api.runet-id.com/company/get?CompanyId=77529'
```


> Ответ: 

```json
"LNK[Компания](#5-1)"
```

`GET http://api.runet-id.com/company/get` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
CompanyId | Айди компании. | Y


## 6.2. Список
Список компаний из указанного кластера. Пока используется только РАЭК. В списке не присутствуют сотрудники компаний.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
            'http://api.runet-id.com/company/list?Cluster=%D0%A0%D0%90%D0%AD%D0%9A'
```


> Ответ: 

```json
{
    "Companies": [
        "LNK[Компания](#5-1)"
    ]
}
```

`GET http://api.runet-id.com/company/list` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
Cluster | (enum[РАЭК]) – кластер, компании которого необходимо получить. В данный момент может принимать единственное значение: РАЭК. | Y
Query | Поисковая строка. | N
PageToken | Указатель на следующую страницу, берется из результата последнего запроса, значения NextPageToken. | N
MaxResults | MaxResults (число) - максимальное количество компаний в ответе, от 0 до 200. Если нужно загрузить более 200 участников, необходимо использовать постраничную загрузку. | N


# 7. Компетенции

Описаие методов для работы с компетенциями.

## 7.1. Результаты теста
Результаты теста с заданным TestId для пользователя с заданным RunetId.


> Ответ: 

```json
"LNK[Результаты теста](#5-5)"
```

`GET http://api.runet-id.com/competence/result` 
### Parameters
Название | Обязательно
---------------- | ----------------------
RunetId | Y
TestId | Y


## 7.2. Тесты
Доступные для мероприятия тесты.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX' 'http://api.runet-id.com/competence/tests'
```


> Ответ: 

```json
[
    "LNK[Тест](#5-4)"
]
```

`GET http://api.runet-id.com/competence/tests` 


# 8. Встречи

Методы для работы со встречами.

## 8.1. Принять приглашение
Если встреча с заданным идентификатором существует, то приглашение на нее 'принимается'.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/connect/accept?MeetingId=2817&RunetId=678047'
```


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/connect/accept` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
MeetingId | Айди встречи. | Y
RunetId | RunetId пользователя. | Y


## 8.2. Отмена встречи
Отменяет встречу. Статус встречи меняется на 'отменена'


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/connect/cancel?RunetId=678047&MeetingId=2817&Response=%D0%9F%D1%80%D0%B8%D1%87%D0%B8%D0%BD%D0%B0%20%D0%BE%D1%82%D0%BC%D0%B5%D0%BD%D1%8B'
```


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/connect/cancel` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
MeetingId | Айди встречи | Y
RunetId | Runetid создателя встречи | Y
Response | Причина отмены | Y


## 8.3. Создание встречи
Создает новую встречу


```shell
curl -X POST -H 'Content-Type: application/x-www-form-urlencoded' -H 'ApiKey: XXX' -H 'Hash: XXX' -d 'PlaceId=1&CreatorId=678047&UserId=678047&Date=15-Feb-2017&Type=1&Purpose=Предложение&Subject=Тема встречи&File='
    'http://api.runet-id.com/connect/create'
```


> Ответ: 

```json
{
    "Success": true,
    "Meeting": "LNK[Встреча](#5-7)",
    "Errors": []
}
```

`POST http://api.runet-id.com/connect/create` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
PlaceId | Айди места встречи. | Y
CreatorId | Runetid создателя встречи. | Y
UserId | Runetid пользователя, приглашенного на встречу. | Y
Date | Дата встречи. Формат - http://php.net/manual/ru/datetime.createfromformat.php | Y
Type | Тип встречи. 1-закрытая,2-открытая. | Y
Purpose | Предложение. | N
Subject | Тема встречи | N
File | Прилагаемый файл | N


## 8.4. Отклонение приглашения
Отклоняет приглашение.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/connect/decline?RunetId=678047&MeetingId=2817'
```


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/connect/decline` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | Пользователь | Y
MeetingId | Id встречи | Y


## 8.5. Отправляет приглашение
Отправляет приглашение пользователю на встречу.


```shell
curl -X POST -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/connect/invite?PlaceId=1&CreatorId=1&UserId=1&Date=12-12-2017&Type=1&Purpose=1&Subject=1&File='
```


> Ответ: 

```json
{
    "Success": true,
    "Meeting": "LNK[Встреча](#5-7)",
    "Errors": []
}
```

`POST http://api.runet-id.com/connect/invite` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
PlaceId | Айди места встречи. | Y
CreatorId | Runetid создателя встречи. | Y
UserId | Runetid пользователя, приглашенного на встречу. | Y
Date | Дата встречи. Формат - http://php.net/manual/ru/datetime.createfromformat.php | Y
Type | Тип встречи. 1-закрытая,2-открытая. | Y
Purpose | Предложение. | N
Subject | Тема встречи | N
File | Прилагаемый файл | N


## 8.6. Список встреч
Списк встреч.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/connect/list?UserId=678047&RunetId=678047&CreatorId=678047'
```


> Ответ: 

```json
{
    "Success": true,
    "Meetings": [
        "LNK[Встреча](#5-7)"
    ]
}
```

`GET http://api.runet-id.com/connect/list` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId |  | N
CreatorId |  | N
UserId |  | N
Type | Тип встречи. 1-закрытая,2-открытая. | N
Status | Сатус встречи. 1-открыта. 2-отменена. | N


## 8.7. Места
Места для встреч.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/connect/places'
```


> Ответ: 

```json
{
    "Success": true,
    "Places": [
        "LNK[Место](#5-6)"
    ]
}
```

`GET http://api.runet-id.com/connect/places` 


## 8.8. Рекомендации
Рекомендации.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/connect/recommendations?RunetId=678047'
```


> Ответ: 

```json
{
    "Success": true,
    "Users": [
        "LNK[Пользователь](#5-17)"
    ]
}
```

`GET http://api.runet-id.com/connect/recommendations` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя для которого вернутся рекоммендации. | Y


## 8.9. Поиск
Поиск по участникам мероприятия. (Не работает)


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX' 'http://api.runet-id.com/connect/search?RunetId=678047&q=Ruvents'
```


> Ответ: 

```json
{
    "Success": true,
    "Users": [
        "LNK[Пользователь](#5-17)"
    ]
}
```

`GET http://api.runet-id.com/connect/search` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RoleId | Роль участника. | N
Attributes | Атрибуты. | N
q | Поисковый запрос | N


## 8.10. Присоединиться к встрече
Присоединиться к встрече.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/connect/signup?RunetId=678047&MeetingId=2817'
```


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/connect/signup` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | Runetid пользователя. | Y
MeetingId | Id встречи. | Y


# 9. Мероприятия

Методы для работы с мероприятиями. Аккаунт API соответствует конкретному мероприятию. Методы описанные в данном разделе работают с мероприятием аккаунта. Но можно получить список мероприятий в методе list.

## 9.1. Смена роли
Меняет роль заданному пользователю.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/changerole?RunetId=678047&RoleId=6'
```


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/event/changerole` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RoleId | Id новой роли. | Y
RunetId | RunetId пользователя. | Y


## 9.2. Компании
Выбираются все компании, сотрудники которых учавствуют в мероприятии.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/companies'
```


> Ответ: 

```json
{
    "77529": "LNK[Компания](#5-1)"
}
```

`GET http://api.runet-id.com/event/сompanies` 


## 9.3. Залы
Список залов мероприятия.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/halls'
```


> Ответ: 

```json
[
    "LNK[Зал](#5-8)"
]
```

`GET http://api.runet-id.com/event/halls` 
### Parameters
Название | Описание
---------------- | ----------------
FromUpdateTime | (Y-m-d H:i:s) - время последнего обновления залов, начиная с которого формировать список.
WithDeleted | Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные залы, иначе только не удаленные.


## 9.4. Информация о мероприятии
Информация о мероприятии.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/info'
```


> Ответ: 

```json
"LNK[Мероприятие](#5-9)"
```

`GET http://api.runet-id.com/event/info` 
### Parameters
Название | Описание
---------------- | ----------------
FromUpdateTime | (Y-m-d H:i:s) - время последнего обновления залов, начиная с которого формировать список.
WithDeleted | Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные залы, иначе только не удаленные.


## 9.5. Список мероприятий
Список мероприятий за указанный год. Если год не указан - выбираются мероприятия за текущий. Каждое мероприятие выводится без статистики.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/list?Year=2017'
```


> Ответ: 

```json
[
    "LNK[Мероприятие](#5-9)"
]
```

`GET http://api.runet-id.com/event/list` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
Year | Год. | N


## 9.6. Отменя участия.
Отмена участия посетителя. Только для создателей мероприятия.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/participationcancel?RunetId=111111'
```


> Ответ: 

```json
{
    "success": true
}
```

`GET http://api.runet-id.com/event/participationcancel` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя | Y


## 9.7. Цели мероприятия
Цели мероприятия.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/purposes'
```


> Ответ: 

```json
[
    {
        "Id": 3,
        "Title": "Выступление с докладом"
    },
    {
        "Id": 2,
        "Title": "Обмен опытом"
    },
    {
        "Id": 1,
        "Title": "Образование \/ получение новых знаний"
    },
    {
        "Id": 4,
        "Title": "Хантинг"
    }
]
```

`GET http://api.runet-id.com/event/purposes` 


## 9.8. Регистрация
Регисрация пользователя на мероприятии с заданной ролью.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/register?RunetId=678047&RoleId=2'
```


> Ответ: 

```json
{
    "Success": "true"
}
```

`GET http://api.runet-id.com/event/register` 
### Parameters
Название | Описание
---------------- | ----------------
RunetId | Идентификатор пользователя. Обязательно.
RoleId | Идентификатор статуса, который пользователь должен получить на мероприятии. Обязательно.


## 9.9. Роли
Список возможных ролей участника мероприятия.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/roles'
```


> Ответ: 

```json
[
    "LNK[Статус на мероприятии](#5-10)"
]
```

`GET http://api.runet-id.com/event/roles` 


## 9.10. RunetId участников мероприятия
Список RunetId,Ролей участников мерроприятия.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/runetids'
```


> Ответ: 

```json
{
    "308": 1,
    "311": 24,
    "314": 24
}
```

`GET http://api.runet-id.com/event/runetids` 


## 9.11. Статистика
Статистика по мероприятию. Возвращает колличество участников мероприятия, сгруппированные по ролям.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/statistics'
```


> Ответ: 

```json
{
    "Roles": [
        {
            "RoleId": 25,
            "Name": "Эксперт ПК",
            "Priority": 72,
            "Count": 32
        },
        {
            "RoleId": 26,
            "Name": "Видеоучастник",
            "Priority": 15,
            "Count": 4
        }
    ],
    "Total": 36
}
```

`GET http://api.runet-id.com/event/statistics` 


## 9.12. Участники
Список участников мероприятия с заданной ролью.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/users?RoleId=1'
```


> Ответ: 

```json
{
    "Users": [
        "LNK[Пользователь](#5-17)"
    ],
    "TotalCount": 1
}
```

`GET http://api.runet-id.com/event/users` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RoleId | Массив идентификаторов ролей | Y


## 9.13. Фотографии участников
Возвращает Фотографии участников одним архивом.

`GET http://api.runet-id.com/event/usersphotos` 


## 9.14. Добавление цели мероприятия
Добавляет новую цель посещения мероприятия пользователем.'


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/purpose/add` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | Идентификатор участника. | Y
PurposeId | Идентификатор цели посещения мероприятия. | Y


## 9.15. Удаление цели мероприятия
Удаляет цель посещения мероприятия пользователем.'


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/purpose/delete` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | Идентификатор участника. | Y
Purpose Id | Идентификатор цели посещения мероприятия. | Y


# 10. ICT



## 10.1. Роли ICT
Возвращает список ролей для ICT

`GET http://api.runet-id.com/ict/roles` 


## 10.2. Добавить пользователя
Добавляет пользователя ICT


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/ict/useradd` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя | Y
RoleId | Роль пользователя ICT. 1 -  Лидер. 2 - Эксперт. 3 - участник. | Y
Type | Тип пользователя(expert) | Y
ProfessionalInterestId | Профессиональные интересы. | N


## 10.3. Удалить пользователя
Удаляет пользователя ICT. Поиск пользователя на выход из ICT осуществляется по всем переданным параметрам.


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/ict/userdelete` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя | Y
RoleId | Роль пользователя ICT. 1- Ведущий эксперт. 2- Эксперт ЭС ICT. 3 - Член программного коммитета. | Y
Type | Тип пользователя(expert) | Y
ProfessionalInterestId | Профессиональные интересы. | N


## 10.4. Список пользователей
Отдает список пользователей ICT

`GET http://api.runet-id.com/ict/userlist` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
Type | Тип пользователя(expert) | Y


# 11. Приглашения на мероприятия

Приглашения на мероприятия.

## 11.1. Запросы на участие
Вернет запросы на участие в мероприятии пользователя с заданным RunetId


> Ответ: 

```json
{
    "Sender": "LNK[Пользователь](#5-17)",
    "Owner": "LNK[Пользователь](#5-17)",
    "CreationTime": "2017-02-14 14:12:27",
    "Event": "LNK[Мероприятие](#5-9)",
    "Approved": 0
}
```

`GET http://api.runet-id.com/invite/get` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя | Y


## 11.2. Создание приглашения
Создает приглашение на участие в мероприятии пользователя RunetId


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/invite/request` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя | Y


# 12. ИРИ



## 12.1. Роли ИРИ
Возвращает список ролей для ИРИ

`GET http://api.runet-id.com/iri/roles` 


## 12.2. Добавить пользователя
Добавляет пользователя ИРИ


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/iri/useradd` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя | Y
RoleId | Роль пользователя ИРИ. 1- Ведущий эксперт. 2- Эксперт ЭС ИРИ. 3 - Член программного коммитета. | Y
Type | Тип пользователя(expert) | Y
ProfessionalInterestId | Профессиональные интересы. | N


## 12.3. Удалить пользователя
Удаляет пользователя ИРИ. Поиск пользователя на выход из ИРИ осуществляется по всем переданным параметрам.


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/iri/userdelete` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя | Y
RoleId | Роль пользователя ИРИ. 1- Ведущий эксперт. 2- Эксперт ЭС ИРИ. 3 - Член программного коммитета. | Y
Type | Тип пользователя(expert) | Y
ProfessionalInterestId | Профессиональные интересы. | N


## 12.4. Список пользователей
Отдает список пользователей ИРИ (Ошибка)

`GET http://api.runet-id.com/iri/userlist` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
Type | Тип пользователя(expert) | Y


# 13. Microsoft

Спецпроект для Microsoft

## 13.1. Проверка хеша
Проверяет переданный хеш


> Ответ: 

```json
{
    "Result": true
}
```

`GET http://api.runet-id.com/ms/checkfastauth` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя | Y
AuthHash | Проверяемый хеш | Y


## 13.2. Создание пользователя
Создает нового пользователя


> Ответ: 

```json
{
    "Result": true
}
```

`GET http://api.runet-id.com/ms/createuser` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя | Y
AuthHash | Проверяемый хеш | Y


# 14. Материалы Paperless

Методы для работы с механикой Paperless.

## 14.1. Отметка о прикладывания бейджа к устройству
Отметка о прикладывания бейджа к устройству.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX' 'http://api.runet-id.com/paperless/materials/search'
```

`POST http://api.runet-id.com/paperless/materials/search` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
BadgeUID | Уникальный UID приложенного RFID-бейджа. | Y
BadgeTime | Время прикладывания RFID-бейджа. | Y
DeviceNumber | Номер устройства. | Y
Process | Если передано true, то сигнал сразу же обрабатывается. | N


## 14.2. Информация по материалу
Информация по партнёрскому материалу Paperless.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX' 'http://api.runet-id.com/paperless/materials/get?MaterialId=1'
```


> Ответ: 

```json
[
    "LNK[Материал](#5-11)"
]
```

`GET http://api.runet-id.com/paperless/materials/get` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
MaterialId | Идентификатор материала. | Y


## 14.3. Список материалов
Список партнёрских материалов Paperless.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX' 'http://api.runet-id.com/paperless/materials/search'
```


> Ответ: 

```json
[
    "LNK[Материал](#5-11)"
]
```

`GET http://api.runet-id.com/paperless/materials/search` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RUNET-ID посетителя для выборки доступных ему материалов. | N
RoleId | Один или несколько статусов участия на мероприятии для выборки доступных им материалов. Внимание! Данное условие перекрывает результаты фильтрации по RunetId. Совместное использование параметров RunetId и RoleId не проектировалось. | N


# 15. Платежный кабинет

Методы для работы с платежным кабинетом.

## 15.1. Добавление
Добавление заказа


> Ответ: 

```json
"LNK[Заказ](#5-12)"
```

`GET http://api.runet-id.com/pay/add` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
ProductId | Идентификатор товара. | Y
PayerRunetId | Идентификатор плательщика. Обязательно. | Y
OwnerRunetId | Идентификатор получателя товара. Обязательно. | Y


## 15.2. Купон
Активация купона


> Ответ: 

```json
{
    "Discount": "50%"
}
```

`GET http://api.runet-id.com/pay/coupon` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
CouponCode | Код купона. | Y
ExternalId | Внешний Id. | Y
ProductId | Идентификатор товара. | Y


## 15.3. Удаление
Удаление заказа


> Ответ: 

```json
{
    "Success": "true"
}
```

`GET http://api.runet-id.com/pay/delete` 
### Parameters
Название | Описание
---------------- | ----------------
OrderItemId | Идентификатор заказа.
PayerRunetId | Идентификатор плательщика.


## 15.4. Редактирование
Редактирование позиций заказа


> Ответ: 

```json
{
    "Success": "true"
}
```

`GET http://api.runet-id.com/pay/edit` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
OrderItemId | Идентификатор заказа. | Y
PayerRunetId | Идентификатор плательщика. | Y
ProductId | Идентификатор товара. | Y
OwnerRunetId | Идентификатор получателя товара. | Y


## 15.5. Купон
Покупки

`GET http://api.runet-id.com/pay/filterbook` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
Manager | Идентификатор менеджера. | Y
Params | Параметры поиска. | Y
BookTime | Время зааказа. | N


## 15.6. Товары
Список товаров

`GET http://api.runet-id.com/pay/filterlist` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
Manager | Идентификатор менеджера. | Y
Params | Параметры поиска. | Y
Filter | Фильтр. | N


## 15.7. Список оплаченных заказов
Список оплаченных за пользователя заказов. Возвращает массив с купленными пользователем заказами.


> Ответ: 

```json
{
    "Items": [
        "LNK[Оплаченный заказ](#5-13)"
    ]
}
```

`GET http://api.runet-id.com/pay/items` 
### Parameters
Название | Описание
---------------- | ----------------
OwnerRunetId | Идентификатор.


## 15.8. Заказы
Список заказов.


> Ответ: 

```json
{
    "Items": [
        "LNK[Оплаченный заказ](#5-13)"
    ],
    "Orders": [
        "LNK[Заказ](#5-12)"
    ]
}
```

`GET http://api.runet-id.com/pay/list` 
### Parameters
Название | Описание
---------------- | ----------------
PayerRunetId | Идентификатор плательщика.


## 15.9. Список товаров
Список доступных товаров. (Не работает)


> Ответ: 

```json
[
    "LNK[Товар](#5-14)"
]
```

`GET http://api.runet-id.com/pay/product` 
### Parameters
Название | Описание
---------------- | ----------------
OwnerRunetId | Идентификатор владельца.


## 15.10. Товары
Список доступных товаров


> Ответ: 

```json
[
    "LNK[Товар](#5-14)"
]
```

`GET http://api.runet-id.com/pay/products` 
### Parameters





## 15.11. Товары
Список доступных товаров, отфильтрованы по менеджеру RoomProductManager


> Ответ: 

```json
[
    {
        "Id": "идентификатор",
        "Manager": "строка, название менеджера (участие, питание и другие)",
        "Title": "название товара",
        "Price": "текущая цена",
        "Attributes": "массив ключ-значение с атрибутами товара"
    }
]
```

`GET http://api.runet-id.com/pay/rifrooms` 
### Parameters





# 16. Профессиональные интересы



## 16.1. Добавление
Добавляет участнику мероприятия 'проф. интерес'


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/professionalinterest/add` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | Идентификатор участника. | Y
ProfessionalInterestId | Идентификатор 'проф. интереса'. | Y


## 16.2. Удаление
Удаляет у частника мероприятия 'проф. интерес'


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/professionalinterest/dell` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | Идентификатор участника. | Y
ProfessionalInterestId | Идентификатор 'проф. интереса'. | Y


## 16.3. Список
Список доступных проф. интересов


> Ответ: 

```json
[
    {
        "Id": 1,
        "Title": "Аналитика"
    }
]
```

`GET http://api.runet-id.com/professionalinterest/list` 


# 17. РАЭК

РАЭК.

## 17.1. Список комиссий РАЭК
Список комиссий РАЭК.'


> Ответ: 

```json
{
    "Commissions": []
}
```

`GET http://api.runet-id.com/raec/commissionlist` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
CommissionIdList | Идентификаторы комиссий РАЭК. | N
Purpose Id | Идентификатор цели посещения мероприятия. | Y


## 17.2. Список участников комиссии РАЭК
Список участников комиссии РАЭК.'

`GET http://api.runet-id.com/raec/commissionusers` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
CommissionId | Идентификатор комиссий РАЭК. | N


# 18. Секции мероприятий

Раздел описывает методы для работы с секциями мероприятий.

## 18.1. Добавление в избранное
Добавление секции в избранное


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/section/addFavorite?RunetId=656438&SectionId=4107'
```


> Ответ: 

```json
{
    "Success": "true"
}
```

`GET http://api.runet-id.com/event/section/addFavorite` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId участника. | Y
SectionId | Идентификатор секции. | Y


## 18.2. Удаление из избранного
Удаление секции из избранного.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/section/deleteFavorite?RunetId=656438&SectionId=4107'
```


> Ответ: 

```json
{
    "Success": "true"
}
```

`GET http://api.runet-id.com/event/section/deleteFavorite` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя. | Y
SectionId | Идентификатор секции. | Y


## 18.3. Список избранных
Список избранных секций.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/section/favorites?RunetId=656438'
```


> Ответ: 

```json
[
    "LNK[Секция мероприятия](#5-15)"
]
```

`GET http://api.runet-id.com/event/section/favorites` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | Идентификатор. | Y
FromUpdateTime | (Y-m-d H:i:s) - время последнего обновления избранных секций пользователя, начиная с которого формировать список. | N
WithDeleted | Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные из избранного секции, иначе только не удаленные. | N


## 18.4. Информация о секции
Информация о конкретной секции.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/section/info?SectionId=4107'
```


> Ответ: 

```json
"LNK[Секция мероприятия](#5-15)"
```

`GET http://api.runet-id.com/event/section/info` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
SectionId | Идентификатор секции. | Y


## 18.5. Секции
Список секций.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
     'http://api.runet-id.com/event/section/list
```


> Ответ: 

```json
[
    "LNK[Секция мероприятия](#5-15)"
]
```

`GET http://api.runet-id.com/event/section/list` 
### Parameters
Название | Описание
---------------- | ----------------
FromUpdateTime | (Y-m-d H:i:s) - время последнего обновления секций, начиная с которого формировать список.
WithDeleted | Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные секции, иначе только не удаленные.


## 18.6. Доклады
Список докладов.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/section/reports?SectionId=4109'
```


> Ответ: 

```json
[
    "LNK[Доклад](#5-16)"
]
```

`GET http://api.runet-id.com/event/section/reports` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
SectionId | Идентификатор секции. | Y
FromUpdateTime | Время последнего обновления доклада, начиная с которого формировать список. | N
WithDeleted | Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные доклады, иначе только не удаленные. | N


## 18.7. Секции с залами
Список секций с залами и атрибутами.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/section/updated?SectionId=4109'
```


> Ответ: 

```json
[
    "LNK[Доклад](#5-16)"
]
```

`GET http://api.runet-id.com/event/section/updated` 


## 18.8. Секции пользователя.
Список секций в которых учавствует пользователь. Секции возвращаются с залами и атрибутами.


```shell
curl -X GET -H 'ApiKey: XXX' -H 'Hash: XXX'
    'http://api.runet-id.com/event/section/user?RunetId=656438'
```


> Ответ: 

```json
[
    "LNK[Секция мероприятия](#5-15)"
]
```

`GET http://api.runet-id.com/event/section/user` 
### Parameters
Название | Описание | Обязательно
---------------- | ---------------- | ----------------------
RunetId | RunetId пользователя. | Y


# 19. Пользователи

Загрузка данных пользователя. Работа с пользователями.

## 19.1. Отметка о записи бейджа
Привязывает бейдж к посетителю мероприятия.


> Ответ: 

```json
{
    "Success": true
}
```

`POST http://api.runet-id.com/user/badge` 
### Parameters
Название | Тип | Описание
---------------- | ------ | ----------------
RunetId | Число | runetid пользователя. Обязателен.
BadgeId | Число | уникальный идентификатор RFID-бейджа. Обязателен.


## 19.2. Создание
Создает нового пользователя.

`POST http://api.runet-id.com/user/create` 
### Parameters
Название | Тип | Описание
---------------- | ------ | ----------------
Email | Строка | Email. Обязательно.
LastName | Строка | Фамилия. Обязательно.
FirstName | Строка | Имя. Обязательно.
FatherName | Строка | Отчество.
Phone | Строка | Телефон.
Company | Строка | Компания.
Position | Строка | Должность.
ExternalId | Строка | Внешний идентификатор пользователя для привязки его профиля к сторонним сервисам.
Attributes | Массив | Расширенные атрибуты пользователя.


## 19.3. Создание
Редактирует пользователя.

`POST http://api.runet-id.com/user/edit` 
### Parameters
Название | Тип | Описание
---------------- | ------ | ----------------
Email | Строка | Email.
LastName | Строка | Фамилия.
FirstName | Строка | Имя.
FatherName | Строка | Отчество.
Attributes | Массив | Расширенные атрибуты пользователя.
ExternalId | Строка | Внешний идентификатор пользователя для привязки его профиля к сторонним сервисам.


## 19.4. Детальная информация
Возвращает данные пользователя, включая информацию о статусе участия в мероприятии.


```php
<?php $user = \RunetID\Api\User::model($api)->getByRunetId(RunetId); 
```


> Ответ: 

```json
{
    "RunetId": "идентификатор",
    "LastName": "фамилия",
    "FirstName": "имя",
    "FatherName": "отчество",
    "CreationTime": "дата регистрации пользователя",
    "Photo": "объект Photo({Small, Medium, Large}) - ссылки на 3 размера фотографии пользователя",
    "Email": "email пользователя",
    "Gender": "пол посетителя. Возможные значения: null, male, female",
    "Phones": "массив с телефонами пользователя, если заданы",
    "Work": "объект с данными о месте работы пользователя",
    "Status": {
        "RoleId": "идентификатор статуса на мероприятии",
        "RoleTitle": "название статуса",
        "UpdateTime": "время последнего обновления"
    }
}
```

`GET http://api.runet-id.com/user/get` 
### Parameters
Название | Тип | Описание
---------------- | ------ | ----------------
RunetId | Число | runetid пользователя. Обязателен, если не указан ExternalId.
ExternalId | Строка | внешний идентификатор пользователя для привязки его профиля к сторонним сервисам. Не обязателен.


## 19.5. Авторизация
Авторизация, проверка связки Email и Password.


> Ответ: 

```json
{
    "RunetId": "идентификатор",
    "LastName": "фамилия",
    "FirstName": "имя",
    "FatherName": "отчество",
    "CreationTime": "дата регистрации пользователя",
    "Photo": "объект Photo({Small, Medium, Large}) - ссылки на 3 размера фотографии пользователя",
    "Email": "email пользователя",
    "Gender": "пол посетителя. Возможные значения: null, male, female",
    "Phones": "массив с телефонами пользователя, если заданы",
    "Work": "объект с данными о месте работы пользователя",
    "Status": "объект с данными о статусе пользователя на мероприятии"
}
```

`GET http://api.runet-id.com/user/login` 
### Parameters
Название | Тип | Описание
---------------- | ------ | ----------------
Email | строка | Email. Обязательно.
Password | строка | Пароль. Обязательно.
DeviceType | строка | Тип регистрируемого устройства пользователя. Обязателен, если указан параметр DeviceToken. Возможные значения: iOS, Android.
DeviceToken | строка | Уникальный идентификатор устройства для получения push-уведомлений.


## 19.6. Поиск
Поиск пользователей по базе RUNET-ID.


> Ответ: 

```json
{
    "Users": "массив пользователей",
    "NextPageToken": "указатель на следующую страницу"
}
```

`GET http://api.runet-id.com/user/search` 
### Parameters
Название | Тип | Описание
---------------- | ------ | ----------------
Query | Строка | может принимать значения Email, RunetId, список RunetId через запятую, Фамилия, Фамилия Имя, Имя Фамилия




# 20. Ошибки 

<aside class='notice'>
Описание ошибок
</aside>

Код ошибки | Описание
---------- | --------
400 | Bad Request – Your request sucks.
401 | Unauthorized – Your API key is wrong.
403 | Forbidden.
404 | Not Found.
405 | Method Not Allowed.
406 | Not Acceptable.
410 | Gone.
418 | I’m a teapot.
429 | Too Many Requests.
500 | Internal Server Error.
503 | Service Unavailable.


<script>$(document).ready(function(){$("pre").each(function(a,b){var c=$(b).html();c=c.replace(/LNK\[([^\]\n]+)\]\(([^\)\n]+)\)/g,'<a href="$2">$1</a>'),$(b).html(c)})});</script>