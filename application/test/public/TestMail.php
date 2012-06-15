<?php
AutoLoader::Import('library.rocid.user.*');
 
class TestMail extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    //User::SendRegisterEmail('melnikov@raec.ru', '00000', 'тест-тест-тест');

    echo 'success';
  }
}
