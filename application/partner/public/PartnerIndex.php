<?php
AutoLoader::Import('library.rocid.event.*');

class PartnerIndex extends PartnerCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {



    echo $this->view;
  }
}
