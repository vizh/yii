<?php
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('library.rocid.activity.*');

class CompanyInterest extends GeneralCommand
{
  private static $actions = array('add', 'delete');

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($action = '', $companyId = '')
  {
    $companyId = intval($companyId);
    if ($this->LoginUser == null || ! in_array($action, self::$actions) || $companyId == 0)
    {
      Lib::Redirect('/');
    }
    $company = Company::GetById($companyId);
    if ($company == null)
    {
      Lib::Redirect('/');
    }
    if ($action == 'add')
    {
      $interest = UserInterestCompany::GetUserInterestCompany($this->LoginUser->UserId, $company->CompanyId);
      if ($interest == null)
      {
        $interest = new UserInterestCompany();
        $interest->UserId = $this->LoginUser->UserId;
        $interest->CompanyId = $company->CompanyId;
        $interest->save();
      }
    }
    else
    {
      $interest = UserInterestCompany::GetUserInterestCompany($this->LoginUser->UserId, $company->CompanyId);
      if ($interest != null)
      {
        $interest->delete();
      }
    }
    Lib::Redirect('/company/' . $companyId . '/');
  }
}