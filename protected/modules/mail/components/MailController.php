<?php
namespace mail\components;

class MailController extends \CController
{
  protected $user;

  /**
   * @param \user\models\User $user
   * @param string $template
   */
  public function __construct(\user\models\User $user, $template = null)
  {
    parent::__construct('default', null);
    switch ($template)
    {
      case \mail\models\Layout::OneColumn: $layout = 'one-column';
        break;

      case \mail\models\Layout::TwoColumn: $layout = 'two-column';
        break;

      default: $layout = 'empty';
        break;
    }
    $this->layout = '/layouts/mail/'.$layout;
    $this->user = $user;
  }
}
