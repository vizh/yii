FORMAT: 1A
HOST: https://ruvents2.runet-id.loc

# RUVENTS Регистрация

Данное API предназначено для регистрации участников во время проведения мероприятия.

## Общая информация

Для того, чтобы вызвать метод API *RUVENTS Регистрация*, вам необходимо осуществить запрос по протоколу **HTTPS** на указанный URL:

```http
https://ruvents2.runet-id.com/{METHOD}?{PARAMETERS}
```

Результат возвращается в формате JSON

Для каждого мероприятия генерируется ```Hash```, с помощью которого осуществляется авторизация для доступа к API. Для авторизации в любом запросе необходимо передавать заголовок

```http
X-Ruvents-Hash: {Hash}
```

Для запросов, изменяющих данные на стороне сервиса необходимо передавать Id оператора, производящего данные изменения

```http
X-Ruvents-Operator: {Id}
```

## Обработка ошибок и кодов состояния HTTP

Для каждого запроса API *RUVENTS Регистрация* возвращает соответствующие коды состояния HTTP

Код | Сообщение | Описание
----|-----------|---------
200 | OK | Запрос выполнен успешно
400 | Bad Request | При выполнении запроса возникли ошибки. Необходимо смотреть код и сообщение ошибки в ответе сервера
500 | Internal Server Error | Что то пошло не так. Пришлите пожалуйста письмо с описанием проблемы на [dev@internetmediaholding.com](mailto:dev@internetmediaholding.com)


### Сообщения об ошибках

Сообщение об ошибке возвращается в следующем формате:

```javascript
{
    Error: { Code: 34, Message: "Текст ошибки в человекопонятном формате"}
}
```


# Group Мероприятие

Получение информации о текущем мероприятии.

## Общая информация [/event]

### GET

+ Response 200

    + Body

            {
                "Id": 946,
                "IdName": "demoevent",
                "Title": "Демо мероприятие",
                "Description": "Это мероприятие предназначено для демонстрации возможностей партнерки."
            }
    + Schema

            {
                "type": "object",
                "properties": {
                    "Id": {
                        "type": "integer",
                        "required": true
                    },
                    "IdName": {
                        "type": "string",
                        "required": true
                    },
                    "Title": {
                        "type": "string",
                        "required": true
                    },
                    "Description": {
                        "type": "string"
                    }
                }
            }

## Операторы [/event/operators]

### GET

+ Response 200

    + Body

            {
                "Operators": [
                    {
                        "Id": 323,
                        "Login": "op1",
                        "Password": "87245",
                        "Role": "Admin" 
                    },
                    {
                        "Id": 324,
                        "Login": "op2",
                        "Password": "18636",
                        "Role": "Operator"
                    }
                ]
            }
    + Schema

            {
                "type": "object",
                "properties": {
                    "Operators": {
                        "type": "array",
                        "items": {
                            "type": "object",
                            "properties": {
                                "Id": { "type": "integer" },
                                "Login": { "type": "string" },
                                "Password": { "type": "string" },
                                "Role": { "enum": [ "Admin", "Operator" ] }
                            },
                            "required": ["Id", "Login", "Password", "Role"]
                        }
                    }
                }
            }

## Статусы [/event/statuses]

### GET

+ Response 200

    + Body

            {
                "Statuses": [
                    {
                        "Id": 6,
                        "Title": "Организатор",
                        "Color": "#ff0000",
                        "Priority": 90 
                    },
                    {
                        "Id": 1,
                        "Title": "Участник",
                        "Color": "#000000",
                        "Priority": 30
                    }
                ]
            }
    + Schema

            {
                "type": "object",
                "properties": {
                    "Statuses": {
                        "type": "array",
                        "items": {
                            "type": "object",
                            "properties": {
                                "Id": { "type": "integer" },
                                "Title": { "type": "string" },
                                "Color": { "type": ["string", "null"] },
                                "Priority": { "type": "integer" }
                            },
                            "required": ["Id", "Title", "Color", "Priority"]
                        }
                    }
                }
            }


## Части мероприятия [/event/parts]

