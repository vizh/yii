<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 29.09.11
 * Time: 15:17
 * To change this template use File | Settings | File Templates.
 */
 
class TestJs extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    echo '<script type="text/javascript">alert(\'Проверка работы js! JS работает!\');</script>';
    echo 'Если вы не увидели всплывающего сообщения - JS не работает!';
  }
}
