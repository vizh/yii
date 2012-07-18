<?php
return CMap::mergeArray(
  CMap::mergeArray(
    require(dirname(__FILE__).'/yiiconfig.php'),
    require(dirname(__FILE__).'/routes.php')
  ),
  require(dirname(__FILE__).'/diffs.php')
);