Возвращается пустой массив, если у мероприятия нет разбивки на части

### GET

+ Response 200

    + Body

            {
                "Parts": [
                    {
                        "Id": 1,
                        "Title": "Поток 1",
                        "Order": 1
                    },
                    {
                        "Id": 2,
                        "Title": "Поток 2",
                        "Order": 2
                    }
                ]
            }
    + Schema

            {
                "type": "object",
                "properties": {
                    "Parts": {
                        "type": "array",
                        "items": {
                            "type": "object",
                            "properties": {
                                "Id": { "type": "integer" },
                                "Title": { "type": "string" },
                                "Order": { "type": "integer" }
                            },
                            "required": ["Id", "Title"]
                        }
                    }
                }
            }


## Товары [/event/products]

### GET

+ Response 200

    + Body

            {
                "Products": [
                    {
                        "Id": 1,
                        "Manager": "Event",
                        "Title": "Участие в мероприятии",
                        "Price": 3000
                    },
                    {
                        "Id": 2,
                        "Manager": "Food",
                        "Title": "Питание на мероприятии",
                        "Price": 500
                    }
                ]
            }

    + Schema

            {
                "type": "object",
                "properties": {
                    "Products": {
                        "type": "array",
                        "items": {
                            "type": "object",
                            "properties": {
                                "Id": { "type": "integer" },
                                "Manager": { "type": "string" },
                                "Title": { "type": "string" },
                                "Price": { "type": "integer" }
                            },
                            "required": ["Id", "Manager", "Title", "Price"]
                        }
                    }
                }
            }


## Шаблоны бейджей [/event/badges]

<span style="color: #ff0000;">Не реализовано</span>

### GET

+ Response 200
    
    + Body

            [
                {},
                {}
            ]
    + Schema
            
            {
                "type": "array",
                "items": {
                    "type": "object",
                    "properties": {
                        "Id": {
                            "type": "integer",
                            "required": true
                        },
                        "Title": {
                            "type": "string",
                            "required": true
                        },
                        "Template": {
                            "type": "string",
                            "required": true
                        }
                    }
                }
            }




# Group Участники

## Пользовательские поля [/participants/fields]

Задает список возможных полей для участника.

Для RUNET-ID в ответе сервера всегда присутствуют следующие поля: LastName, FirstName, FatherName, Email, Phone, Company, Position

### GET

+ Response 200

    + Body

            {
                "FirstName": {
                    "type": "string",
                    "required": true,
                    "hasLocales": true
                },
                "LastName": {
                    "type": "string",
                    "required": false,
                    "hasLocales": true
                },
                "Email": {
                    "type": "string",
                    "format": "email",
                    "hasLocales": false
                }
            }

    + Schema

            {
                "type": "object",
                "patternProperties": {
                    "^[a-zA-Z_][a-zA-Z0-9_]*$": {
                        "type": "object",
                        "properties": {
                            "type": { 
                                "type": "string",
                                "enum": ["string", "integer", "number", "boolean"]
                            },
                            "pattern": { "type": "string" },
                            "format": {
                                "type": "string",
                                "enum": ["date-time", "email", "uri"]
                            },
                            "required": { "type": "boolean" },
                            "hasLocales": { "type": "boolean" }
                        },
                        "required": ["type"]
                    }
                }
            }

## Список участников [/participants{?since,limit}]

### GET

+ Parameters
    + since (optional, string) ... Дата в формате ```Y-m-d H:i:s```. Будут возвращены участники, обновленные позднее этой даты
    + limit (optional, integer) ... Количество возвращаемых участников. Может быть ограничено сверху внутренними настройками API.

