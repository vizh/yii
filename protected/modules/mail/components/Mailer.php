<?php
namespace mail\components;

abstract class Mailer
{

  /**
   * @param Mail[] $mails
   * @return void
   */
  protected abstract function internalSend($mails);
 
  public final function send($mails)
  {
    if (!is_array($mails))
    {
      $mails = [$mails];
    }

    $error = null;
    try
    {
      $this->internalSend($mails);
    }
    catch (\Exception $e)
    {
      $error = $e->getMessage();
    }

    /** @var Mail $mail */
    foreach ($mails as $mail)
    {
      $log = $mail->getLog();
      if ($error !== null)
      {
        $log->setError($error);
      }
      $log->save();
    }
  }
}
