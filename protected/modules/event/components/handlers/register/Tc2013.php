<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 25.11.13
 * Time: 12:32
 */

namespace event\components\handlers\register;


class Tc2013 extends Base
{
  public function getSubject()
  {
    return 'Ваш пригласительный билет TechCrunch Moscow 2013';
  }

  public function getBody()
  {
    return $this->renderBody('event.views.mail.register.tc13', [
      'user' => $this->user,
      'participant' => $this->participant
    ]);
  }
} 