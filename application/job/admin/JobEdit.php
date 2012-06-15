<?php
AutoLoader::Import('job.source.*');
AutoLoader::Import('geo.source.*');
AutoLoader::Import('library.rocid.company.*');
 
class JobEdit extends AdminCommand
{

  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeadScript(array('src'=>'/js/libs/tiny_mce/tiny_mce.js'));
    $this->view->HeadScript(array('src'=>'/js/admin/job.edit.js'));

    $this->view->HeadScript(array('src'=>'/js/geodropdown.js'));
    $this->view->HeadScript(array('src'=>'/js/functions.js'));

    $this->view->HeadScript(array('src'=>'/js/libs/jquery-ui-1.8.16.custom.min.js'));
    $this->view->HeadLink(array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => '/css/blitzer/jquery-ui-1.8.16.custom.css'));
  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = '')
  {
    $id = intval($id);
    $vacancy = Vacancy::GetById($id);
    if ($vacancy == null)
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('job', '', 'stream'));
    }

    $vacancyId = Registry::GetRequestVar('vacancy_id');
    if (! empty($vacancyId) && $vacancyId == $vacancy->VacancyId)
    {
      $data = Registry::GetRequestVar('data');
      $data['title'] = trim($data['title']);
      $words = Registry::GetWord('news');
      $data['title'] = $data['title'] !== $words['entertitle'] ? $data['title'] : '';
      $vacancy->Title = $data['title'];
      $vacancy->Email = $data['email'];

      $vacancy->PublicationDate = date('Y-m-d H:i', mktime($data['h'], $data['min'], 0,
                                                                 $data['month'], $data['day'], $data['year']));
      $description = $data['description'];
      $purifier = new CHtmlPurifier();
      $purifier->options = array('HTML.AllowedElements' => array('p', 'ul', 'ol', 'li', 'strong', 'em'),
                                 'HTML.AllowedAttributes' => '');
      $description = $purifier->purify($description);
      $vacancy->Description = $description;

      $vacancy->DescriptionShort = $this->getDescriptionShort($description);

      $vacancy->Status = $data['status'];
      $vacancy->SalaryMin = intval($data['salary_min']);
      $vacancy->SalaryMax = intval($data['salary_max']);
      $vacancy->Schedule = $data['schedule'];

      $vacancy->CountryId = $data['country'];
      $vacancy->RegionId = $data['region'];
      $vacancy->CityId = $data['city'];

      $companyId = intval($data['companyId']);
      $company = Company::GetById($companyId);
      if (!empty($company) && !empty($data['companyName']))
      {
        $vacancy->CompanyId = $company->CompanyId;
      }
      else
      {
        $vacancy->CompanyId = null;
      }

      if (!empty($vacancy->SalaryMin) && !empty($vacancy->SalaryMax)
              && $vacancy->SalaryMin > $vacancy->SalaryMax)
      {
        $tmp = $vacancy->SalaryMin;
        $vacancy->SalaryMin = $vacancy->SalaryMax;
        $vacancy->SalaryMax = $tmp;
      }

      if ((empty($vacancy->Title) || empty($vacancy->Description))
          && $vacancy->Status == VacancyStream::StatusPublish)
      {
        $vacancy->Status == VacancyStream::StatusDraft;
      }

      $vacancy->save();
    }

    $this->view->VacancyId = $vacancy->VacancyId;
    $this->view->Title = $vacancy->Title;
    $this->view->Email = $vacancy->Email;
    $this->view->SalaryMin = empty($vacancy->SalaryMin) ? '' : $vacancy->SalaryMin;
    $this->view->SalaryMax = empty($vacancy->SalaryMax) ? '' : $vacancy->SalaryMax;
    $this->view->Date = getdate(strtotime($vacancy->PublicationDate));
    if (empty($vacancy->Description))
    {
      $view = new View();
      $view->SetTemplate('default-description');
      $this->view->Description = $view;
    }
    else
    {
      $this->view->Description = $vacancy->Description;
    }
    $this->view->Schedule = $vacancy->Schedule;
    $this->view->CountryId = $vacancy->CountryId;
    $this->view->RegionId = $vacancy->RegionId;
    $this->view->CityId = $vacancy->CityId;
    $this->view->Status = $vacancy->Status;

    $this->view->JobTest = $vacancy->JobTest;
    if (! empty($vacancy->Company))
    {
      $this->view->CompanyId = $vacancy->Company->CompanyId;
      $this->view->CompanyName = $vacancy->Company->Name;
    }


    echo $this->view;
  }

  /**
   * @param string $description
   * @return string
   */
  private function getDescriptionShort($description)
  {
    $descriptionParts = preg_split('/\<[^>]*\>/', trim($description), -1, PREG_SPLIT_NO_EMPTY );
    $parts = array();
    foreach ($descriptionParts as $value)
    {
      $value = trim($value);
      if (!empty($value))
      {
        $parts[] = $value;
      }
    }
    $maxSize = 100;
    $string = '';
    $result = array();
    foreach ($parts as $part)
    {
      if (mb_strlen($string, 'utf-8') < $maxSize)
      {
        $string .= $part;
        $result[] = $part;
      }
      else
      {
        $result[] = trim($part, '.') . '...';
        break;
      }
    }
    $view = new View();
    $view->SetTemplate('description-short', 'job', '', 'edit', 'admin');
    $view->Parts = $result;
    return (string) $view;
  }
}
