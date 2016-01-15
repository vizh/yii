Приложения
==========

Приложения это объекты, которые управляют всей структурой и жизненным циклом прикладной системы Yii.
Каждая прикладная система Yii включает в себя один объект приложения, который создается во [входном скрипте](structure-entry-scripts.md)
и глобально доступен через `\Yii::$app`.

> Info: В зависимости от контекста, когда мы говорим "приложение", это может означать как объект приложения так и
  приложение как прикладную систему в целом.

Существует два вида приложений: [[yii\web\Application|веб приложения]] и [[yii\console\Application|консольные приложения]].
Как можно догадаться по названию, первый тип в основном занимается обработкой веб запросов, в то время как последний - консольных команд.


## Конфигурации приложения <span id="application-configurations"></span>

Когда [входной скрипт](structure-entry-scripts.md) создаёт приложение, он загрузит [конфигурацию](concept-configurations.md)
и применит её к приложению, например:

```php
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

// загрузка конфигурации приложения
$config = require(__DIR__ . '/../config/web.php');

// создание объекта приложения и его конфигурирование
(new yii\web\Application($config))->run();
```

Также как и обычные [конфигурации](concept-configurations.md), конфигурации приложения указывают как следует инициализировать
свойства объектов приложения. Из-за того, что конфигурация приложения часто является очень сложной, она разбивается на несколько
[конфигурационных файлов](concept-configurations.md#configuration-files), например, `web.php` - файл в приведённом выше примере.


## Свойства приложений <span id="application-properties"></span>

Существует много важных свойств приложения, которые вы настраиваете в конфигурациях приложения. Эти свойства обычно
описывают окружение, в котором работает приложение. Например, приложение должно знать каким образом загружать [контроллеры](structure-controllers.md),
где хранить временные файлы, и т. д. Ниже мы рассмотрим данные свойства.


### Обязательные свойства <span id="required-properties"></span>

В любом приложении, вы должны настроить минимум два свойства: [[yii\base\Application::id|id]]
и [[yii\base\Application::basePath|basePath]].


#### [[yii\base\Application::id|id]] <span id="id"></span>

Свойство [[yii\base\Application::id|id]] это уникальный индекс приложения, который отличает его от других приложений.
В основном это используется внутрисистемно. Хоть это и не обязательно, но для лучшей совместимости рекомендуется использовать
буквенно-цифровые символы при указании индекса приложения.


#### [[yii\base\Application::basePath|basePath]] <span id="basePath"></span>

Свойство [[yii\base\Application::basePath|basePath]] указывает на корневую директорию приложения. Эта директория содержит
весь защищенный исходный код приложения. В данной директории обычно могут находится поддиректории `models`, `views`,
`controllers`, содержащие код, соответствующий шаблону проектирования MVC.

Вы можете задать свойство [[yii\base\Application::basePath|basePath]] используя путь к директории или используя
[псевдоним пути](concept-aliases.md). В обоих случаях, указанная директория должна существовать, иначе будет выброшено
исключение. Путь будет нормализован функцией `realpath()`.

Свойство [[yii\base\Application::basePath|basePath]] часто используется для указания других важных путей (например, путь к 
директории runtime, используемой приложением). По этой причине, псевдоним пути `@app` предустановлен и содержит данный путь.
Производные пути могут быть получены с использованием этого псевдонима пути (например, `@app/runtime` указывает на
времененную директорию runtime).


### Важные свойства <span id="important-properties"></span>

Свойства, указанные в этом подразделе, часто нуждаются в преднастройке т.к. они разнятся от приложения к приложению.


#### [[yii\base\Application::aliases|aliases]] <span id="aliases"></span>

Это свойство позволяет настроить вам множество [псевдонимов](concept-aliases.md) в рамках массива.
Ключами массива являются имена псевдонимов, а значениями массива - соответствующие значения пути. Например,

```php
[
    'aliases' => [
        '@name1' => 'path/to/path1',
        '@name2' => 'path/to/path2',
    ],
]
```

Это свойство доступно таким образом, чтобы вы могли указывать псевдонимы в рамках конфигурации приложения, 
а не вызовов метода [[Yii::setAlias()]].


#### [[yii\base\Application::bootstrap|bootstrap]] <span id="bootstrap"></span>


Данное свойство является очень удобным, оно позволяет указать массив компонентов, которые должны быть загружены
в процессе  [[yii\base\Application::bootstrap()|начальной загрузки]] приложения. Например, если вы хотите, чтобы
[модуль](structure-modules.md) производил тонкую настройку [URL правил](runtime-url-handling.md), вы можете указать его
ID в качестве элемента данного свойства.

Каждый из элементов данного свойства, может быть указан в одном из следующих форматов:

- ID, указанный в [компонентах](#components);
- ID модуля, указанный в [модулях](#modules);
- название класса;
- массив конфигурации;
- анонимная функция, которая создаёт и возвращает компонент.

Например,

```php
[
    'bootstrap' => [
        // ID компонента приложения или модуля
        'demo',

        // название класса
        'app\components\Profiler',

        // массив конфигурации
        [
            'class' => 'app\components\Profiler',
            'level' => 3,
        ],

        // анонимная функция
        function () {
            return new app\components\Profiler();
        }
    ],
]
```
> Info: Если ID модуля такой же, как идентификатор компонента приложения, то в процессе [начальной загрузки](runtime-bootstrapping.md)
> будет использован компонент приложения. Если Вы вместо этого хотите использовать модуль, то можете указать его при
> помощи анонимной функции похожей на эту:
> ```php
[
    function () {
        return Yii::$app->getModule('user');
    },
]
```

В процессе [начальной загрузки](runtime-bootstrapping.md), каждый компонент будет создан. Если класс компонента имеет
интерфейс [[yii\base\BootstrapInterface]], то также будет вызван метод [[yii\base\BootstrapInterface::bootstrap()|bootstrap()]].

Еще одним практическим примером является конфигурация [базового шаблона приложения](start-installation.md), в котором
модули `debug` и `gii` указаны как `bootstrap` компоненты, когда приложение находится в отладочном режиме.

```php
if (YII_ENV_DEV) {
    // настройка конфигурации для окружения 'dev'
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}
```

> Note: Указывание слишком большого количества компонентов в [`bootstrap`](runtime-bootstrapping.md) приведет
к снижению производительности приложения, потому что для каждого запроса одно и то же количество компонентов должно
быть загружено. Таким образом вы должны использовать начальную загрузку разумно.


#### [[yii\web\Application::catchAll|catchAll]] <span id="catchAll"></span>

Данное свойство поддерживается только [[yii\web\Application|веб приложениями]]. Оно указывает
[действие контроллера](structure-controllers.md), которое должно обрабатывать все входящие запросы от пользователя.
В основном это используется, когда приложения находится в режиме обслуживания и должно обрабатывать все запросы через
одно действие.

Конфигурация это массив, первый элемент которого, определяет маршрут действия. Остальные элементы в формате пара
ключ-значение задают дополнительные параметры, которые должны быть переданы действию (методу контроллера actionXXX). 
Например,

```php
[
    'catchAll' => [
        'offline/notice',
        'param1' => 'value1',
        'param2' => 'value2',
    ],
]
```


#### [[yii\base\Application::components|components]] <span id="components"></span>

Данное свойство является наиболее важным. Оно позволяет вам зарегистрировать список именованных компонентов, называемых
[компоненты приложения](#structure-application-components.md), которые Вы можете использовать в других местах.
Например,

```php
[
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
    ],
]
```

Каждый компонент приложения указан массивом в формате ключ-значение. Ключ представляет собой ID компонента приложения,
в то время как значение представляет собой название класса или [конфигурацию](concept-configurations.md).

Вы можете зарегистрировать любой компонент в приложении, позже этот компонент будет глобально доступен через
выражение `\Yii::$app->componentID`.

Более подробная информация приведена в разделе [Компоненты приложения](structure-application-components.md).


#### [[yii\base\Application::controllerMap|controllerMap]] <span id="controllerMap"></span>

Данное свойство позволяет вам задавать соответствия(mapping) между ID контроллера и произвольным классом контроллера.
По-умолчанию, Yii задает соответствие между ID контроллера и его классом согласно данному [соглашению](#controllerNamespace)
(таким образом, ID `post` будет соответствовать `app\controllers\PostController` ). Задавая эти свойства вы можете
переопределить соответствия для необходимых контроллеров. В приведенном ниже примере, `account` будет соответствовать
контроллеру `app\controllers\UserController`, в то время как `article` будет соответствовать контроллеру
`app\controllers\PostController`.

```php
[
    'controllerMap' => [
        [
            'account' => 'app\controllers\UserController',
            'article' => [
                'class' => 'app\controllers\PostController',
                'enableCsrfValidation' => false,
            ],
        ],
    ],
]
```

Ключами данного свойства являются ID контроллеров, а значениями являются соответствующие названия 
классов(полное название класса с пространством имен) контроллера или [конфигурация](concept-configurations.md).


#### [[yii\base\Application::controllerNamespace|controllerNamespace]] <span id="controllerNamespace"></span>

Данное свойство указывает пространство имен, в котором по умолчанию должны находится названия классов контроллеров.
По-умолчанию значение равно `app\controllers`. Если ID контроллера `post`, то согласно соглашению, соответствующий класс
контроллера (без пространства имен) будет равен `PostController`, а полное название класса будет равно `app\controllers\PostController`.

Класс контроллера может также находиться в поддиректории директории, соответствующей этому пространству имен.
Например, ID контроллера `admin/post`, будет соответствовать полное имя класса контроллера `app\controllers\admin\PostController`.

Очень важно, чтобы полное имя класса контроллера могло быть использовано [автозагрузкой](concept-autoloading.md) и
соответствующее пространство имен вашего контроллера соответствовало данному свойству. Иначе, Вы получите ошибку
"Страница не найдена", при доступе к приложению.

В случае, если вы хотите переопределить соответствия как описано выше, вы можете настроить свойство [controllerMap](#controllerMap).


#### [[yii\base\Application::language|language]] <span id="language"></span>

Данное свойство указывает язык приложения, на котором содержимое страницы должно быть отображено конечному пользователю.
По-умолчанию значение данного свойства равно `en`, что означает "Английский". Если ваше приложение должно поддерживать
несколько языков, вы должны настроить данное свойство.

Значение данного свойства определяется различными аспектами [интернационализации](tutorial-i18n.md), в том числе
переводом сообщений, форматированием дат, форматированием чисел, и т. д. Например, виджет [[yii\jui\DatePicker]]
использует данное свойство для определения по умолчанию языка, на котором должен быть отображен календарь и формат данных
для календаря.

Рекомендуется что вы будете указывать язык в рамках стандарта [IETF](http://en.wikipedia.org/wiki/IETF_language_tag).
Например, для английского языка используется `en`, в то время как для английского в США - `en-US`.

Более детальная информация приведена в разделе [Интернационализация](tutorial-i18n.md).


#### [[yii\base\Application::modules|modules]] <span id="modules"></span>

Данное свойство указывает [модули](structure-modules.md), которые содержаться в приложении.

Значениями свойства могут быть массивы имен классов модулей или [конфигураций](concept-configurations.md), а ключами -
ID модулей. Например,

```php
[
    'modules' => [
        // a "booking" module specified with the module class
        'booking' => 'app\modules\booking\BookingModule',

        // a "comment" module specified with a configuration array
        'comment' => [
            'class' => 'app\modules\comment\CommentModule',
            'db' => 'db',
        ],
    ],
]
```

Более детальная информация приведена в разделе [Модули](structure-modules.md).


#### [[yii\base\Application::name|name]] <span id="name"></span>

Свойство указывает название приложения, которое может быть показано конечным пользователям. В отличие от
свойства [[yii\base\Application::id|id]], которое должно быть уникальным, значение данного свойства нужно в
основном для отображения и не обязательно должно быть уникальным.

Если ваш код не использует данное свойство, то вы можете не настраивать его.


#### [[yii\base\Application::params|params]] <span id="params"></span>

Данное свойство указывает массив глобально доступных параметров приложения. Вместо того, чтобы использовать
жестко фиксированные числа и строки в вашем коде, лучше объявить их параметрами приложения в едином месте и 
использовать в нужных вам местах кода. Например, вы можете определить размер превью для изображений следующим образом:

```php
[
    'params' => [
        'thumbnail.size' => [128, 128],
    ],
]
```

Затем, когда вам нужно использовать данные значения в вашем коде, вы делаете это как представлено ниже:

```php
$size = \Yii::$app->params['thumbnail.size'];
$width = \Yii::$app->params['thumbnail.size'][0];
```

Если позже вам понадобится изменить размер превью изображений, вам нужно только изменить это значение в настройке
приложения, не касаясь зависимого кода.


#### [[yii\base\Application::sourceLanguage|sourceLanguage]] <span id="sourceLanguage"></span>

Данное свойство указывает язык на котором написан код приложения. По-умолчанию значение равно `'en-US'`, что означает
"Английский" (США). Вы должны настроить данное свойство соответствующим образом, если содержимое в вашем коде является не
английским языком.

Аналогично свойству [language](#language), вы должны указать данное свойство в рамках стандарта [IETF](http://en.wikipedia.org/wiki/IETF_language_tag).
Например, для английского языка используется `en`, в то время как для английского в США - `en-US`.

Более детальная информация приведена в разделе [Интернационализация](tutorial-i18n.md).


#### [[yii\base\Application::timeZone|timeZone]] <span id="timeZone"></span>

Данное свойство предоставляет альтернативный способ установки временной зоны в процессе работы приложения.
Путем указания данного свойства, вы по существу вызываете PHP функцию 
[date_default_timezone_set()](http://www.php.net/manual/ru/function.date-default-timezone-set.php). Например,

```php
[
	// Europe/Moscow для России (прим. пер.)
    'timeZone' => 'America/Los_Angeles',
]
```

#### [[yii\base\Application::version|version]] <span id="version"></span>

Данное свойство указывает версию приложения. По-умолчанию значение равно `'1.0'`. Вы можете не настраивать это свойство, если
ваш код не использует его.


### Полезные свойства <span id="useful-properties"></span>

Свойства, указанные в данном подразделе, не являются часто конфигурируемыми, т. к. их значения по умолчанию
соответствуют общепринятым соглашениям. Однако, вы можете их настроить, если вам нужно использовать другие
соглашения.


#### [[yii\base\Application::charset|charset]] <span id="charset"></span>

Свойство указывает кодировку, которую использует приложение. По-умолчанию значение равно `'UTF-8'`, которое должно быть
оставлено как есть для большинства приложения, только если вы не работаете с устаревшим кодом, который использует большее
количество данных не юникода.


#### [[yii\base\Application::defaultRoute|defaultRoute]] <span id="defaultRoute"></span>

Свойство указывает [маршрут](runtime-routing.md), который должно использовать приложение, когда он не указан
во входящем запросе. Маршрут может состоять из ID модуля, ID контроллера и/или ID действия. Например, `help`,
`post/create`, `admin/post/create`. Если действие не указано, то будет использовано значение по умолчанию
указанное в [[yii\base\Controller::defaultAction]].

Для [[yii\web\Application|веб приложений]], значение по умолчанию для данного свойства равно `'site'`, что означает
контроллер `SiteController` и его действие по умолчанию должно быть использовано. Таким образом, если вы попытаетесь
получить доступ к приложению не указав маршрут, оно покажет вам результат действия `app\controllers\SiteController::actionIndex()`.

Для [[yii\console\Application|консольных приложений]], значение по умолчанию равно `'help'`, означающее, что встроенная
команда [[yii\console\controllers\HelpController::actionIndex()]] должна быть использована. Таким образом, если вы
выполните команду `yii` без аргументов, вам будет отображена справочная информация.


#### [[yii\base\Application::extensions|extensions]] <span id="extensions"></span>

Данное свойство указывает список [расширений](structure-extensions.md), которые установлены и используются приложением.
По-умолчанию, значением данного свойства будет массив, полученный из файла `@vendor/yiisoft/extensions.php`. Файл `extensions.php`
генерируется и обрабатывается автоматически, когда вы используете [Composer](https://getcomposer.org) для установки расширений.
Таким образом, в большинстве случаев вам не нужно настраивать данное свойство.

В особых случаях, когда вы хотите обрабатывать расширения в ручную, вы можете указать данное свойство следующим образом:

```php
[
    'extensions' => [
        [
            'name' => 'extension name',
            'version' => 'version number',
            'bootstrap' => 'BootstrapClassName',  // опционально, может быть также массив конфигурации
            'alias' => [  // опционально
                '@alias1' => 'to/path1',
                '@alias2' => 'to/path2',
            ],
        ],

        // ... аналогично для остальных расширений ...

    ],
]
```

Свойство является массивом спецификаций расширений. Каждое расширение указано массивом, состоящим из элементов `name` и `version`.
Если расширение должно быть выполнено в процессе [начальной загрузки](runtime-bootstrapping.md), то следует указать `bootstrap`
элемент, который может являться именем класса или [конфигурацией](concept-configurations.md).
Расширение также может определять несколько [псевдонимов](concept-aliases.md).


#### [[yii\base\Application::layout|layout]] <span id="layout"></span>

Данное свойство указывает имя шаблона по умолчанию, который должен быть использовать при формировании [представлений](structure-views.md).
Значение по умолчанию равно `'main'`, означающее, что должен быть использован шаблон `main.php` в [папке шаблонов](#layoutPath).
Если оба свойства [папка шаблонов](#layoutPath) и [папка представлений](#viewPath) имеют значение по умолчанию,
то файл шаблона по умолчанию может быть представлен псевдонимом пути как `@app/views/layouts/main.php`.

Для отключения использования шаблона, вы можете указать данное свойство как `false`, хотя это используется очень редко.


#### [[yii\base\Application::layoutPath|layoutPath]] <span id="layoutPath"></span>

Свойство указывает путь, по которому следует искать шаблоны. Значение по умолчанию равно `layouts`, означающее подпапку
в [папке представлений](#viewPath). Если значение [папки представлений](#viewPath) является значением по умолчанию, то
папка шаблонов по умолчанию может быть представлена псевдонимом пути как `@app/views/layouts`.

Вы можете настроить данное свойство как папку так и как [псевдоним](concept-aliases.md).


#### [[yii\base\Application::runtimePath|runtimePath]] <span id="runtimePath"></span>

Свойство указывает путь, по которому хранятся временные файлы, такие как: лог файлы, кэш файлы.
По-умолчанию значение равно папке, которая представлена псевдонимом пути `@app/runtime`.

Вы можете настроить данное свойство как папку или как [псевдоним](concept-aliases.md) пути. Обратите внимание,
что данная папка должна быть доступна для записи, процессом, который запускает приложение. Также папка должна быть
защищена от доступа конечными пользователями, хранимые в ней временные файлы могут содержать важную информацию.

Для упрощения работы с данной папкой, Yii предоставляет предопределенный псевдоним пути `@runtime`.


#### [[yii\base\Application::viewPath|viewPath]] <span id="viewPath"></span>

Данное свойство указывает базовую папку,где содержаться все файлы представлений. Значение по умолчанию представляет
собой псевдоним `@app/views`. Вы можете настроить данное свойство как папку так и как [псевдоним](concept-aliases.md).


#### [[yii\base\Application::vendorPath|vendorPath]] <span id="vendorPath"></span>

Свойство указывает папку сторонних библиотек, которые используются и управляются [Composer](https://getcomposer.org).
Она содержит все сторонние библиотеки используемые приложением, включая Yii фреймворк. Значение по умолчанию
представляет собой псевдоним `@app/vendor`.

Вы можете настроить данное свойство как папку так и как [псевдоним](concept-aliases.md). При изменении данного свойства,
убедитесь что вы также изменили соответствующим образом настройки Composer.

Для упрощения работы с данной папкой, Yii предоставляет предопределенный псевдоним пути `@vendor`.


#### [[yii\console\Application::enableCoreCommands|enableCoreCommands]] <span id="enableCoreCommands"></span>

Данное свойство поддерживается только [[yii\console\Application|консольными приложениями]]. Оно указывает
нужно ли использовать встроенные в Yii консольные команды. Значение по умолчанию равно `true`.


## События приложения <span id="application-events"></span>

В течение жизненного цикла приложения, возникает несколько событий. Вы можете назначать обработчики событий в
конфигурации приложения следующим образом:

```php
[
    'on beforeRequest' => function ($event) {
        // ...
    },
]
```

Использование синтаксиса `on eventName` детально описано в разделе [Конфигурации](concept-configurations.md#configuration-format).

Также вы можете назначить обработчики событий в процессе начальной [загрузки приложения](runtime-bootstrapping.md), сразу после того
как приложение будет создано. Например,

```php
\Yii::$app->on(\yii\base\Application::EVENT_BEFORE_REQUEST, function ($event) {
    // ...
});
```

### [[yii\base\Application::EVENT_BEFORE_REQUEST|EVENT_BEFORE_REQUEST]] <span id="beforeRequest"></span>

Данное событие возникает *до* того как приложение начинает обрабатывать входящий запрос. 
Настоящее имя события - `beforeRequest`.

На момент возникновения данного события, объект приложения уже создан и проинициализирован. Таким образом, это
является хорошим местом для вставки вашего кода с помощью событий, для перехвата управления обработкой запроса.
Например, обработчик события, может динамически подставлять язык приложения [[yii\base\Application::language]] в зависимости
от некоторых параметров.


### [[yii\base\Application::EVENT_AFTER_REQUEST|EVENT_AFTER_REQUEST]] <span id="afterRequest"></span>

Данное событие возникает *после* того как приложение заканчивает обработку запроса, но *до* того как произойдет 
отправка ответа. Настоящее имя события - `afterRequest`.

На момент возникновения данного события, обработка запроса завершена и вы можете воспользоваться этим для произведения постобработки
запроса, с целью настройки ответа.

Обратите внимание, что в компоненте [[yii\web\Response|response]] также возникают события в процессе отправки данных
конечному пользователю. Эти события возникают *после* текущего события.


### [[yii\base\Application::EVENT_BEFORE_ACTION|EVENT_BEFORE_ACTION]] <span id="beforeAction"></span>

Событие возникает *до* того как будет выполнено [действие контроллера](structure-controllers.md).
Настоящее имя события - `beforeAction`.

Событие является объектом [[yii\base\ActionEvent]]. Обработчик события может устанавливать
свойство [[yii\base\ActionEvent::isValid]] равным `false` для предотвращения выполнения действия.

Например,

```php
[
    'on beforeAction' => function ($event) {
        if (некоторое условие) {
            $event->isValid = false;
        } else {
        }
    },
]
```

Обратите внимание что то же самое событие `beforeAction` возникает в [модулях](structure-modules.md) и
[контроллерах](structure-controllers.md). Объекты приложения являются первыми, кто возбуждает данные события,
следуя за модулями (если таковые имеются) и в конце контроллерами. Если обработчик события устанавливает
свойство [[yii\base\ActionEvent::isValid]] равным `false`, все последующие события не возникнут.


### [[yii\base\Application::EVENT_AFTER_ACTION|EVENT_AFTER_ACTION]] <span id="afterAction"></span>

Событие возникает *после* выполнения [действия контроллера](structure-controllers.md).
Настоящее имя события - `afterAction`.

Событие является объектом [[yii\base\ActionEvent]]. Через свойство [[yii\base\ActionEvent::result]] обработчик события
может получить доступ и изменить значение выполнения действия контроллера.

Например,

```php
[
    'on afterAction' => function ($event) {
        if (некоторое условие) {
            // modify $event->result
        } else {
        }
    },
]
```

Обратите внимание, что то же самое событие `afterAction` возникает в [модулях](structure-modules.md) и
[контроллерах](structure-controllers.md). Эти объекты возбуждают событие в обратном порядке, если сравнивать с `beforeAction`.
Таким образом, контроллеры являются первыми, где возникает данное событие, затем в модулях (если таковые имеются),
и наконец в приложениях.


## Жизненный цикл приложения <span id="application-lifecycle"></span>

Когда [входной скрипт](structure-entry-scripts.md) выполняется для обработки запроса, приложение
будет развиваться согласно следующему жизненному циклу:

1. Входной скрипт загружает конфигурацию приложения в качества массива;
2. Входной скрипт создаёт новый объект приложения:
  * Вызывается метод [[yii\base\Application::preInit()|preInit()]], который настраивает некоторые 
    жизненно важные свойства приложения, такие как [[yii\base\Application::basePath|basePath]];
  * Регистрируется [[yii\base\Application::errorHandler|обработчик ошибок]];
  * Настраиваются свойства приложения;
  * Вызывается метод [[yii\base\Application::init()|init()]], который затем вызывает метод
    [[yii\base\Application::bootstrap()|bootstrap()]] для начальной загрузки компонентов.
3. Входной скрипт вызывает метод [[yii\base\Application::run()]] для запуска приложения:
  * Возникает событие [[yii\base\Application::EVENT_BEFORE_REQUEST|EVENT_BEFORE_REQUEST]];
  * Обработка запроса: разбор информации запроса в [маршрут](runtime-routing.md) с соответствующими параметрами;
    создание объектов модуля, контроллера и действия согласно указанному маршруту; запуск действия;
  * Возникает событие [[yii\base\Application::EVENT_AFTER_REQUEST|EVENT_AFTER_REQUEST]];
  * Ответ отсылается конечному пользователю.
4. Входной скрипт получает значение статуса выхода от приложения и заканчивает обработку запроса.