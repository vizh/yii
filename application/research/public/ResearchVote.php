<?php
AutoLoader::Import('vote.source.*');

class ResearchVote extends GeneralCommand
{

  private static $Access = array();

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $this->view->HeadScript(array('src'=>'/js/vote.js'));
    $this->view->HeadScript(array('src'=>'/js/i-research.vote.js'));

    /** @var $vote Vote */
    $vote = Vote::model()->findByPk(2);
    if ($this->LoginUser!= null && in_array($this->LoginUser->RocId, self::$Access) && $vote->VoteManager()->CheckVoter())
    {
      $stepView = false;
      $flag = true;
      $reset = Registry::GetRequestVar('reset', null);
      if (!empty($reset))
      {
        $vote->VoteManager()->ResetVote();
        Lib::Redirect(RouteRegistry::GetUrl('research', '', 'vote'));
      }
      if ($vote->VoteManager()->InProgress())
      {
        $stepView = $vote->VoteManager()->NextStep();
      }
      else
      {
        if (Yii::app()->getRequest()->getIsPostRequest())
        {
          $start = Registry::GetRequestVar('start');
          $data = array();
          $errors = array();
          if (!empty($start))
          {
            $data = Registry::GetRequestVar('Data');
            $errors = array();
            if (!empty($data))
            {
              $names = preg_split('/ /', $data['Name'], -1, PREG_SPLIT_NO_EMPTY);
              if (sizeof($names) < 2)
              {
                $errors['Name'] = 'Введите полностью свои Фамилию, Имя, Отчество';
              }

              $data['Birthday'] = trim($data['Birthday']);
              if (empty($data['Birthday']))
              {
                $errors['Birthday'] = 'Дата рождения не может быть пустой';
              }
              elseif (preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $data['Birthday']) == 0)
              {
                $errors['Birthday'] = 'Не верный формат даты рождения';
              }

              $data['Company'] = trim($data['Company']);
              if (empty($data['Company']))
              {
                $errors['Company'] = 'Данное поле является обязательным для заполнения';
              }

              $data['Position'] = trim($data['Position']);
              if (empty($data['Position']))
              {
                $errors['Position'] = 'Данное поле является обязательным для заполнения';
              }


              if (empty($errors))
              {
                $purifier = new CHtmlPurifier();
                $purifier->options = array('HTML.AllowedElements' => '', 'HTML.AllowedAttributes' => '');

                $this->LoginUser->LastName = $purifier->purify($names[0]);
                $this->LoginUser->FirstName = $purifier->purify($names[1]);
                $this->LoginUser->FatherName = isset($names[2]) ? $purifier->purify($names[2]) : '';

                $dates = preg_split('/\./', $data['Birthday'], -1, PREG_SPLIT_NO_EMPTY);
                $this->LoginUser->SetParsedBirthday(array('day' => $dates[0], 'month' => $dates[1], 'year' => $dates[2]));

                $this->LoginUser->save();

                $employment = $this->LoginUser->EmploymentPrimary();
                if (empty($employment) || ($data['Company'] != $employment->Company->Name && $data['Position'] != $employment->Position))
                {
                  $company = Company::GetCompanyByName($data['Company']);
                  if (empty($company))
                  {
                    $company = new Company();
                    $company->Name = $purifier->purify($data['Company']);
                    $company->CreationTime = time();
                    $company->save();
                  }
                  $employment = new UserEmployment();
                  $employment->UserId = $this->LoginUser->UserId;
                  $employment->CompanyId = $company->CompanyId;
                  $employment->Position = $purifier->purify($data['Position']);
                  $employment->SetParsedStartWorking(array());
                  $employment->SetParsedFinishWorking(array());
                  $employment->save();
                }
              }
              else
              {
                $flag = false;
              }
            }
            else
            {
              $data['Name'] = $this->LoginUser->LastName . ' ' . $this->LoginUser->FirstName
                . (!empty($this->LoginUser->FatherName) ? ' ' . $this->LoginUser->FatherName : '');

              $birthday = $this->LoginUser->GetParsedBirthday();
              if (empty($birthday['day']) || empty($birthday['month']) || empty($birthday['year']))
              {
                $data['Birthday'] = '';
              }
              else
              {
                $data['Birthday'] = date('d.m.Y', strtotime($this->LoginUser->Birthday));
                /*(!empty($birthday['day']) ? $birthday['day'] : '') . '.'
           .  (!empty($birthday['month']) ? $birthday['month'] : '' ) . '.'
           . (!empty($birthday['year']) ? $birthday['year'] : '');*/
              }

              $employment = $this->LoginUser->EmploymentPrimary();
              if (!empty($employment))
              {
                $data['Company'] = $employment->Company->Name;
                $data['Position'] = $employment->Position;
              }
              else
              {
                $data['Company'] = '';
                $data['Position'] = '';
              }
              $flag = false;
            }
          }
          if ($flag)
          {
            $stepView = $vote->VoteManager()->NextStep();
          }
          else
          {
            $this->view->Data = $data;
            $this->view->Errors = $errors;
            $this->view->SetTemplate('pre-start');
          }
        }
      }

      if ($flag)
      {
        if ($stepView !== false)
        {
          if ($stepView !== null)
          {
            $this->view->Step = $stepView;
          }
          else
          {
            $vote->VoteManager()->FinishVote();
            $this->view->SetTemplate('end');
          }
        }
        else
        {
          $this->view->SetTemplate('start');
        }
      }
    }
    else
    {
      $this->view->SetTemplate('error');
    }

    echo $this->view;
  }
}