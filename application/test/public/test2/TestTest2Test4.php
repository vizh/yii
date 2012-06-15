<?php
class TestTest2Test4 extends AbstractCommand
{
  protected function doExecute()
  {
    echo '<br/>Была запущена команда TestTest2Test4 модуля Test<br/>';
    echo 'Переменная name: ' . Registry::GetRequestVar('name');
  }  
}