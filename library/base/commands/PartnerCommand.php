<?php
AutoLoader::Import('partner.source.*');

abstract class PartnerCommand extends AbstractCommand
{
  /**
   * @var PartnerAccount
   */
  protected $Account = null;

  protected function preExecute()
  {
    parent::preExecute();

    Lib::Redirect('http://partner.rocid.ru/');

    header('Content-Type: text/html; charset=utf-8');

    $this->view->SetLayout('partner');

    if (!Yii::app()->partner->isGuest)
    {
      $this->Account = PartnerAccount::model()->findByPk(Yii::app()->partner->getId());
    }

    if ($this->Account == null)
    {
      $router = RouteRegistry::GetInstance();
      if ($router->GetCommand() != 'login')
      {
        $back = $_SERVER['REQUEST_URI'];
        Lib::Redirect(RouteRegistry::GetUrl('partner', '', 'login') . '?' . http_build_query(array('backUrl' => $back)));
      }
    }

    $this->view->Account = $this->Account;
  }


  protected function postExecute()
  {
    if ($_SERVER['HTTP_HOST'] == 'beta.rocid' || $_SERVER['HTTP_HOST'] == 'pay.beta.rocid')
    {
      $logger = Yii::getLogger();
      $stats = Yii::app()->db->getStats();

      echo '<br/> SQL queries: ' . $stats[0] .
        '<br/> SQL Execution Time: ' . $stats[1] .
        '<br/> Full Execution Time: ' . $logger->getExecutionTime();

      $logs = $logger->getProfilingResults();

      echo '<pre>';
      print_r($logs);
      echo '</pre>';
    }
  }
}