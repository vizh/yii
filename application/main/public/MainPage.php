<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alaris
 * Date: 9/13/12
 * Time: 5:44 PM
 * To change this template use File | Settings | File Templates.
 */
class MainPage extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @param string $page
   * @return void
   */
  protected function doExecute($page = '')
  {
    switch ($page)
    {
      case 'pay':
        $this->view->SetTemplate('pay');
        break;
      case 'delivery':
        $this->view->SetTemplate('delivery');
        break;
      case 'payback':
        $this->view->SetTemplate('payback');
        break;
      case 'contact':
        $this->view->SetTemplate('contact');
        break;
      default:
        $this->Send404AndExit();
    }

    echo $this->view;
  }
}
