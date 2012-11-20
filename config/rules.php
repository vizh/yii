<?php
$dir = dirname(__FILE__) . '/rules/';
$files = scandir($dir);
$result = array();
foreach ($files as $file)
{
  if ($file != '.' && $file != '..' && $file != '.DS_Store')
  $result = CMap::mergeArray(
    $result,
    require($dir . $file)
  );
}
return $result;