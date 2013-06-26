<?php
$files = array_diff(scandir('../config/rules/'), ['.', '..', '.DS_Store']);
$result = [];

foreach ($files as $file)
  $result[] = require "../config/rules/$file";

// Запрещено всё, что не разрешено.
$result[] = ['deny', 'users' => ['*']];

return call_user_func_array(
  ['CMap', 'mergeArray'],
  $result
);
