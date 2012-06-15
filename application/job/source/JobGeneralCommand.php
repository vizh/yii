<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 19.07.11
 * Time: 17:17
 * To change this template use File | Settings | File Templates.
 */
 
abstract class JobGeneralCommand extends GeneralCommand
{
  protected function preExecute()
  {
    parent::preExecute();
    $this->view->PartnerBanner = $this->getPartnerBannerhtml();
  }

  private function getPartnerBannerhtml()
  {
    $view = new View();
    $view->SetTemplate('banner', 'job', 'banner', '', 'public');
    return $view;
  }

  /**
   * @param JobTest $jobTest
   * @return string
   */
  protected function getJobTestPartnerBannerHtml($jobTest = null)
  {
    if (!empty($jobTest) && file_exists($jobTest->GetPartnerLogo(true)))
    {
      $view = new View();
      $view->SetTemplate('test', 'job', 'banner', '', 'public');
      $view->ImageUrl = $jobTest->GetPartnerLogo();
      $view->Title = $jobTest->PartnerTitle;
      $view->Url = $jobTest->PartnerUrl;
      return $view;
    }
    return '';
  }
}
