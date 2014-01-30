<?php
namespace pay\components\handlers\buyproduct;

class TicketOnEvent extends Base
{
  public function getSubject()
  {
    return 'Куплены билеты';
  }

  /**
   * @return string
   */
  public function getBody()
  {
    // TODO: Implement getBody() method.
  }
}