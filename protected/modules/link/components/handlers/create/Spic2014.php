<?php
namespace link\components\handlers\create;

class Spic2014 extends Base
{
  public function getBody()
  {
    return $this->renderBody('link.views.mail.create.spic2014', ['link' => $this->link]);
  }
} 