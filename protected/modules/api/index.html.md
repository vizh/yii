---
language_tabs:
  - json
  - javascript
  - php
  - shell
  - ruby
  - python

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

## 5.1. Место
Место встречи.

Параметр | Описание
-------- | --------
Id | Айди места встречи
Name | Название
Reservation | Возможность бронирования


```json
{
    "Id": 4,
    "Name": "Meeting point 1",
    "Reservation": "true",
    "ReservationTime": 20
}
```

## 5.2. Встреча
Встреча.

Параметр | Описание
-------- | --------
Id | Айди встречи
Place | Объект места встречи
Creator | Создатель встречи
Users | Массив объектов пользователей, приглашенных на встречу
UserCount | Колличество пользователей приглашенных на встречу
Start | Время начала встречи


```json
{
    "Id": 2817,
    "Place": "Объект PLACE",
    "Creator": "Объект USER",
    "Users": [
        {
            "Status": 1,
            "Response": "",
            "User": "Объект USER"
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

## 5.3. Компания
Компания.

Параметр | Описание
-------- | --------
Id | Айди компании
Name | Название компании
FullName | Расширенное название компании
Info | Информация о компании
Logo | Лого компании
Url | Сайт компании


```json
{
    "Id": 10,
    "Name": "Майкрософт",
    "FullName": "Microsoft,  Россия",
    "Info": "",
    "Logo": {
        "Small": "http:\/\/runet-id.dev\/upload\/images\/company\/logo\/f\/a\/l\/l\/b\/fallback.jpg",
        "Medium": "http:\/\/runet-id.dev\/upload\/images\/company\/logo\/f\/a\/l\/l\/b\/fallback.jpg",
        "Large": "http:\/\/runet-id.dev\/upload\/images\/company\/logo\/f\/a\/l\/l\/b\/fallback.jpg"
    },
    "Url": "",
    "Phone": "",
    "Email": "olgad@microsoft.com",
    "Address": "г. Москва",
    "Cluster": null,
    "ClusterGroups": [],
    "OGRN": null,
    "CountParticipants": 22
}
```

## 5.4. Зал
Зал.

Параметр | Описание
-------- | --------
Id | идентификатор
Title | название зала
UpdateTime | время последнего обновления зала
Order | порядок вывода залов
Deleted | true - если зал удален, false - иначе


```json
{
    "Id": "идентификатор",
    "Title": "название зала",
    "UpdateTime": "время последнего обновления зала (Y-m-d H:i:s)",
    "Order": "порядок вывода залов",
    "Deleted": "true - если зал удален, false - иначе."
}
```

## 5.5. Мероприятие
Информация о мероприятии.

Параметр | Описание
-------- | --------


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

## 5.6. Статус на мероприятии
Статус на мероприятии.

Параметр | Описание
-------- | --------


```json
{
    "RoleId": "идентификатор статуса на мероприятии",
    "RoleTitle": "название статуса",
    "UpdateTime": "время последнего обновления"
}
```

## 5.7. Заказ
Зал.

Параметр | Описание
-------- | --------
Id | идентификатор


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

## 5.8. Пользователь
Объект пользователя.

Параметр | Описание
-------- | --------
Id | Айди пользователя
Name | Имя пользователя


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
    "Photo": {
        "Small": "http:\/\/runet-id.dev\/files\/photo\/0\/454_50.jpg?t=1475191745",
        "Medium": "http:\/\/runet-id.dev\/files\/photo\/0\/454_90.jpg?t=1475191306",
        "Large": "http:\/\/runet-id.dev\/files\/photo\/0\/454_200.jpg?t=1475191317"
    },
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
    "Status": {
        "RoleId": 1,
        "RoleName": "Участник",
        "RoleTitle": "Участник",
        "UpdateTime": "2012-04-18 12:06:49",
        "TicketUrl": "http:\/\/runet-id.dev\/ticket\/rif12\/454\/7448b8c03688bf317a7506f41\/",
        "Registered": false
    },
    "Email": "max.borzov@gmail.com",
    "Phone": "79637654577",
    "PhoneFormatted": "8 (963) 765-45-77",
    "Phones": [
        "89637654577",
        "79637654577"
    ]
}
```



# 6. Компании

Описаие методов для работы с компаниями

## 6.1. Детальная информация о компании
Возвращает детальную информацию о компании


