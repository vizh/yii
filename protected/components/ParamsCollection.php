<?php

namespace application\components;

/**
 * @property int $ApiMaxResults Максимальное количество результатов на одной странице при постраничной выдачи в api
 * @property int $SecureLoginCheckDelay Задержка при использовании методов проверки и смены пароля, которая усложнит перебор пароля
 */
class ParamsCollection extends \CAttributeCollection
{

}