+ Response 200

    Если мероприятие не содержит частей, ```PartId = null``` и в массиве будет ровно один элемент.<br/>
    Если мероприятие содержит части, то для каждой части будет информация о статусе.

    ```StatusId = null``` означает, что у пользователя отсутствует статус на мероприятии или определенной части мероприятия, но при этом он проявлял какую либо активность в рамках этого мероприятия.

    + Body

            {
                "Participants": [
                    {
                        "Id": 234,
                        "Statuses": [
                            {
                                "PartId": 1,
                                "StatusId": 3
                            },
                            {
                                "PartId": 2,
                                "StatusId": null
                            }
                        ],
                        "Locales": {
                            "ru": {
                                "LastName": "Петров",
                                "FirstName": "Петр",
                                "FatherName": "Петрович"
                            },
                            "en": {
                                "LastName": "Petrov",
                                "FirstName": "Petr",
                                "FatherName": "Petrovich"
                            }
                        },
                        "UpdateTime": "2014-10-12 23:04:15"
                    }
                ],
                "HasMore": true,
                "NextSince": "2014-12-24 17:41:03"
            }
            
    + Schema

            {
                "type": "object",
                "properties": {
                    "Items" : {
                        "type": "array",
                        "items": {
                            "type": "object",
                            "properties": {
                                "Id": { "type": "integer" },
                                "Statuses": {
                                    "type": "array",
                                    "items": {
                                        "type": "object",                                
                                        "properties": {
                                            "PartId": { "type": ["integer", "null"] },
                                            "StatusId": { "type": ["integer", "null"] }
                                        }
                                    }
                                },
                                "Locales": {
                                    "type": "object",
                                    "properties": {
                                        "ru": {
                                            "type": "object",
                                            "patternProperties": {
                                                "^[a-zA-Z_][a-zA-Z0-9_]*$": {
                                                    "type": ["string", "integer", "number", "boolean"]
                                                }
                                            }
                                        },
                                        "en": {
                                            "type": "object",
                                            "patternProperties": {
                                                "^[a-zA-Z_][a-zA-Z0-9_]*$": {
                                                    "type": ["string", "integer", "number", "boolean"]
                                                }
                                            }
                                        }
                                    }
                                },
                                "UpdateTime": { "type": "string" },
                                "Photo": { "type": "string" },
                                "ExternalId": { "type": "string" }
                            },
                            "patternProperties": {
                                "^[a-zA-Z_][a-zA-Z0-9_]*$": {
                                    "type": ["string", "integer", "number", "boolean"]
                                }
                            },
                            "required": ["Id", "Statuses", "UpdateTime"]
                        }
                    },
                    "HasMore": {"type": "boolean"},
                    "NextSince": {"type": "string"},
                }
            }
    
            

## Создание участника [/participants]

### POST

Для мероприятий без частей ```PartId = null``` и в массиве ```Statuses``` ровно один элемент.

Для мероприятий с несколькими частями:
1. Запрещено передавать несколько элементов с одинаковым ```PartId```.
2. Разрешено не передавать некоторые ```PartId```. В этом случае для переданных ```PartId``` выставляется соответствующий статус, для всех остальных выставляется ```StatusId = null```

+ Request
    
    + Headers

            X-Ruvents-Operator: 2

    + Body

            {
                "Statuses": [
                    {
                        "PartId": 1,
                        "StatusId": 3
                    },
                    {
                        "PartId": 2,
                        "StatusId": null
                    }
                ],
                "LastName": "Петров",
                "FirstName": "Петр",
                "FatherName": "Петрович",
                "Visible": true
            }
    + Schema

            {
                "type": "object",
                "properties": {
                    "Statuses": {
                        "type": "array",
                        "items": {
                            "type": "object",                                
                            "properties": {
                                "PartId": { "type": ["integer", "null"] },
                                "StatusId": { "type": ["integer", "null"] }
                            }
                        }
                    },
                    "Visible": { "type": "boolean", "default": true }
                },
                "patternProperties": {
                    "^[a-zA-Z_][a-zA-Z0-9_]*$": {
                        "type": ["string", "integer", "number", "boolean"]
                    }
                },
                "required": ["Statuses"]
            }

+ Response 200

    + Body

            {
                "Id": 234
            }
    + Schema

            {
                "type": "object",
                "properties": {
                    "Id": {
                        "type": "integer"
                    }
                }
            }


## Изменение участника [/participants/{Id}]

+ Parameters
    + Id (required, integer) ... Идентификатор участника

