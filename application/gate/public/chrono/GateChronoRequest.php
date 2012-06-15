<?php

 
class GateChronoRequest extends AbstractCommand
{
  const ChronoLink = 'https://secure.chronopay.com/selection.cgi';

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    Lib::Redirect(self::ChronoLink . '?' . $_SERVER['QUERY_STRING']);
  }
}
