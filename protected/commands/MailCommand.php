<?php
class MailCommand extends \application\components\console\BaseConsoleCommand
{
  public function run($args)
  {
    $startTime = time();
    $template = \mail\models\Template::model()->byActive()->bySuccess(false)->find(['order' => '"t"."Id" ASC']);
    if ($template == null)
      return 0;

    while(true)
    {
      $template->send();
      if (time() - $startTime >= 30 || $template->Success)
        return 0;
    }
  }
} 