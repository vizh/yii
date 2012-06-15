<?php
AutoLoader::Import('news.source.*');
 
class NewsRss extends AbstractCommand
{
  /**
   * Основные действия комманды
   * @param string $company
   * @return void
   */
  protected function doExecute($company = '')
  {
    $title = '';
    $news = array();
    if ($company == 'company')
    {
      $news = NewsPost::GetLastByCompany(10, 1, 0);

      $titles = Registry::GetWord('titles');

      $title = $titles['news'] . $titles['rss_companies'];
    }
    else
    {
      $news = NewsPost::GetLastByCompany(10);

      $titles = Registry::GetWord('titles');

      $title = $titles['news'];
    }


    NewsPost::GenerateFeed($title, '', RouteRegistry::GetUrl('news', '', 'index'), $news);
  }
}
