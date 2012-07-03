<?php
AutoLoader::Import('vote.source.*');

class ResearchVote extends GeneralCommand
{

  private static $Access = array(22636, 33313, 15769, 95983, 2216,
    13873, 14048, 8105, 9075, 8414, 13441, 2019,51488, 33313,
    337, 12959, 49465, 53517, 101542, 39948, 15648, 733, 35287, 454, 2889,
    14076, 19236,
    16670, 8110,
    15055, 1186, 4884, 13761, 1763, 2216, 51080, 1752, 2346, 17995, 5469, 15712, 14249, 10418, 9174, 611, 8110, 13441, 15053, 14049, 49844, 13463, 372, 879, 55266, 81628, 13583, 8894, 663, 15456, 18054, 96253, 29106, 21894, 1523, 44330, 11409, 33313, 1756, 22662, 924, 733, 12959, 337, 862, 15466, 323, 33695, 8958, 868, 50723, 7325, 12676, 82748, 12132, 15404, 14594, 56303, 9700, 36955, 15154, 29873, 16228, 29663, 115015, 96988, 32133, 51003, 13851, 115151, 55779, 30018, 109267, 50090, 2508, 1465, 9433, 112087, 50181, 99779, 21930, 1726, 93847, 28418, 13251, 595, 29188, 48571, 93547, 45455, 97711, 15675, 2728, 12314, 101573, 13494, 1108, 1107, 30743, 2718, 427, 94862, 11241, 115864, 115877, 29909, 36832, 115899, 14865, 19154, 31033, 20475, 85192, 52799, 84171, 2735, 99070, 17941, 1527, 436, 3415, 515, 19606, 33697, 81308, 14447, 40074, 29878, 11324, 14335, 92138, 1320, 40717, 106934, 111968, 21002, 104365, 113798, 85396, 50721, 15014, 102560, 35136, 19993, 37327, 9113, 2337, 49570, 14908, 95895, 95066, 96175, 1827, 30589, 116127, 37180, 42622, 17527, 115834, 5553, 14048, 13671, 30926, 37244, 50947, 34213, 34251, 111283, 37064, 30116, 101629, 52720, 13100, 1222, 676, 96337, 17206, 55054, 1201, 36998, 100544, 82259, 52895, 30621, 13876, 575, 13916, 18242, 49714, 84001, 29922, 54759, 14444, 100380, 20459, 6421, 91394, 16846, 92910, 116366, 97143, 49335, 15088, 115249, 115418, 29174, 90922, 29836, 116439, 382, 37297, 105937, 2721, 116509, 527, 29880, 34502, 40139, 10390, 101876, 34430, 116540, 104880, 84873, 96936, 54867, 35587, 86757, 56083, 29670, 96504, 29984, 102807, 44781, 55511, 84138, 7312, 111315, 97422, 116678, 1395, 34520, 108655, 9103, 86646, 28228, 106025, 53680, 93534, 43926, 49932, 91535, 19160, 115462, 106982, 49089, 113680, 54453, 81722, 90923, 14287, 116862, 116863, 116867, 97773, 116906, 116786, 33396, 113995, 81563, 84091, 16493, 80829, 17024, 116759, 53456, 2404, 1311, 82563, 50702, 107201, 106603, 30330, 51088, 8891, 15606, 32982, 4180, 45848, 52777, 93535, 33573, 107648, 117045, 13950, 106376, 23856, 113884, 117066, 109204, 85752, 2570, 105029, 107766, 96582, 117081, 45227, 117088, 29458, 49753, 20546, 116998, 115038, 116826, 16344, 100865, 14250, 105990, 97446, 96854, 106385, 9698, 97683, 29917, 49796, 17907, 13062, 31996, 98300, 117195, 54199, 97308, 116560, 53546, 97444, 117218, 85418, 2574, 31259, 12795, 117247, 98808, 95906, 106849, 117281, 97532, 35155, 54556, 49760, 93621, 3768, 866, 9548, 117362, 93737, 117376, 13931, 94026, 30095, 106920, 9102, 22684, 13898, 86190, 105684, 86684, 17697, 28105, 41363, 110702, 117557, 86283, 35565, 85151, 18357, 29662, 117762, 117792, 115361, 35816, 117813, 10434, 117725, 50562, 117618, 35079, 14649, 14220, 96334, 32622, 117961, 96899, 1719, 42547, 51303, 118040, 118078, 29514, 117844, 118091, 19711, 40132, 108013, 118157, 13424, 51488, 32264, 96377, 56172, 117293, 107139, 118176, 51228, 118218, 40557, 29776, 45792, 51507, 117913, 43695, 18593, 30203, 430, 28837, 118253, 99037, 55110, 56519, 40201, 117389, 30859, 105013, 118124, 86638, 118293, 117674, 118085, 31420, 30012, 37946, 16939, 81886, 53354, 8288, 9432, 118312, 118324, 28176, 118317, 51523, 7324, 29963, 85221, 51037, 118338, 118344, 29665, 34622, 118449, 95102, 30024, 34620, 51577, 33273, 118348, 118349, 118352, 834, 55620, 118601, 118586, 7702, 5403, 78984, 105929, 81501, 9701, 118661, 97611, 12814, 118036, 118082, 1085, 95246, 118678, 118674, 50845, 115212, 118694, 118690, 14852, 118691, 116507, 118693, 118708, 118725, 9107, 95983, 18028, 12244, 118764, 92160, 118728, 108469, 118824, 49610, 118850, 8861, 118722, 118720, 17171, 18350, 37375, 22063, 114072, 118819, 14064, 118777, 54788, 32920, 42061, 118842, 118738, 118925, 118916, 118919, 118921, 118923, 118924, 118679, 118840, 91852, 118843, 105732, 118845, 83203, 99294, 91308, 42775, 3271, 13941, 118968, 21977, 119100, 119104, 119099, 119150, 12781, 96259, 104298, 119238, 119245, 119239, 119253, 119257, 53843, 119270, 119445, 14072
  );

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