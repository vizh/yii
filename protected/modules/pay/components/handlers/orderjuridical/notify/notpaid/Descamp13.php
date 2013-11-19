<?php
namespace pay\components\handlers\orderjuridical\notify\notpaid;


class Descamp13 extends Base
{
  public function getBody()
  {
    return $this->renderBody('pay.views.mail.orderjuridical.notify.notpaid.descamp', ['order' => $this->order]);
  }
}