### Редактирование [PUT]

Передаются только изменившиеся данные. 

Для мероприятий с несколькими частями передаются статусы для тех частей, для которых они изменились.

+ Request

    + Headers

            X-Ruvents-Operator: 2

    + Body

            {
                "Statuses": [
                    {
                        "PartId": 1,
                        "StatusId": 3
                    },
                    {
                        "PartId": 2,
                        "StatusId": null
                    }
                ],
                "LastName": "Петров",
                "FirstName": "Петр",
                "FatherName": "Петрович"
            }
    + Schema

            {
                "type": "object",
                "properties": {
                    "Statuses": {
                        "type": "array",
                        "items": {
                            "type": "object",                                
                            "properties": {
                                "PartId": { "type": ["integer", "null"] },
                                "StatusId": { "type": ["integer", "null"] }
                            }
                        }
                    }
                },
                "patternProperties": {
                    "^[a-zA-Z_][a-zA-Z0-9_]*$": {
                        "type": ["string", "integer", "number", "boolean"]
                    }
                },
                "required": ["Statuses"]
            }

+ Response 200

### Удаление [DELETE]

Удаляет участие на текущем мероприятии. Участник перестает возвращаться в методе ```/participants```

+ Request

    + Headers

            X-Ruvents-Operator: 2

+ Response 200


## Глобальный поиск [/users{?query}]

Доступен только для RUNET-ID.
Возвращает не более 50 пользователей.

### GET

+ Parameters
    + query (required, string) 

        Универсальный поисковой запрос пользователей на RUNET-ID. Допустимо передавать: Id, список Id через запятую, Фамилию, Фамилию Имя, Имя Фамилию, Фамилию Имя Отчество, Email

+ Response 200

    + Body

            {
                "Users": [
                    {
                        "Id": 234,
                        "LastName": "Петров",                    
                        "FirstName": "Петр",
                        "FatherName": "Петрович",
                        "Email": "test-petr@runet-id.com",
                        "Phone": "7345452342",
                        "Company": "Рога и копыта",
                        "Position": "Главный забойщик",
                    },
                    {
                        "Id": 235,
                        "LastName": "Петров",                    
                        "FirstName": "Иван",
                        "FatherName": "Иванович",
                        "Email": "test-ivan@runet-id.com",
                        "Phone": "7424342323",
                        "Company": "Вектор",
                        "Position": "Генеральный директор",
                    }
                ]
            }
            

    + Schema

            {
                "type": "object",
                "properties": {
                    "Users": {
                        "type": "array",
                        "items": {
                            "type": "object",
                            "properties": {
                                "Id": { "type": "integer"},
                                "LastName": { "type": "string"},
                                "FirstName": { "type": "string"},
                                "FatherName": { "type": "string"},
                                "Email": { "type": "string"},
                                "Phone": { "type": "string"},
                                "Company": { "type": "string"},
                                "Position": { "type": "string"}
                            }
                        },
                        "maxItems": 50
                    }
                }
            }
            


# Group Бейджи

## Список бейджей [/badges{?since,limit}]

### GET

+ Parameters
    + since (optional, string) ... Дата в формате ```Y-m-d H:i:s```. Будут возвращены бейджи, созданные позднее этой даты.
    + limit (optional, integer) ... Количество возвращаемых бейджей. Может быть ограничено сверху внутренними настройками API.

+ Response 200

    + Body

            {
                "Badges":[
                    {
                        "Id": 23340,
                        "UserId": 234,
                        "PartId": null,
                        "RoleId": 1,
                        "OperatorId": 1,
                        "CreationTime": "2014-12-17 11:04:37"
                    },
                    {
                        "Id": 23349,
                        "UserId": 234,
                        "PartId": null,
                        "RoleId": 1,
                        "OperatorId": 2,
                        "CreationTime": "2014-12-17 11:06:37"
                    }
                ],
                "HasMore": true,
                "NextSince": "2014-12-24 17:42:53" 
            }

    + Schema

            {
                "type": "object",
                "properties": {
                    "Items" : {
                        "type": "array",
                        "items": {
                            "type": "object",
                            "properties": {
                                "Id": { "type": "integer" },
                                "UserId": { "type": "integer" },
                                "PartId": { "type": ["integer", "null"] },
                                "RoleId": { "type": "integer" },
                                "OperatorId": { "type": "integer" },
                                "CreationTime": { "type": "string" }
                            },
                            "required": ["Id", "UserId", "PartId", "RoleId", "OperatorId", "CreationTime"]
                        }
                    },
                    "HasMore": {"type": "boolean"},
                    "NextSince": {"type": "string"}
                }
            }
            