```json
{
    "Id": 77529,
    "Name": "RUVENTS",
    "FullName": "ООО «РУВЕНТС»",
    "Info": null,
    "Logo": {
        "Small": "http:\/\/runet-id.dev\/upload\/images\/company\/logo\/b\/e\/f\/b\/9\/befb921b1aa035508c9a58b8828469c5-d864780c4b18a07512a2de7044703e9189e757d6.png",
        "Medium": "http:\/\/runet-id.dev\/upload\/images\/company\/logo\/b\/e\/f\/b\/9\/befb921b1aa035508c9a58b8828469c5-594f0c64feeb1daa88af22e7484a0bf29cf77021.png",
        "Large": "http:\/\/runet-id.dev\/upload\/images\/company\/logo\/b\/e\/f\/b\/9\/befb921b1aa035508c9a58b8828469c5-0f1ebad037e00404db8dc9d479da5dfb563fca83.png"
    },
    "Url": "http:\/\/ruvents.com",
    "Phone": "+7 (495) 6385147",
    "Email": "info@ruvents.com",
    "Address": "г. Москва, Пресненская наб., д. 12",
    "Cluster": "РАЭК",
    "ClusterGroups": [],
    "OGRN": null,
    "Employments": [
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
            "Photo": {
                "Small": "http:\/\/runet-id.dev\/files\/photo\/0\/454_50.jpg?t=1475191745",
                "Medium": "http:\/\/runet-id.dev\/files\/photo\/0\/454_90.jpg?t=1475191306",
                "Large": "http:\/\/runet-id.dev\/files\/photo\/0\/454_200.jpg?t=1475191317"
            },
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
            "Status": {
                "RoleId": 1,
                "RoleName": "Участник",
                "RoleTitle": "Участник",
                "UpdateTime": "2012-04-18 12:06:49",
                "TicketUrl": "http:\/\/runet-id.dev\/ticket\/rif12\/454\/7448b8c03688bf317a7506f41\/",
                "Registered": false
            },
            "Email": "max.borzov@gmail.com",
            "Phone": "79637654577",
            "PhoneFormatted": "8 (963) 765-45-77",
            "Phones": [
                "89637654577",
                "79637654577"
            ]
        }
    ]
}
```

`GET http://api.runet-id.com/company/get` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
CompanyId | Айди компании. | Y

```javascript

```


```php

```



## 6.2. Список
Список компаний.


```json
{
    "Companies": [
        {
            "Id": 77529,
            "Name": "RUVENTS",
            "FullName": "ООО «РУВЕНТС»",
            "Info": null,
            "Logo": {
                "Small": "http:\/\/runet-id.dev\/upload\/images\/company\/logo\/b\/e\/f\/b\/9\/befb921b1aa035508c9a58b8828469c5-d864780c4b18a07512a2de7044703e9189e757d6.png",
                "Medium": "http:\/\/runet-id.dev\/upload\/images\/company\/logo\/b\/e\/f\/b\/9\/befb921b1aa035508c9a58b8828469c5-594f0c64feeb1daa88af22e7484a0bf29cf77021.png",
                "Large": "http:\/\/runet-id.dev\/upload\/images\/company\/logo\/b\/e\/f\/b\/9\/befb921b1aa035508c9a58b8828469c5-0f1ebad037e00404db8dc9d479da5dfb563fca83.png"
            },
            "Url": "http:\/\/ruvents.com",
            "Phone": "+7 (495) 6385147",
            "Email": "info@ruvents.com",
            "Address": "г. Москва, Пресненская наб., д. 12",
            "Cluster": "РАЭК",
            "ClusterGroups": [],
            "OGRN": null
        }
    ]
}
```

`GET http://api.runet-id.com/company/list` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
Cluster | (enum[РАЭК]) – кластер, компании которого необходимо получить. В данный момент может принимать единственное значение: РАЭК. | Y
Query | Поисковая строка. | 
PageToken | Указатель на следующую страницу, берется из результата последнего запроса, значения NextPageToken. | 
MaxResults | MaxResults (число) - максимальное количество компаний в ответе, от 0 до 200. Если нужно загрузить более 200 участников, необходимо использовать постраничную загрузку. | 


# 7. Компетенции

Описаие методов для работы с компетенциями.

