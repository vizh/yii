<?php
AutoLoader::Import('comission.source.*');

class ComissionIndex extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $comissions = Comission::GetAll();

    foreach ($comissions as $comission)
    {
      $view = new View();
      $view->SetTemplate('comission');
      $view->Comission = $comission;
      $this->view->Comissions .= $view;
    }

    echo $this->view;
  }
}
