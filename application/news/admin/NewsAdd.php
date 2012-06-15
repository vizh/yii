<?php
AutoLoader::Import('news.source.*');
 
class NewsAdd extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $news = new NewsPost();
    $news->PostDate = date('Y-m-d H:i');
    $news->save();

    Lib::Redirect('/admin/news/edit/' . $news->NewsPostId . '/');
  }
}
