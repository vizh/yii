<?php
use mail\models\Template;

class MailCommand extends \application\components\console\BaseConsoleCommand
{
  public function run($args)
  {
    $startTime = time();
      /** @var Template $template */
    $template = \mail\models\Template::model()->byActive()->bySuccess(false)->find(['order' => '"t"."Id" ASC']);
    if ($template == null)
      return 0;

    while(true)
    {
      $template->send();
      if (time() - $startTime >= 40 || $template->Success)
        return 0;
    }
  }
} 