<?php
AutoLoader::Import('research.source.*');

class ResearchExperts extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {

    $this->view->Trends = Trend::model()->orderOrder()->with('Experts')->findAll();

    echo $this->view;
  }
}
