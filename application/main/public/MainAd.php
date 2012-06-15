<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 06.09.11
 * Time: 13:36
 * To change this template use File | Settings | File Templates.
 */
 
class MainAd extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $titles = Registry::GetWord('titles');
		$this->SetTitle($titles['ad']);
    echo $this->view;
  }
}