## Создание бейджа [/badges]

### POST

Для раздельной регистрации на отдельные части на мероприятии с несколькими частями необходимо передавать ```PartId```<br/>
Иначе, ```PartId``` может не передаваться или его значение может быть  ```null```

+ Request

    + Headers

            X-Ruvents-Operator: 2
    
    + Body

            {
                "UserId": 234
            }
    + Schema

            {
                "type": "object",
                "properties": {
                    "UserId": { "type": "integer" },
                    "PartId": { "type": ["integer", "null"] }
                },
                "required": ["UserId"]
            }

+ Response 200

    + Body

            {
                "Id": 23340
            }
    + Schema

            {
                "type": "object",
                "properties": {
                    "Id": { "type": "integer" }
                },
                "required": ["Id"]
            }

# Group Оплаты и товары

## Оплаченные товары [/orderitems{?since,limit}]

### GET

+ Parameters
    + since (optional, string) ... Дата в формате ```Y-m-d H:i:s```. Будут возвращены обновленные позднее этой даты товары.
    + limit (optional, integer) ... Количество возвращаемых оплаченных товаров. Может быть ограничено сверху внутренними настройками API.

+ Response 200
    
    + Body

            {
                "OrderItems": [
                    {
                        "Id": 123233,
                        "UserId": 234,
                        "ProductId": 1,
                        "Paid": true,
                        "PaidTime": "2014-12-10 17:15:48",
                        "Discount": 100,
                        "PromoCode": "dSfar34Da",
                        "PayType": "promo"                    
                    },
                    {
                        "Id": 123234,
                        "UserId": 234,
                        "ProductId": 2,
                        "Paid": true,
                        "PaidTime": "2014-11-10 14:35:17",
                        "Discount": 0,
                        "PromoCode": null,
                        "PayType": "juridical"
                    }
                ],
                "HasMore": true,
                "NextSince": "2014-12-24 17:42:53" 
            }
            
    + Schema

            {
                "type": "object",
                "properties": {
                    "Items" : {
                        "type": "array",
                        "items": {
                            "type": "array",
                            "items": {
                                "type": "object",
                                "properties": {
                                    "Id": { "type": "integer" },
                                    "UserId": { "type": "integer" },
                                    "ProductId": { "type": "integer" },
                                    "Paid": { "type": "boolean" },
                                    "PaidTime": { "type": "string" },
                                    "Discount": { 
                                        "type": "integer",
                                        "minimum": 0,
                                        "maximum": 100
                                    },
                                    "PromoCode": { "type": ["string", "null"] },
                                    "PayType": { "enum": [ "promo", "individual", "juridical" ] }
                                },
                                "required": ["Id", "UserId", "ProductId", "Paid", "PaidTime", "Discount", "PromoCode", "PayType"]
                            }
                        }
                    },
                    "HasMore": {"type": "boolean"},
                    "NextSince": {"type": "string"}
                }
            }


## Выдача товаров [/products/{Id}/checks]


### Список [GET]

<span style="color: #ff0000;">Не реализовано</span>


### Выдача [POST]

<span style="color: #ff0000;">Не реализовано</span>


# Group Утилиты

## Пинг [/ping]

### GET

+ Response 200

    + Body

            {
                "DateSignal": "2014-12-18 15:46:47"
            }
    + Schema

            {
                "type": "object",
                "properties": {
                    "DateSignal": { "type": "string" }
                },
                "required": ["DateSignal"]
            }




