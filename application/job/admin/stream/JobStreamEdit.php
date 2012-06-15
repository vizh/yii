<?php
AutoLoader::Import('job.source.*');
 
class JobStreamEdit extends AdminCommand
{

  protected function preExecute()
  {
    parent::preExecute();

    $this->view->HeadScript(array('src'=>'/js/libs/tiny_mce/tiny_mce.js'));
    $this->view->HeadScript(array('src'=>'/js/admin/job.edit.js'));
  }

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($id = '')
  {
    $id = intval($id);
    $vacancyStream = VacancyStream::GetById($id);
    if ($vacancyStream == null)
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('job', '', 'stream'));
    }

    $vacancyId = Registry::GetRequestVar('vacancy_stream_id');
    if (! empty($vacancyId) && $vacancyId == $vacancyStream->VacancyStreamId)
    {
      $data = Registry::GetRequestVar('data');
      $data['title'] = trim($data['title']);
      $words = Registry::GetWord('news');
      $data['title'] = $data['title'] !== $words['entertitle'] ? $data['title'] : '';

      $vacancyStream->Title = $data['title'];

      $vacancyStream->PublicationDate = date('Y-m-d H:i', mktime($data['h'], $data['min'], 0,
                                                                 $data['month'], $data['day'], $data['year']));
      $description = $data['description'];
      $purifier = new CHtmlPurifier();
      $purifier->options = array('HTML.AllowedElements' => array('p', 'ul', 'ol', 'li', 'strong', 'em'),
                                 'HTML.AllowedAttributes' => '', 'AutoFormat.AutoParagraph' => true);
      $description = $purifier->purify($description);
      $vacancyStream->Description = $description;
      $vacancyStream->DescriptionShort = $this->getDescriptionShort($vacancyStream->Description);
      $vacancyStream->Status = $data['status'];
      $vacancyStream->Link = $data['link'];
      $vacancyStream->SalaryMin = intval($data['salary_min']);
      $vacancyStream->SalaryMax = intval($data['salary_max']);

      if (!empty($vacancyStream->SalaryMin) && !empty($vacancyStream->SalaryMax)
              && $vacancyStream->SalaryMin > $vacancyStream->SalaryMax)
      {
        $tmp = $vacancyStream->SalaryMin;
        $vacancyStream->SalaryMin = $vacancyStream->SalaryMax;
        $vacancyStream->SalaryMax = $tmp;
      }

      if ((empty($vacancyStream->Title) || empty($vacancyStream->Description) || empty($vacancyStream->Link) )
          && $vacancyStream->Status == VacancyStream::StatusPublish)
      {
        $vacancyStream->Status == VacancyStream::StatusDraft;
      }

      $vacancyStream->save();
    }


    $this->view->VacancyStreamId = $vacancyStream->VacancyStreamId;
    $this->view->Title = $vacancyStream->Title;
    $this->view->Link = $vacancyStream->Link;
    $this->view->SalaryMin = empty($vacancyStream->SalaryMin) ? '' : $vacancyStream->SalaryMin;
    $this->view->SalaryMax = empty($vacancyStream->SalaryMax) ? '' : $vacancyStream->SalaryMax;
    $this->view->Date = getdate(strtotime($vacancyStream->PublicationDate));
    $this->view->Description = $vacancyStream->Description;
    $this->view->Status = $vacancyStream->Status;

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
