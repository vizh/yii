<?php
define('ROCID_HOST', 'beta.rocid');

return CMap::mergeArray(
  require(dirname(__FILE__).'/yiiconfig.php'),
  require(dirname(__FILE__).'/routes.php'),
  require(dirname(__FILE__).'/diffs.php')
);