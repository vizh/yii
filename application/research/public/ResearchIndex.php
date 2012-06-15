<?php
AutoLoader::Import('research.source.*');

class ResearchIndex extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $this->view->Trends = Trend::model()->orderOrder()->findAll();
    echo $this->view;
  }
}
