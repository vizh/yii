<?php

class EventPromo extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $result = array();

    $item = new stdClass();
    $item->EventId = 246;
    $item->Promo = 'http://rocid.ru/files/test-promo.png';
    $result[] = $item;

    $item = new stdClass();
    $item->EventId = 248;
    $item->Promo = 'http://rocid.ru/files/test-promo.png';
    $result[] = $item;

    $item = new stdClass();
    $item->EventId = 312;
    $item->Promo = 'http://rocid.ru/files/test-promo.png';
    $result[] = $item;

    $item = new stdClass();
    $item->EventId = 249;
    $item->Promo = 'http://rocid.ru/files/test-promo.png';
    $result[] = $item;


    $this->SendJson($result);
  }
}