## 7.1. Результаты теста
Результаты теста с заданным TestId для пользователя с заданным RunetId.


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
    },
    "competence\\models\\tests\\mailru2013\\A1": {
        "Value": {
            "49": "1"
        }
    },
    "competence\\models\\tests\\mailru2013\\A4": {
        "Value": [
            "41",
            "43",
            "48"
        ]
    },
    "competence\\models\\tests\\mailru2013\\A5": {
        "Value": {
            "41": [
                "7"
            ],
            "48": [
                "7"
            ],
            "43": [
                "7"
            ]
        }
    },
    "competence\\models\\tests\\mailru2013\\A6": {
        "Value": [
            "1",
            "8"
        ]
    },
    "competence\\models\\tests\\mailru2013\\A6_1": {
        "Value": {
            "1": [
                "7"
            ],
            "8": [
                "1",
                "4",
                "7"
            ]
        }
    },
    "competence\\models\\tests\\mailru2013\\A8": {
        "Value": [
            "2",
            "8",
            "11",
            "4",
            "9"
        ]
    },
    "competence\\models\\tests\\mailru2013\\A9": {
        "Value": [
            "8",
            "9"
        ]
    },
    "competence\\models\\tests\\mailru2013\\A10": {
        "Value": {
            "4": [
                "89"
            ],
            "3": [
                "84"
            ],
            "2": [
                "85"
            ],
            "7": [
                "90"
            ],
            "5": [
                "85"
            ],
            "8": [
                "89"
            ],
            "1": [
                "84"
            ],
            "9": [
                "85"
            ],
            "6": [
                "85"
            ]
        }
    },
    "competence\\models\\tests\\mailru2013\\A10_1": {
        "Value": {
            "12": [
                "85"
            ],
            "17": [
                "90"
            ],
            "16": [
                "89"
            ],
            "14": [
                "89"
            ],
            "15": [
                "85"
            ],
            "13": [
                "85"
            ],
            "18": [
                "89"
            ],
            "11": [
                "84"
            ],
            "10": [
                "90"
            ]
        }
    },
    "competence\\models\\tests\\mailru2013\\S5": {
        "Value": "2"
    },
    "competence\\models\\tests\\mailru2013\\S6": {
        "Value": "5"
    },
    "competence\\models\\tests\\mailru2013\\S7": {
        "Value": "3"
    },
    "competence\\models\\tests\\mailru2013\\S3_1": {
        "Value": "8"
    },
    "competence\\models\\tests\\mailru2013\\C1": {
        "Value": "1983"
    },
    "competence\\models\\tests\\mailru2013\\C2": {
        "Value": "1"
    },
    "competence\\models\\tests\\mailru2013\\C3": {
        "Value": "19"
    },
    "competence\\models\\tests\\mailru2013\\C4": {
        "Value": "3"
    },
    "competence\\models\\tests\\mailru2013\\C5": {
        "Value": "5"
    },
    "competence\\models\\tests\\mailru2013\\C6": {
        "Value": [
            "7",
            "14",
            "21"
        ]
    }
}
```

`GET http://api.runet-id.com/competence/result` 
### Parameters
Название | Обязательно
-------- | -----------
RunetId | Y
TestId | Y


## 7.2. Тесты
Доступные для мероприятия тесты.


```json
[
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
]
```

`GET http://api.runet-id.com/competence/tests` 


# 8. Встречи

Методы для работы со встречами.

## 8.1. Принять приглашение
Принимает приглашение.


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
Отменяет встречу. Статус встречи меняется на 'отмененная'


```json
{
    "Success": true
}
```

`GET http://api.runet-id.com/connect/cancel` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
MeetingId | Айди встречи. | Y
RunetId | Runetid создателя встречи. | Y


## 8.3. Создание встречи
Создает новую встречу


```json
{
    "Success": true,
    "Meeting": "Объект MEETING",
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


```json
{
    "10": "Объект COMPANY"
}
```

`GET http://api.runet-id.com/event/сompanies` 


## 9.3. Залы
Список залов.


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


```json
{[]}
```

`GET http://api.runet-id.com/event/purposes` 


## 9.8. Изменение статуса
Изменение статуса пользователя (или добавление).


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


```json
[
    "Объект EVENTROLE"
]
```

`GET http://api.runet-id.com/event/roles` 


## 9.10. RunetId участников мероприятия
Список RunetId,Ролей участников мерроприятия.


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


```json
{
    "Users": [
        "Объект USER"
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

`GET http://api.runet-id.com/iri/roles` 


## 11.2. Добавить пользователя
Добавляет пользователя ИРИ


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

`GET http://api.runet-id.com/iri/userlist` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
Type | Тип пользователя(expert) | Y


# 12. Microsoft

Спецпроект для Microsoft

## 12.1. Проверка хеша
Проверяет переданный хеш


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

`GET http://api.runet-id.com/pay/filterbook` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
Manager | Идентификатор менеджера. | Y
Params | Параметры поиска. | Y
BookTime | Время зааказа. | N


## 13.6. Товары
Список товаров

`GET http://api.runet-id.com/pay/filterlist` 
### Parameters
Название | Описание | Обязательно
-------- | -------- | -----------
Manager | Идентификатор менеджера. | Y
Params | Параметры поиска. | Y
Filter | Фильтр. | N


## 13.7. Список оплаченных заказов
Список оплаченных за пользователя заказов. Возвращает массив с купленными пользователем заказами.


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

```php
<?php $user = \RunetID\Api\User::model($api)->getByRunetId(RunetId); 
```



## 15.3. Авторизация
Авторизация, проверка связки Email и Password.


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
