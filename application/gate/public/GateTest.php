<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.xml.*');

class GateTest extends GateCommand
{
  protected function doExecute()
  {
    $test = empty($_REQUEST['test']) ? '' : $_REQUEST['test'];


    echo	'<?xml version="1.0" encoding="windows-1251"?>'.
          '<response>'.
          '<error-code>0</error-code>'.
          '<remote-addr>'.$_SERVER['REMOTE_ADDR'].'</remote-addr>'.
          '<test>'.$test.'</test>'.
          '</response>';
  }
}