FORMAT: 1A
HOST: https://ruvents2.runet-id.loc

# RUVENTS Регистрация

Данное API предназначено для регистрации участников во время проведения мероприятия.

## Общая информация

Для того, чтобы вызвать метод API *RUVENTS Регистрация*, вам необходимо осуществить запрос по протоколу **HTTPS** на указанный URL:

```http
https://ruvents2.runet-id.loc/{METHOD}?{PARAMETERS}
```

Результат возвращается в формате JSON

Для каждого мероприятия генерируется ```Hash```, с помощью которого осуществляется авторизация для доступа к API. Для авторизации в любом запросе необходимо передавать заголовок

```http
X-Ruvents-Hash: {Hash}
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
    error: {code: 34, message: "Текст ошибки в человекопонятном формате"}
}
```


# Group Event

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


## Части мероприятия [/event/parts]

### GET

+ Response

    + Body

            [
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
                        "Order": {
                            "type": "integer"
                        }
                    }
                }
            }


# Group Notes
Group description (also with *Markdown*)

## Note List [/notes]
Note list description

+ Even
+ More
+ Markdown

+ Model

    + Headers

            Content-Type: application/json
            X-Request-ID: f72fc914
            X-Response-Time: 4ms

    + Body

            [
                {
                    "id": 1,
                    "title": "Grocery list",
                    "body": "Buy milk"
                },
                {
                    "id": 2,
                    "title": "TODO",
                    "body": "Fix garage door"
                }
            ]
