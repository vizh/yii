<?php

class GateGet extends AbstractCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $param = (object) $_REQUEST;

    if (getenv('REMOTE_ADDR') != '85.21.96.191' && getenv('REMOTE_ADDR') != '82.142.129.35' && getenv('REMOTE_ADDR') != '82.142.129.35') {
      die('Get out!..');
    }

    print '-----<br />';
    print 'ID проекта: ' . $param->event . '<br />';
    print 'IP сервера: ' . $param->ip . '<br />';
    print 'Unique key: ' . substr(md5("$param->event:$param->ip" . crc32("$param->event:$param->ip")), 5, 15) . '<br />';
    print '-----<br />';
  }
}
