<?php
AutoLoader::Import('news.source.*');

class NewsRssUpdate extends AbstractCommand implements ISettingable
{
  /**
   * Возвращает массив вида:
   * array('name1'=>array('DefaultValue', 'Description'),
   *       'name2'=>array('DefaultValue', 'Description'), ...)
   */
  public function GetSettingList()
  {
    return array('RssPrivateKey' => array('0d3e0e45d733b04deeb511fcbde5351a', 'Защитный ключ для парсинга rss.'));
  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($rssId = '')
  {
//    $privateKey = SettingManager::GetSetting('RssPrivateKey');
//    if ($privateKey != $key)
//    {
//      exit;
//    }
    $rssId = intval($rssId);
    if ($rssId != 0)
    {
      $rss = NewsRss::GetById($rssId);
    }
    else
    {
      $rss = NewsRss::GetFirstInQueue();
    }

    if ($rss == null)
    {
      exit;
    }

    $rss->UpdateRss();
    Lib::Redirect('/admin/news/list/rss/');
  }
}