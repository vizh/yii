<?php

 
class SettingsMask extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $masks = CoreMask::GetAll();
    $container = new ViewContainer();
    foreach ($masks as $mask)
    {
      $view = new View();
      $view->SetTemplate('mask-item');
      $view->MaskId = $mask->MaskId;
      $view->Title = $mask->Title;
      $view->Type = $mask->Type;

      $container->AddView($view);
    }
    $this->view->Masks = $container;

    echo $this->view;
  }
}
