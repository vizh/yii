<?php
AutoLoader::Import('news.source.*');

class NewsCategoryAdd extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $cat = new NewsCategories();
    $cat->save();

    Lib::Redirect('/admin/news/category/edit/' . $cat->NewsCategoryId . '/');
  }
}
