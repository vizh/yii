<?php
AutoLoader::Import('comission.source.*');

class ComissionDelete extends AdminCommand
{

  /**
   * Основные действия комманды
   * @param int $id
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $id = intval($id);
    
  }
}
