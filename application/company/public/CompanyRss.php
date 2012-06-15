<?php
AutoLoader::Import('news.source.*');
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('library.texts.*');

class CompanyRss extends AbstractCommand implements ISettingable
{
  /**
   * Возвращает массив вида:
   * array('name1'=>array('DefaultValue', 'Description'),
   *       'name2'=>array('DefaultValue', 'Description'), ...)
   * @return array
   */
  public function GetSettingList()
  {
    return array('CountNewsInCompanyRss' => array(10, 'Количество новостей в rss компании.'));
  }

  /**
   * Основные действия комманды
   * @param int $companyId
   * @return void
   */
  protected function doExecute($companyId = 0)
  {
    $companyId = intval($companyId);
    if ($companyId == 0)
    {
      Lib::Redirect('/');
    }
    $company = Company::GetById($companyId);
    if (empty($company))
    {
      Lib::Redirect('/');
    }

    //$count = SettingManager::GetSetting('CountNewsInCompanyRss');
    $count = 10;
    $newslist = NewsPost::GetLastByCompany($count, 1, $companyId, array(), null, NewsPost::StatusDeleted);
    $titles = Registry::GetWord('titles');
    $title = sprintf($titles['company_rss'], $company->GetName());
    $link = RouteRegistry::GetUrl('company', '', 'show', array('companyid' => $companyId));

    NewsPost::GenerateFeed($title, $company->Info, $link,$newslist);
  }


}
