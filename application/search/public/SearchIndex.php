<?php
AutoLoader::Import('news.source.*');
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('library.texts.*');

class SearchIndex extends GeneralCommand implements ISettingable
{
  const ResultUser = 'u';
  const ResultCompany = 'c';
  const ResultNews = 'n';

  private $counts;


   /**
   * Возвращает массив вида:
   * array('name1'=>array('DefaultValue', 'Description'),
   *       'name2'=>array('DefaultValue', 'Description'), ...)
   */
  public function GetSettingList()
  {
    return array('SearchResultsPerPage' => array(10, 'Количество результатов поиска на страницу'));
  }

  protected function preExecute()
  {
    parent::preExecute();

  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $searchQuery = Registry::GetRequestVar('q');
    if ($searchQuery !== null)
    {
      if (mb_check_encoding($searchQuery, 'windows-1251') && ! mb_check_encoding($searchQuery, 'utf-8'))
      {
        $searchQuery = mb_convert_encoding($searchQuery, 'utf-8', 'windows-1251');
      }
      $searchQuery = trim($searchQuery);
    }
    if ($searchQuery !== null && empty($searchQuery))
    {
      Lib::Redirect('/search/');
    }
    $searchQuery = htmlspecialchars($searchQuery);
    $this->view->Query = $searchQuery;
    $titles = Registry::GetWord('titles');
    if (empty($searchQuery))
    {
      $this->SetTitle($titles['search']);
    }
    else
    {
      $this->SetTitle($titles['search'] . ' - ' . $searchQuery);
    }

    $searchQuery = mb_strtolower($searchQuery, 'utf-8');
    $this->counts = array(SearchIndex::ResultUser => null, SearchIndex::ResultCompany => null, SearchIndex::ResultNews => null, );
    if (! empty($searchQuery))
    {
      $searchPage = Registry::GetRequestVar('p');
      $searchPage = intval($searchPage);
      $searchPage = $searchPage < 1 ? 1 : $searchPage;

      $searchActive = Registry::GetRequestVar('a', SearchIndex::ResultUser);
      $searchActive = empty($searchActive) || !array_key_exists($searchActive, $this->counts) ?
          SearchIndex::ResultUser : $searchActive;

      $resultHtml = $this->getResultHtml($searchQuery, $searchPage, $searchActive);
      if (empty($resultHtml))
      {
        foreach ($this->counts as $key => $value)
        {
          if ($key != $searchActive)
          {
            $resultHtml = $this->getResultHtml($searchQuery, $searchPage, $key);
            if (! empty($resultHtml))
            {
              $searchActive = $key;
              break;
            }
          }
        }
      }

      $this->view->Result = $resultHtml;

      $resultsPerPage = SettingManager::GetSetting('SearchResultsPerPage');
      if ($this->counts[SearchIndex::ResultUser] == null)
      {
        User::GetBySearch($searchQuery, $resultsPerPage, $searchPage, true, true);
        $this->counts[SearchIndex::ResultUser] = User::$GetBySearchCount;
      }
      if ($this->counts[SearchIndex::ResultCompany] == null)
      {
        Company::GetBySearch($searchQuery, $resultsPerPage, $searchPage, true, true);
        $this->counts[SearchIndex::ResultCompany] = Company::$GetBySearchCount;
      }
      if ($this->counts[SearchIndex::ResultNews] == null)
      {
        NewsPost::GetBySearch($searchQuery, $resultsPerPage, $searchPage, true, true);
        $this->counts[SearchIndex::ResultNews] = NewsPost::$GetBySearchCount;
      }

      $this->view->AfterInput = $this->getAfterInputHtml($this->counts, $searchActive, $searchQuery);

      $url = '/search/?p=%s';
      $this->view->Paginator = new Paginator($url, $searchPage, $resultsPerPage,
        $this->counts[$searchActive], array('q'=>$searchQuery, 'a' => $searchActive));
    }


    
    echo $this->view;
  }

