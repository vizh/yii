<?php

class EvtdemoCommand extends \application\components\console\BaseConsoleCommand
{
  public function run($args)
  {
    \event\components\DemoEventCreator::create();
  }
} 