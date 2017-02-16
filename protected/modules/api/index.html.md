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
&nbsp;&nbsp;&nbsp;&nbsp;- скачать и импортировать <a target='blank' href='runet-id.collection.json'>коллекцию</a> запросов.<br />
&nbsp;&nbsp;&nbsp;&nbsp;- загрузить и импортировать <a target='blank' href='runet-id.environment.json'>окружение</a><br />
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
<strong>Обязательные для всех методов параметры:</strong><br />
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
        "LNK[Пользователь](#5-12)"
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
    "Creator": "LNK[Пользователь](#5-12)",
    "Users": [
        {
            "Status": 1,
            "Response": "",
            "User": "LNK[Пользователь](#5-12)"
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
Зал.


> Объект: 

```json
{
    "Id": "идентификатор",
    "Title": "название зала",
    "UpdateTime": "время последнего обновления зала (Y-m-d H:i:s)",
    "Order": "порядок вывода залов",
    "Deleted": "true - если зал удален, false - иначе."
}
```

Параметр | Описание
-------- | --------
Id | идентификатор
Title | название зала
UpdateTime | время последнего обновления зала
Order | порядок вывода залов
Deleted | true - если зал удален, false - иначе

## 5.9. Мероприятие
Информация о мероприятии.


> Объект: 

```json
{
    "EventId": 245,
    "IdName": "rif12",
    "Name": "РИФ+КИБ 2012",
    "Title": "РИФ+КИБ 2012",
    "Info": "Крупнейшее весеннее мероприятие интернет-отрасли пройдет с 18 по 20 апреля 2012 года.",
    "Url": "http:\/\/2012.russianinternetforum.ru",
    "UrlRegistration": "",
    "UrlProgram": "",
    "StartYear": 2012,
    "StartMonth": 4,
    "StartDay": 18,
    "EndYear": 2012,
    "EndMonth": 4,
    "EndDay": 20,
    "Image": {
        "Mini": "http:\/\/runet-id.dev\/files\/event\/rif12\/50.png",
        "MiniSize": {
            "Width": 49,
            "Height": 21
        },
        "Normal": "http:\/\/runet-id.dev\/files\/event\/rif12\/120.png",
        "NormalSize": {
            "Width": 120,
            "Height": 51
        }
    },
    "Menu": [
        {
            "Type": "program",
            "Title": "Программа"
        }
    ],
    "Statistics": {
        "Participants": {
            "ByRole": {
                "1": 3796,
                "2": 209,
                "3": 500,
                "5": 424,
                "6": 26,
                "14": 8,
                "22": 31,
                "24": 5306,
                "25": 32,
                "26": 4,
                "29": 63
            },
            "TotalCount": 10399
        }
    },
    "FullInfo": "<p>Главное весеннее мероприятие ИТ-отрасли традиционно проходит в выездном формате."
}
```

Параметр | Описание
-------- | --------

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

## 5.11. Заказ
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

## 5.12. Пользователь
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
    "Status": "LNK[Статус пользователя](#5-13)",
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

## 5.13. Статус пользователя
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

## 6.1. Детально
Возвращает подробную информацию о компании. Так же в ответе будет список сотрудников компании (Employments).


```php

```


```shell
$ curl -X GET http://api.runet-id.com/company/get
```


> Ответ: 

```json
"LNK[Компания](#5-1)"
```

`GET http://api.runet-id.com/company/get` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
CompanyId | Айди компании. | Y


## 6.2. Список
Список компаний. В списке не присутствуют сотрудники компаний.


```shell
$ curl -X GET http://api.runet-id.com/company/list
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
-------- | -------- | -----------
Cluster | (enum[РАЭК]) – кластер, компании которого необходимо получить. В данный момент может принимать единственное значение: РАЭК. | Y
Query | Поисковая строка. | N
PageToken | Указатель на следующую страницу, берется из результата последнего запроса, значения NextPageToken. | N
MaxResults | MaxResults (число) - максимальное количество компаний в ответе, от 0 до 200. Если нужно загрузить более 200 участников, необходимо использовать постраничную загрузку. | N


# 7. Компетенции

Описаие методов для работы с компетенциями.

## 7.1. Результаты теста
Результаты теста с заданным TestId для пользователя с заданным RunetId.


```shell
$ curl -X GET http://api.runet-id.com/competence/result
```


> Ответ: 

```json
"LNK[Результаты теста](#5-5)"
```

`GET http://api.runet-id.com/competence/result` 
### Parameters
Название | Обязательно
-------- | -----------
RunetId | Y
TestId | Y


## 7.2. Тесты
Доступные для мероприятия тесты.


```shell
$ curl -X GET http://api.runet-id.com/competence/tests
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
$ curl -X GET http://api.runet-id.com/connect/accept
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
-------- | -------- | -----------
MeetingId | Айди встречи. | Y
RunetId | RunetId пользователя. | Y


## 8.2. Отмена встречи
Отменяет встречу. Статус встречи меняется на 'отменена'


```shell
$ curl -X GET http://api.runet-id.com/connect/cancel
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
-------- | -------- | -----------
MeetingId | Айди встречи | Y
RunetId | Runetid создателя встречи | Y
Response | Причина отмены | Y


## 8.3. Создание встречи
Создает новую встречу


```shell
$ curl -X POST http://api.runet-id.com/connect/create
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
-------- | -------- | -----------
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
$ curl -X GET http://api.runet-id.com/connect/decline
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
-------- | -------- | -----------
RunetId | Пользователь | Y
MeetingId | Id встречи | Y


## 8.5. Отправляет приглашение
Отправляет приглашение пользователю на встречу.


```shell
$ curl -X POST http://api.runet-id.com/connect/invite
```


> Ответ: 

```json
{
    "Success": true,
    "Meeting": "Объект MEETING",
    "Errors": []
}
```

`POST http://api.runet-id.com/connect/invite` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
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
$ curl -X GET http://api.runet-id.com/connect/list
```


> Ответ: 

```json
{
    "Success": true,
    "Meetings": [
        "Объект MEETING"
    ]
}
```

`GET http://api.runet-id.com/connect/list` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RunetId |  | N
CreatorId |  | N
UserId |  | N
Type | Тип встречи. 1-закрытая,2-открытая. | N
Status | Сатус встречи. 1-открыта. 2-отменена. | N


## 8.7. Места
Места для встреч.


```shell
$ curl -X GET http://api.runet-id.com/connect/places
```


> Ответ: 

```json
{
    "Success": true,
    "Places": [
        "Объект PLACE"
    ]
}
```

`GET http://api.runet-id.com/connect/places` 


## 8.8. Рекомендации
Рекомендации.


```shell
$ curl -X GET http://api.runet-id.com/connect/recommendations
```


> Ответ: 

```json
{
    "Success": true,
    "Users": [
        "Объект USER"
    ]
}
```

`GET http://api.runet-id.com/connect/recommendations` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RunetId | RunetId пользователя для которого вернутся рекоммендации. | Y


## 8.9. Поиск
Поиск по участникам мероприятия.


```shell
$ curl -X GET http://api.runet-id.com/connect/search
```


> Ответ: 

```json
{
    "Success": true,
    "Users": [
        "Объект USER"
    ]
}
```

`GET http://api.runet-id.com/connect/search` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RoleId | Роль участника. | N
Attributes | Атрибуты. | N
q | Поисковый запрос | N


## 8.10. Присоединиться к встрече
Присоединиться к встрече.


```shell
$ curl -X GET http://api.runet-id.com/connect/signup
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
-------- | -------- | -----------
RunetId | Runetid пользователя. | Y
MeetingId | Id встречи. | Y


# 9. Мероприятия

Методы для работы с мероприятиями.

## 9.1. Смена роли
Меняет роль заданному пользователю.


```shell
$ curl -X GET http://api.runet-id.com/event/changerole
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
-------- | -------- | -----------
RoleId | Id новой роли. | Y
RunetId | RunetId пользователя. | Y


## 9.2. Компании
Выбираются все компании, сотрудники которых учавствуют в мероприятии.


```shell
$ curl -X GET http://api.runet-id.com/event/сompanies
```


> Ответ: 

```json
{
    "10": "Объект COMPANY"
}
```

`GET http://api.runet-id.com/event/сompanies` 


## 9.3. Залы
Список залов.


```shell
$ curl -X GET http://api.runet-id.com/event/halls
```


> Ответ: 

```json
[
    "Объект HALL"
]
```

`GET http://api.runet-id.com/event/halls` 
### Parameters
Название | Описание
-------- | --------
FromUpdateTime | (Y-m-d H:i:s) - время последнего обновления залов, начиная с которого формировать список.
WithDeleted | Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные залы, иначе только не удаленные.


## 9.4. Информация о мероприятии
Информация о мероприятии.


```shell
$ curl -X GET http://api.runet-id.com/event/info
```


> Ответ: 

```json
[
    "Объект EVENT"
]
```

`GET http://api.runet-id.com/event/info` 
### Parameters
Название | Описание
-------- | --------
FromUpdateTime | (Y-m-d H:i:s) - время последнего обновления залов, начиная с которого формировать список.
WithDeleted | Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные залы, иначе только не удаленные.


## 9.5. Список мероприятий
Список мероприятий за указанный год. Если год не указан - выбираются мероприятия за текущий.


```shell
$ curl -X GET http://api.runet-id.com/event/list
```


> Ответ: 

```json
[
    "Объект EVENT"
]
```

`GET http://api.runet-id.com/event/list` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
Year | Год. | N


## 9.6. Отменя участия.
Отмена участия посетителя. Только для создателей мероприятия.


```shell
$ curl -X GET http://api.runet-id.com/event/participationcancel
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
-------- | -------- | -----------
RunetId | RunetId пользователя | Y


## 9.7. Цели мероприятия
Цели мероприятия.


```shell
$ curl -X GET http://api.runet-id.com/event/purposes
```


> Ответ: 

```json
{[]}
```

`GET http://api.runet-id.com/event/purposes` 


## 9.8. Изменение статуса
Изменение статуса пользователя (или добавление).


```shell
$ curl -X GET http://api.runet-id.com/event/register
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
-------- | --------
RunetId | Идентификатор пользователя. Обязательно.
RoleId | Идентификатор статуса, который пользователь должен получить на мероприятии. Обязательно.


## 9.9. Статусы
Список статусов.


```shell
$ curl -X GET http://api.runet-id.com/event/roles
```


> Ответ: 

```json
[
    "Объект EVENTROLE"
]
```

`GET http://api.runet-id.com/event/roles` 


## 9.10. RunetId участников мероприятия
Список RunetId,Ролей участников мерроприятия.


```shell
$ curl -X GET http://api.runet-id.com/event/runetids
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
$ curl -X GET http://api.runet-id.com/event/statistics
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
Список участников


```shell
$ curl -X GET http://api.runet-id.com/event/users
```


> Ответ: 

```json
{
    "Users": [
        "LNK[Пользователь](#5-12)"
    ],
    "NextPageToken": "указатель на следующую страницу"
}
```

`GET http://api.runet-id.com/event/users` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RoleId | Массив идентификаторов ролей | N


## 9.13. Фотографии участников
Возвращает Фотографии участников одним архивом.


```shell
$ curl -X GET http://api.runet-id.com/event/usersphotos
```


> Ответ: 

```json
{
    "Users": [
        "Объект USER"
    ],
    "NextPageToken": "указатель на следующую страницу"
}
```

`GET http://api.runet-id.com/event/usersphotos` 


## 9.14. Добавление в избранное.



```shell
$ curl -X GET http://api.runet-id.com/event/section/addFavorite
```


> Ответ: 

```json
{
    "Success": "true"
}
```

`GET http://api.runet-id.com/event/section/addFavorite` 
### Parameters
Название | Описание
-------- | --------
RunetId | Идентификатор.
SectionId | Идентификатор.


## 9.15. Удаление из избранного.



```shell
$ curl -X GET http://api.runet-id.com/event/section/deleteFavorite
```


> Ответ: 

```json
{
    "Success": "true"
}
```

`GET http://api.runet-id.com/event/section/deleteFavorite` 
### Parameters
Название | Описание
-------- | --------
RunetId | Идентификатор.
SectionId | Идентификатор.


## 9.16. Список избранных
Список избранных секций.


```shell
$ curl -X GET http://api.runet-id.com/event/section/favorites
```


> Ответ: 

```json
{
    "SectionId": "идентификатор секции",
    "UpdateTime": "время добавления или удаления в избранное",
    "Deleted": "true - если секция удалена из избранных секций пользователя, false - иначе."
}
```

`GET http://api.runet-id.com/event/section/favorites` 
### Parameters
Название | Описание
-------- | --------
RunetId | Идентификатор. Обязательно.
FromUpdateTime | (Y-m-d H:i:s) - время последнего обновления избранных секций пользователя, начиная с которого формировать список. Обязательно.
WithDeleted | Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные из избранного секции, иначе только не удаленные. Обязательно.


## 9.17. Секции
Список секций.


```shell
$ curl -X GET http://api.runet-id.com/event/section/list
```


> Ответ: 

```json
[
    {
        "Id": "идентификатор",
        "Title": "название",
        "Info": "краткое описание",
        "Start": "время начала",
        "End": "время окончания",
        "TypeCode": "код типа секции",
        "Places": [
            "массив с названиями залов, в которых проходит секция (deprecated)"
        ],
        "Halls": [
            "массив объектов Hall"
        ],
        "Attributes": [
            "дополнительные аттрибуты (произвольный массив ключ      => значение, набор ключей и значений зависит от мероприятия)"
        ],
        "UpdateTime": "дата\/время последнего обновления",
        "Deleted": "true - если секция удалена, false - иначе"
    }
]
```

`GET http://api.runet-id.com/event/section/list` 
### Parameters
Название | Тип | Описание
-------- | --- | --------
FromUpdateTime | ssss | (Y-m-d H:i:s) - время последнего обновления секций, начиная с которого формировать список.
WithDeleted |  | Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные секции, иначе только не удаленные.


## 9.18. Доклады
Список докладов.<br />
&nbsp;&nbsp;&nbsp;&nbsp;User, Company, CustomText - всегда будет заполнено только одно из этих полей.<br />
&nbsp;&nbsp;&nbsp;&nbsp;Title, Thesis, FullInfo, Url - могут отсутствовать, если нет информации о докладе, либо роль не предполагает выступление с докладом (например, ведущий)


```shell
$ curl -X GET http://api.runet-id.com/event/section/reports
```


> Ответ: 

```json
[
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
]
```

`GET http://api.runet-id.com/event/section/reports` 
### Parameters
Название | Описание
-------- | --------
SectionId | Идентификатор секции. Обязательно
FromUpdateTime  | Время последнего обновления доклада, начиная с которого формировать список.
WithDeleted | Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные доклады, иначе только не удаленные.


# 10. Приглашения на мероприятия

Приглашения на мероприятия.

## 10.1. Запросы на участие
Вернет запросы на участие в мероприятии пользователя с заданным RunetId


```shell
$ curl -X GET http://api.runet-id.com/invite/get
```


> Ответ: 

```json
{
    "Sender": "Объект USER",
    "Owner": "Объект USER",
    "CreationTime": "2017-02-14 14:12:27",
    "Event": "Объект EVENT",
    "Approved": 0
}
```

`GET http://api.runet-id.com/invite/get` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RunetId | RunetId пользователя | Y


## 10.2. Создание приглашения
Создает приглашение на участие в мероприятии пользователя RunetId


```shell
$ curl -X GET http://api.runet-id.com/invite/request
```


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/invite/request` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RunetId | RunetId пользователя | Y


# 11. ИРИ



## 11.1. Роли ИРИ
Возвращает список ролей для ИРИ


```shell
$ curl -X GET http://api.runet-id.com/iri/roles
```

`GET http://api.runet-id.com/iri/roles` 


## 11.2. Добавить пользователя
Добавляет пользователя ИРИ


```shell
$ curl -X GET http://api.runet-id.com/iri/useradd
```


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/iri/useradd` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RunetId | RunetId пользователя | Y
RoleId | Роль пользователя ИРИ. 1- Ведущий эксперт. 2- Эксперт ЭС ИРИ. 3 - Член программного коммитета. | Y
Type | Тип пользователя(expert) | Y
ProfessionalInterestId | Профессиональные интересы. | N


## 11.3. Удалить пользователя
Удаляет пользователя ИРИ. Поиск пользователя на выход из ИРИ осуществляется по всем переданным параметрам.


```shell
$ curl -X GET http://api.runet-id.com/iri/userdelete
```


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/iri/userdelete` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RunetId | RunetId пользователя | Y
RoleId | Роль пользователя ИРИ. 1- Ведущий эксперт. 2- Эксперт ЭС ИРИ. 3 - Член программного коммитета. | Y
Type | Тип пользователя(expert) | Y
ProfessionalInterestId | Профессиональные интересы. | N


## 11.4. Список пользователей
Отдает список пользователей ИРИ (Ошибка)


```shell
$ curl -X GET http://api.runet-id.com/iri/userlist
```

`GET http://api.runet-id.com/iri/userlist` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
Type | Тип пользователя(expert) | Y


# 12. Microsoft

Спецпроект для Microsoft

## 12.1. Проверка хеша
Проверяет переданный хеш


```shell
$ curl -X GET http://api.runet-id.com/ms/checkfastauth
```


> Ответ: 

```json
{
    "Result": true
}
```

`GET http://api.runet-id.com/ms/checkfastauth` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RunetId | RunetId пользователя | Y
AuthHash | Проверяемый хеш | Y


## 12.2. Создание пользователя
Создает нового пользователя


```shell
$ curl -X GET http://api.runet-id.com/ms/createuser
```


> Ответ: 

```json
{
    "Result": true
}
```

`GET http://api.runet-id.com/ms/createuser` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RunetId | RunetId пользователя | Y
AuthHash | Проверяемый хеш | Y


# 13. Платежный кабинет

Методы для работы с платежным кабинетом.

## 13.1. Добавление
Добавление заказа


```shell
$ curl -X GET http://api.runet-id.com/pay/add
```


> Ответ: 

```json
"Объект ORDER"
```

`GET http://api.runet-id.com/pay/add` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
ProductId | Идентификатор товара. | Y
PayerRunetId | Идентификатор плательщика. Обязательно. | Y
OwnerRunetId | Идентификатор получателя товара. Обязательно. | Y


## 13.2. Купон
Активация купона


```shell
$ curl -X GET http://api.runet-id.com/pay/coupon
```


> Ответ: 

```json
{
    "Discount": "50%"
}
```

`GET http://api.runet-id.com/pay/coupon` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
CouponCode | Код купона. | Y
ExternalId | Внешний Id. | Y
ProductId | Идентификатор товара. | Y


## 13.3. Удаление
Удаление заказа


```shell
$ curl -X GET http://api.runet-id.com/pay/delete
```


> Ответ: 

```json
{
    "Success": "true"
}
```

`GET http://api.runet-id.com/pay/delete` 
### Parameters
Название | Описание
-------- | --------
OrderItemId | Идентификатор заказа.
PayerRunetId | Идентификатор плательщика.


## 13.4. Редактирование
Редактирование позиций заказа


```shell
$ curl -X GET http://api.runet-id.com/pay/edit
```


> Ответ: 

```json
{
    "Success": "true"
}
```

`GET http://api.runet-id.com/pay/edit` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
OrderItemId | Идентификатор заказа. | Y
PayerRunetId | Идентификатор плательщика. | Y
ProductId | Идентификатор товара. | Y
OwnerRunetId | Идентификатор получателя товара. | Y


## 13.5. Купон
Покупки


```shell
$ curl -X GET http://api.runet-id.com/pay/filterbook
```

`GET http://api.runet-id.com/pay/filterbook` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
Manager | Идентификатор менеджера. | Y
Params | Параметры поиска. | Y
BookTime | Время зааказа. | N


## 13.6. Товары
Список товаров


```shell
$ curl -X GET http://api.runet-id.com/pay/filterlist
```

`GET http://api.runet-id.com/pay/filterlist` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
Manager | Идентификатор менеджера. | Y
Params | Параметры поиска. | Y
Filter | Фильтр. | N


## 13.7. Список оплаченных заказов
Список оплаченных за пользователя заказов. Возвращает массив с купленными пользователем заказами.


```shell
$ curl -X GET http://api.runet-id.com/pay/items
```


> Ответ: 

```json
{
    "Items": [
        "Объект ITEM"
    ]
}
```

`GET http://api.runet-id.com/pay/items` 
### Parameters
Название | Описание
-------- | --------
OwnerRunetId | Идентификатор.


## 13.8. Заказы
Список заказов.


```shell
$ curl -X GET http://api.runet-id.com/pay/list
```


> Ответ: 

```json
{
    "Items": [
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
    ],
    "Orders": [
        {
            "OrderId": "идентификатор счета",
            "Number": "номер счета ()",
            "Paid": "статус оплачен\/не оплачен",
            "Url": "ссылка на счет",
            "Items": "массив объектов OrderItem",
            "CreationTime": "дата создания счета"
        }
    ]
}
```

`GET http://api.runet-id.com/pay/list` 
### Parameters
Название | Описание
-------- | --------
PayerRunetId | Идентификатор плательщика.


## 13.9. Список товаров
Список доступных товаров.


```shell
$ curl -X GET http://api.runet-id.com/pay/product
```


> Ответ: 

```json
{
    "Items": [
        "Объект ITEM"
    ]
}
```

`GET http://api.runet-id.com/pay/product` 
### Parameters
Название | Описание
-------- | --------
OwnerRunetId | Идентификатор владельца.


## 13.10. Товары
Список доступных товаров


```shell
$ curl -X GET http://api.runet-id.com/pay/products
```


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

`GET http://api.runet-id.com/pay/products` 
### Parameters





## 13.11. Товары
Список доступных товаров, отфильтрованы по менеджеру RoomProductManager


```shell
$ curl -X GET http://api.runet-id.com/pay/rifrooms
```


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





# 14. Профессиональные интересы



## 14.1. Добавление
Добавляет участнику мероприятия 'проф. интерес'


```shell
$ curl -X GET http://api.runet-id.com/professionalinterest/add
```


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/professionalinterest/add` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RunetId | Идентификатор участника. | Y
ProfessionalInterestId | Идентификатор 'проф. интереса'. | Y


## 14.2. Удаление
Удаляет у частника мероприятия 'проф. интерес'


```shell
$ curl -X GET http://api.runet-id.com/professionalinterest/dell
```


> Ответ: 

```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/professionalinterest/dell` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
RunetId | Идентификатор участника. | Y
ProfessionalInterestId | Идентификатор 'проф. интереса'. | Y


## 14.3. Список
Список доступных проф. интересов


```shell
$ curl -X GET http://api.runet-id.com/professionalinterest/list
```


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


# 15. Пользователи

Загрузка данных пользователя. Работа с пользователями.

## 15.1. Создание
Создает нового пользователя.


```shell
$ curl -X POST http://api.runet-id.com/user/create
```

`POST http://api.runet-id.com/user/create` 
### Parameters
Название | Тип | Описание
-------- | --- | --------
Email | Строка | Email. Обязательно.
LastName | Строка | Фамилия. Обязательно.
FirstName | Строка | Имя. Обязательно.
FatherName | Строка | Отчество.
Phone | Строка | Телефон.
Company | Строка | Компания.
Position | Строка | Должность.


## 15.2. Детальная информация
Возвращает данные пользователя, включая информацию о статусе участия в мероприятии.


```php
<?php $user = \RunetID\Api\User::model($api)->getByRunetId(RunetId); 
```


```shell
$ curl -X GET http://api.runet-id.com/user/get
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
Название | Описание
-------- | --------
RunetId | runetid пользователя. Обязательно.


## 15.3. Авторизация
Авторизация, проверка связки Email и Password.


```shell
$ curl -X GET http://api.runet-id.com/user/login
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
    "Status": "объект с данными о статусе пользователя на мероприятии"
}
```

`GET http://api.runet-id.com/user/login` 
### Parameters
Название | Тип | Описание
-------- | --- | --------
Email | строка | Email. Обязательно.
Password | строка | Пароль. Обязательно.
DeviceType | строка | Тип регистрируемого устройства пользователя. Обязателен, если указан параметр DeviceToken. Возможные значения: iOS, Android.
DeviceToken | строка | Уникальный идентификатор устройства для получения push-уведомлений.


## 15.4. Поиск
Поиск пользователей по базе RUNET-ID.


```shell
$ curl -X GET http://api.runet-id.com/user/search
```


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
-------- | --- | --------
Query | Строка | может принимать значения Email, RunetId, список RunetId через запятую, Фамилия, Фамилия Имя, Имя Фамилия




# 16. Ошибки 

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