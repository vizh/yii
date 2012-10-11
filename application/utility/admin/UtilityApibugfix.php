<?php
AutoLoader::Import('library.rocid.api.*');
class UtilityApibugfix extends AdminCommand
{
  private $itemsOnPage = 100;
  
  protected function doExecute() 
  {
    return;
    $countSafe = Registry::GetRequestVar('countSafe', 0);
    $countNotFound = Registry::GetRequestVar('countNotFound', 0); 
    $countHaveJob = Registry::GetRequestVar('countHaveJob', 0);
    
    $criteria = new CDbCriteria();
    $criteria->addSearchCondition('t.Target', 'create');
    $criteria->addSearchCondition('t.Request', 'postion');    
    $criteria->limit  = $this->itemsOnPage;
    $criteria->order  = 't.LogId ASC';
    $apiLogs = \ApiLog::model()->findAll($criteria);
    foreach ($apiLogs as $apiLog)
    {
      $request = unserialize($apiLog->Request);
      $user = User::GetByEmail($request['Email'], array('Employments'));
      if ($user !== null)
      {
        $employment = $user->GetEmployments();
        if ($employment == null)
        {
          if (!empty($request['Company']))
          {
            $this->addEmployment($user, $request['Company'], $request['Postion']);
            $countSafe++;
          }
          else
          {
            echo 'LogId: '. $apiLog->LogId .', поле не заполнено<br/>';
          }
        }
        else
        {
          echo 'LogId: '. $apiLog->LogId .', у пользователя уже есть работа<br/>';
          $countHaveJob++;
        }
      }
      else
      {
        echo 'LogId:' . $apiLog->LogId . ', пользователь не найден <br/>';
        $countNotFound++;
      }
      
      $apiLog->Request = str_replace('Postion', 'PositionBug', $apiLog->Request);
      $apiLog->save();
    }
    
    if (sizeof($apiLogs) > 0)
    {
      $redirectUrl = RouteRegistry::GetUrl('admin', 'utility', 'apibugfix').'?countSafe='.$countSafe.'&countNotFound='.$countNotFound.'&countHaveJob='.$countHaveJob;
      echo '<meta http-equiv="refresh" content="3; url='.$redirectUrl.'">';
    }
    else
    {
      echo 'Готово';
    }
  }
  
  /**
   * @param User $user
   */
  private function addEmployment($user, $companyName, $position = '')
  {
    if (!empty($companyName))
    {
      $companyInfo = Company::ParseName($companyName);

      $company = Company::GetCompanyByName($companyInfo['name']);
      if (empty($company))
      {
        $company = new Company();
        $company->Name = $companyInfo['name'];
        $company->Opf = $companyInfo['opf'];
        $company->CreationTime = time();
        $company->UpdateTime = time();
        $company->save();
      }

      $employment = new UserEmployment();
      $employment->UserId = $user->UserId;
      $employment->CompanyId = $company->CompanyId;
      $employment->SetParsedStartWorking(array('year' => '9999'));
      $employment->SetParsedFinishWorking(array('year' => '9999'));
      $employment->Position = $position;
      $employment->Primary = 1;
      $employment->save();
    }
  }
}

?>
