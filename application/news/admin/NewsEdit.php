<?php
AutoLoader::Import('news.source.*');
AutoLoader::Import('library.graphics.*');
AutoLoader::Import('library.texts.*');
 
class NewsEdit extends AdminCommand
{
  protected function preExecute()
  {
    parent::preExecute();
    
    $this->view->HeadScript(array('src'=>'/js/libs/jquery-ui-1.8.16.custom.min.js'));
    $this->view->HeadLink(array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/blitzer/jquery-ui-1.8.16.custom.css'));

    $this->view->HeadScript(array('src'=>'/js/admin/news.edit.js'));
  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($newsPostId = '')
  {
    $newsPostId = intval($newsPostId);
    $news = NewsPost::GetById($newsPostId);
    if ($news == null)
    {
      Lib::Redirect('/admin/news/list/');
    }

    $newsId = Registry::GetRequestVar('news_post_id');
    if (! empty($newsId) && $newsId == $newsPostId)
    {
      $data = Registry::GetRequestVar('data');
      $data['title'] = trim($data['title']);
      $words = Registry::GetWord('news');
      $data['title'] = $data['title'] !== $words['entertitle'] ? $data['title'] : '';

      $news->Title = $data['title'];
      $news->Name = trim($data['name']);
      if (empty($news->Name))
      {
        $news->Name = Texts::CyrToLatTitle($news->Title);
      }
      $news->PostDate = date('Y-m-d H:i',
                             mktime($data['h'], $data['min'], 0, $data['month'], $data['day'], $data['year']));
      $news->Quote = $data['quote'];
      $news->Content = $data['content'];
      $news->Status = $data['status'];
      $news->InMainTape = isset($data['in_main_tape']) ? 1 : 0;
      $news->NewsCategoryId = $data['category'];

      $news->MaterialType = !empty($data['MaterialType']) ? mb_substr($data['MaterialType'], 0, min(mb_strlen($data['MaterialType']), 30)) : '';
      $news->Copyright = $data['Copyright'];




      $this->saveTapeImage($news);
      $this->saveUser($news, $data['rocid']);

      if ((empty($news->Title) || empty($news->Content)) && $news->Status == 'publish')
      {
        $news->Status == 'draft';
      }

      $news->save();

      $categories = isset($data['second_category']) ? $data['second_category'] : array();
      $news->ParseCategories($categories);
    }

    if (! empty($news->Author))
    {
      $this->view->RocId = $news->Author->RocId;
    }

    $this->view->Categories = NewsCategories::GetAll(true);

    $this->view->NewsPostId = $news->NewsPostId;
    $this->view->NewsMainCategoryId = $news->NewsCategoryId;

    $categories = $news->Categories(array('condition' => '1=1'));
    $catIds = array();
    foreach ($categories as $category)
    {
      $catIds[] = $category->NewsCategoryId;
    }
    $this->view->NewsCategories = $catIds;
    $this->view->Title = $news->Title;
    $this->view->Name = $news->Name;
    $this->view->Date = getdate(strtotime($news->PostDate));
    $this->view->Quote = $news->Quote;
    $this->view->NewsContent = $news->Content;
    $this->view->MaterialType = $news->MaterialType;
    $this->view->Copyright = $news->Copyright;
    $this->view->Status = $news->Status;
    $this->view->FromRss = !empty($news->LinkFromRss);
    $this->view->Companies = $this->getCompaniesHtml($news);

    $this->view->InMainTape = $news->InMainTape;

    if (file_exists($news->GetMainTapeImage(true)))
    {
      $this->view->TapeImage = $news->GetMainTapeImage();
    }
    if (file_exists($news->GetMainTapeImageBig(true)))
    {
      $this->view->TapeImageBig = $news->GetMainTapeImageBig();
    }
    echo $this->view;
  }

  /**
   * @param NewsPost $news
   * @return void
   */
  private function saveTapeImage($news)
  {
    if ($_FILES['tape_image']['error'] == UPLOAD_ERR_OK)
    {
      $path = $news->GetMainTapeDir(true);
      if (! is_dir($path))
      {
        mkdir($path);
      }
      $namePrefix = $news->NewsPostId;
      $clearSaveTo = $path . $namePrefix . '_clear.jpg';
      Graphics::SaveImageFromPost('tape_image', $clearSaveTo);
      $newImage = $path . $namePrefix . '_200.jpg';
      Graphics::ResizeAndSave($clearSaveTo, $newImage, 200, 130, array('x1'=>0, 'y1'=>0));
      $newImage = $path . $namePrefix . '_440.jpg';
      Graphics::ResizeAndSave($clearSaveTo, $newImage, 440, 285, array('x1'=>0, 'y1'=>0));
    }
  }

  /**
   * @param NewsPost $news
   * @return void
   */
  private function getCompaniesHtml($news)
  {
    $companies = $news->Companies;
    $result = '';
    foreach ($companies as $company)
    {
      $view = new View();
      $view->SetTemplate('company');
      $view->Id = $company->CompanyId;
      $view->Name = $company->GetName();
      $result .= $view;
    }
    return $result;
  }

  /**
   * @param NewsPost $news
   * @param string $rocID
   * @return void
   */
  private function saveUser($news, $rocID)
  {
    $rocID = intval(trim($rocID));
    if (empty($rocID))
    {
      $news->UserId = null;
    }
    else
    {
      $user = User::GetByRocid($rocID);
      if (! empty($user))
      {
        $news->UserId = $user->UserId;
      }
      else
      {
        $news->UserId = null;
      }
    }
  }
}
