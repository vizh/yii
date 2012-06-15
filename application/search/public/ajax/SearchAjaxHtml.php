<?php
AutoLoader::Import('search.public.*');

class SearchAjaxHtml extends AjaxNonAuthCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $searchQuery = Registry::GetRequestVar('q');
    $searchQuery = trim($searchQuery);
    $searchQuery = mb_strtolower($searchQuery, 'utf-8');

    //$searchQuery = 'медиа';

    $this->counts = array(SearchIndex::ResultCompany => null, SearchIndex::ResultUser => null,
                          SearchIndex::ResultNews => null, );

    $companies = Company::GetBySearch($searchQuery, 3, 1, true);
    $this->counts[SearchIndex::ResultCompany] = Company::$GetBySearchCount;

    $users = User::GetBySearch($searchQuery, 3, 1, true);
    $this->counts[SearchIndex::ResultUser] = User::$GetBySearchCount;

    $news = NewsPost::GetBySearch($searchQuery, 3, 1, true);
    $this->counts[SearchIndex::ResultNews] = NewsPost::$GetBySearchCount;

    $sum = 0;
    foreach ($this->counts as $value)
    {
      $sum += $value;
    }

    if ($sum == 0)
    {
      $this->view->SetTemplate('empty');
    }
    else
    {
      $count = 0;
      $i = 0;
      while ($count < 3 && (isset($companies[$i]) || isset($users[$i])))
      {
        if (isset($companies[$i]))
        {
          $this->view->Companies .= $this->getCompanyHtml($companies[$i]);
          $count++;
          if ($count == 3) break;
        }
        if (isset($users[$i]))
        {
          $this->view->Users .= $this->getUserHtml($users[$i]);
          $count++;
          if ($count == 3) break;
        }
//        if (isset($news[$i]))
//        {
//          $this->view->News .= $this->getNewsHtml($news[$i]);
//          $count++;
//          if ($count == 3) break;
//        }
        $i++;
      }
      $this->view->Query = $searchQuery;
      $this->view->Counts = $this->counts;
    }

    $result['data'] = $this->view->__toString();
    $result['number'] = Registry::GetRequestVar('n');
    echo json_encode($result);
  }

  /**
   * @param Company $company
   * @return View
   */
  private function getCompanyHtml($company)
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

    return $view;
  }

  /**
   * @param User $user
   * @return View
   */
  private function getUserHtml($user)
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

    return $view;
  }

  /**
   * @param NewsPost $news
   * @return View
   */
  private function getNewsHtml($news)
  {
    $view = new View();
    $view->SetTemplate('news');

    $view->Link = $news->GetLink();
    $view->Title = $news->Title;
    $view->Date = getdate(strtotime($news->PostDate));

    return $view;
  }
}
 
