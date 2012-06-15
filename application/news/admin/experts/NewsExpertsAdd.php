<?php
AutoLoader::Import('news.source.*');
 
class NewsExpertsAdd extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $news = new NewsPost();
    $news->PostDate = date('Y-m-d H:i');
    $news->NewsCategoryId = NewsPost::ExpertsCategoryId;
    $news->save();
    $news->AddCategory(NewsPost::ExpertsCategoryId);

    Lib::Redirect('/admin/news/edit/' . $news->NewsPostId . '/');
  }
}
