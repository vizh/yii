<?php

class MainReturn extends PayCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($eventId = 0)
  {
    // TODO: Implement doExecute() method.
    $eventId = intval($eventId);
    if ($eventId == 236)
    {
      Lib::Redirect('http://2012.i-comference.ru/my/');
    }
    elseif ($eventId == 106)
    {
      Lib::Redirect('http://www.in-numbers.ru/subscribe/success.php');
    }
    elseif ($eventId == 245)
    {
      Lib::Redirect('http://2012.russianinternetforum.ru/my/?paid=1');
    }
    elseif ($eventId == 258)
    {
      Lib::Redirect('http://sp-ic.ru/my/');
    }
    elseif ($eventId == 246)
    {
      Lib::Redirect('http://2012.siteconf.ru/my/?paid');
    }
    elseif ($eventId == 312)
    {
      Lib::Redirect('http://affdays.ru/account/');
    }
    elseif ($eventId == 248)
    {
      Lib::Redirect('http://2012.russianinternetweek.ru/my/');
    }
  }
}
