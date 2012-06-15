<?php
AutoLoader::Import('news.source.*');
AutoLoader::Import('library.rocid.company.*');
 
class NewsCompanyAdd extends AjaxAdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $result['error'] = true;

    $newsPostId = intval(Registry::GetRequestVar('NewsId'));
    $companyId = intval(Registry::GetRequestVar('CompanyId'));

    $news = NewsPost::GetById($newsPostId);
    $company = Company::GetById($companyId);
    if ($news != null && $company != null)
    {
      $news->AddCompany($company);
      $result['error'] = false;
    }
    echo json_encode($result);
  }
}
