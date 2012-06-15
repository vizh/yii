<?php
AutoLoader::Import('library.rocid.pay.*');

abstract class PayCommand extends AuthCommand
{
  protected function preExecute()
  {
    parent::preExecute();

    header('Content-Type: text/html; charset=utf-8');

    $this->view->SetLayout('pay');

    $this->view->Banner = $this->getBanner();

    $titles = Registry::GetWord('titles');
    $this->SetTitle($titles['pay']);
  }

  protected function postExecute()
  {
    if ( stristr($_SERVER['HTTP_HOST'], 'beta.rocid') !== false || (!empty($this->LoginUser) && $this->LoginUser->RocId == 35287))
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
