<?php
namespace mail\components;

class MailController extends \CController
{
  protected $mailer;

  /**
   * @param mailers\template\ITemplateMailer $mailer
   * @param bool $twoColumn
   */
  public function __construct(\mail\components\mailers\template\ITemplateMailer $mailer, $twoColumn = false)
  {
    parent::__construct('default', null);
    $this->layout = '/layouts/mail/'. ($twoColumn ? 'two' : 'one').'-column';
    $this->mailer = $mailer;
  }
}
