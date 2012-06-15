<?php

class MainAbout extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $titles = Registry::GetWord('titles');
		$this->SetTitle($titles['about']);
    echo $this->view;
  }
}
