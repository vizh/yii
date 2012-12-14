<?php
define('RUNETID_HOST', 'runetid.local');

return CMap::mergeArray(
  CMap::mergeArray(
    CMap::mergeArray(
      require(dirname(__FILE__).'/yiiconfig.php'),
      require(dirname(__FILE__).'/routes.php')
    ),
    CMap::mergeArray(
      require(dirname(__FILE__).'/modules.php'),
      require(dirname(__FILE__).'/params.php')
    )
  ),

  CMap::mergeArray(
    require(dirname(__FILE__).'/partner.php'),
    require(dirname(__FILE__).'/ruvents.php')
  )
);