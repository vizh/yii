<?php
AutoLoader::Import('comission.source.*');

class ComissionEdit extends AdminCommand
{
  /**
   * Основные действия комманды
   * @param int $id
   * @return void
   */
  protected function doExecute($id = 0)
  {
    $id = intval($id);
    $comission = Comission::GetById($id);

    if (empty($comission) && empty($id))
    {
      $comission = new Comission();
    }
    elseif (empty($comission) && !empty($id))
    {
      Lib::Redirect(RouteRegistry::GetAdminUrl('comission', '', 'index'));
    }

    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $data = Registry::GetRequestVar('Comission');
      $purifier = new CHtmlPurifier();
      $purifier->options = array();

      $comission->Title = $purifier->purify($data['Title']);
      $comission->Description = $purifier->purify($data['Description']);
      $comission->Url = $purifier->purify($data['Url']);
      if ($comission->getIsNewRecord())
      {
        $comission->CreationTime = time();
      }
      $comission->save();

      Lib::Redirect(RouteRegistry::GetAdminUrl('comission', '', 'index'));
    }

    $this->view->Comission = $comission;
    echo $this->view;
  }
}
