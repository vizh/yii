<?php
namespace mail\components\mail;


use mail\components\Mailer;

class Template extends \mail\components\Mail
{
  protected $model;

  public function __construct(Mailer $mailer, \mail\models\Template $model)
  {
    parent::__construct($mailer);
    $this->model = $model;
  }


  /**
   * @return string
   */
  public function getFrom()
  {
    // TODO: Implement getFrom() method.
  }

  /**
   * @return string
   */
  public function getTo()
  {
    // TODO: Implement getTo() method.
  }

  /**
   * @return string
   */
  public function getBody()
  {
    // TODO: Implement getBody() method.
  }
}