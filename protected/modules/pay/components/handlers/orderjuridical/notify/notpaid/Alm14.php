<?php
namespace pay\components\handlers\orderjuridical\notify\notpaid;

class Alm14 extends Base
{
  public function getBody()
  {
    return $this->renderBody('pay.views.mail.orderjuridical.notify.notpaid.alm14', array('order' => $this->order));
  }
}
