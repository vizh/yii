<?php

$result = [];

foreach (glob(BASE_PATH.'/config/rules/*.php') as $rule) {
    /** @noinspection PhpIncludeInspection */
    $result[] = require $rule;
}

// Запрещено всё, что не разрешено.
$result[] = ['deny', 'users' => ['*']];

return call_user_func_array(
    ['CMap', 'mergeArray'],
    $result
);
