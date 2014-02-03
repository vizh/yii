<?php
namespace mail\components;

class MailController extends \CController
{
  protected $user;

  /**
   * @param \user\models\User $user
   */
  public function __construct($user, $twoColumn = false)
  {
    parent::__construct('default', null);
    $this->user = $user;
    $this->layout = '/layouts/mail/'. ($twoColumn ? 'two' : 'one').'-column';
  }
}
