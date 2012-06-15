<?php

class MainAgreement extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $textView = new View();
    $textView->SetTemplate('text', 'core', 'agreement', '', 'public');

    $this->view->Text = $textView;
    echo $this->view;
  }
}