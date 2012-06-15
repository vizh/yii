<?php
AutoLoader::Import('library.rocid.company.*');
AutoLoader::Import('news.source.*');

class CompanyEdit extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute($companyId = '')
  {
    $companyId = intval($companyId);
    $company = Company::GetById($companyId, Company::LoadContactInfo);
    if ($company == null)
    {
      Lib::Redirect('/admin/company/list/');
    }
    $action = Registry::GetRequestVar('action');
    $rss = NewsRss::GetRssByCompany($company->CompanyId);
    if (! empty($action))
    {
      $data = Registry::GetRequestVar('data');
      $rssLink = $data['rss'];
      if ($rss != null)
      {
        if (empty($rssLink))
        {
          $rss->delete();
        }
        else
        {
          $rss->Link = $rssLink;
          $rss->save();
        }
      }
      elseif (! empty($rssLink))
      {
        $rss = new NewsRss();
        $rss->Link = $rssLink;
        $rss->CompanyId = $company->CompanyId;
        $rss->save();
      }
    }

    $this->view->CompanyId = $company->CompanyId;
    if ($rss != null)
    {
      $this->view->RssLink = $rss->Link;
    }

    echo $this->view;
  }
}
