<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 19.07.11
 * Time: 16:20
 * To change this template use File | Settings | File Templates.
 */
 
class GateTest2 extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    print_r($_REQUEST);
    print_r($_POST);
    print_r($_GET);
    echo '111';
  }
}