  private function getAfterInputHtml($counts, $active = SearchIndex::ResultCompany, $query)
  {
    $sum = 0;
    foreach ($counts as $value)
    {
      $sum += $value;
    }
    $view = new View();
    if ($sum != 0)
    {
      $view->SetTemplate('afterinput');
      $view->Counts = $counts;
      $view->Active = $active;
      $view->Query = $query;
    }
    else
    {
      $view->SetTemplate('empty');
    }

    return $view;
  }

  private function getResultHtml($query, $page, $active)
  {
    $resultsPerPage = SettingManager::GetSetting('SearchResultsPerPage');

    switch ($active)
    {
      case SearchIndex::ResultUser://поиск по компаниям
        $users = User::GetBySearch($query, $resultsPerPage, $page, true);
        $this->counts[SearchIndex::ResultUser] = User::$GetBySearchCount;
        return $this->getUsersResultHtml($users);

      case SearchIndex::ResultNews://поиск по новостям
        $news = NewsPost::GetBySearch($query, $resultsPerPage, $page, true);
        $this->counts[SearchIndex::ResultNews] = NewsPost::$GetBySearchCount;
        return $this->getNewsResultHtml($news);

      /*case '4':
      break;*/

      case SearchIndex::ResultCompany: //поиск по пользователям
      default: //дефолтный поиск
        $companies = Company::GetBySearch($query, $resultsPerPage, $page, true);
        $this->counts[SearchIndex::ResultCompany] = Company::$GetBySearchCount;
        return $this->getCompaniesResultHtml($companies);
    }
  }

  /**
   * @param Company[] $companies
   * @return string|ViewContainer
   */
  private function getCompaniesResultHtml($companies)
  {
    if (empty($companies))
    {
      return '';
    }
    
    $result = new ViewContainer();
    foreach ($companies as $company)
    {
      $view = new View();
      $view->SetTemplate('company');
      $view->Name = $company->GetName();
      $view->CompanyId = $company->CompanyId;
      $view->EmployersCount = sizeof($company->Users);

      $address = $company->GetAddress();
      if (!(empty($address)) && ! (empty($address->City)))
      {
        $view->City = $address->City->Name;
      }


      $result->AddView($view);
    }

    return $result;
  }

  /**
   * @param User[] $users
   * @return string|ViewContainer
   */
  private function getUsersResultHtml($users)
  {
    if (empty($users))
    {
      return '';
    }

    $result = new ViewContainer();
    foreach ($users as $user)
    {
      $view = new View();
      $view->SetTemplate('user');

      $view->FirstName = $user->FirstName;
      $view->LastName = $user->LastName;
      $view->RocId = $user->RocId;

      $employments = $user->GetEmployments();
      foreach ($employments as $employment)
      {
        if ($employment->Primary == 1)
        {
          $company = $employment->GetCompany();
          if (! empty($company))
          {
            $view->CompanyName = $company->GetName();
            $view->CompanyPosition = $employment->Position;
          }
          else
          {
            Lib::log('Message: Empty Company, but no empty employment.  Trace string: getUsersHtml in application/user/UserList.php ', CLogger::LEVEL_ERROR, 'application');
          }
          break;
        }
      }

      $result->AddView($view);
    }

    return $result;
  }

  /**
   * @param NewsPost[] $newslist
   * @return string|ViewContainer
   */
  private function getNewsResultHtml($newslist)
  {
    if (empty($newslist))
    {
      return '';
    }

    $result = new ViewContainer();
    foreach ($newslist as $news)
    {
      $view = new View();
      $view->SetTemplate('news');

      $view->Link = $news->GetLink();
      $view->Title = $news->Title;
      $view->Date = getdate(strtotime($news->PostDate));
      if (! empty($news->Quote))
      {
        $view->Quote = $news->Quote;
      }

      $result->AddView($view);
    }

    return $result;
  }


}

 
