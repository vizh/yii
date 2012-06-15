<?php
AutoLoader::Import('news.source.*');
AutoLoader::Import('library.texts.*');
 
class NewsCategoryEdit extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($catId = '')
  {
    $catId = intval($catId);
    $cat = NewsCategories::GetById($catId);
    if ($cat == null)
    {
      Lib::Redirect('/admin/news/list/category/');
    }

    $catPostId = Registry::GetRequestVar('cat_post_id');
    if (! empty($catPostId) && $catPostId == $catId)
    {
      $data = Registry::GetRequestVar('data');
      //print_r($data);
      $cat->Title = trim($data['title']);
      $cat->Name = trim($data['name']);
      if (empty($cat->Name))
      {
        $cat->Name = Texts::CyrToLatTitle($cat->Title);
      }

      $cat->save();
    }

    $this->view->NewsCategoryId = $cat->NewsCategoryId;
    $this->view->Title = $cat->Title;
    $this->view->Name = $cat->Name;

    echo $this->view;
  }
}