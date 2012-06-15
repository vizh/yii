<?php
AutoLoader::Import('news.source.*');
 
class NewsRssCategory extends AbstractCommand
{

  /**
   * Основные действия комманды
   * @param string $name
   * @return void
   */
  protected function doExecute($name = '')
  {
    $category = NewsCategories::GetByName($name);

    if (empty($category))
    {
      $this->Send404AndExit();
    }

    $news = $category->GetNews(10, 1);

    $titles = Registry::GetWord('titles');

    $title = $titles['news'] . ' / ' . $category->Title;

    NewsPost::GenerateFeed($title, '', RouteRegistry::GetUrl('news', '', 'category', array('name' => $name)), $news);
  }
}
