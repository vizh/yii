<?php
AutoLoader::Import('news.source.*');

class NewsCategoryDelete extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($catId = '')
  {
    $catId = intval($catId);
    $cat = NewsCategories::GetById($catId);
    if ($cat != null)
    {
      $cat->delete();
    }

    Lib::Redirect('/admin/news/list/category/');
  }
}