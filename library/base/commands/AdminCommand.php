<?php
AutoLoader::Import('library.rocid.user.User');

abstract class AdminCommand extends AuthCommand
{
  /**
  * 
  * @var User
  */
  protected $LoginUser = null;
  
  protected function preExecute()
  {
    parent::preExecute();
    
    header('Content-Type: text/html; charset=utf-8');

    $this->view->SetLayout('admin');
    $this->view->Menu = $this->getAdminMenuHtml();
    $this->view->SubMenu = $this->getAdminSubMenuHtml();

    if (empty($this->LoginUser) || !$this->checkAdminAccess())
    {
      $host = $_SERVER['HTTP_HOST'];
      echo '<p>Недостаточно прав для доступа! Авторизуйтесь под учетной записью администратора.</p> <br>
        <a href="http://' . $host . '/">Главная страница.</a>';
      exit;
    }
    elseif (!$this->LoginUser->CheckAccess())
    {
      $this->view->SetTemplate('deny', 'core', '', 'access', RouteRegistry::SectionDirAdmin);
      echo $this->view;
      exit;
    }

//    if ($this->LoginUser === null || ! $this->LoginUser->IsHaveAdminPermissions())
//    {
//      $host = $_SERVER['HTTP_HOST'];
//      echo '<p>Недостаточно прав для доступа! Авторизуйтесь под учетной записью имеющей доступ к разделу администратора.</p> <br>
//        <a href="http://' . $host . '/">Главная страница.</a>';
//      exit;
//    }
    

  }
  
  protected function postExecute()
  {
    if ($_SERVER['HTTP_HOST'] == 'beta.rocid' || $_SERVER['HTTP_HOST'] == 'pay.beta.rocid' || $this->LoginUser->RocId == 35287)
    {
      $logger = Yii::getLogger();
      $stats = Yii::app()->db->getStats();

      echo '<br/> SQL queries: ' . $stats[0] .
          '<br/> SQL Execution Time: ' . $stats[1] .
        '<br/> Full Execution Time: ' . $logger->getExecutionTime();

      $logs = $logger->getProfilingResults();

      echo '<pre>';
      print_r($logs);
      echo '</pre>';
    }
  }

  protected function getAdminMenuHtml()
  {
    $view = new View();
    $view->SetTemplate('menu', 'core', 'mainmenu', '');

    $items = StructureManager::Instance()->GetTopMenu(RouteRegistry::SectionDirAdmin);
    $menus = array();
    foreach ($items as $item)
    {
      $title = !empty($item->Title) ? $item->Title : $item->Name;
      $module = $item->Module;
      if (empty($item->Command) && $item->FirstChildId !== null)
      {
        $item = StructureManager::Instance()->GetItem($item->FirstChildId);
      }
      $menus[] = array('title' => $title, 'module' => $module,
                     'href' => RouteRegistry::GetAdminUrl($item->Module, $item->Section, $item->Command));
    }
    $view->Items = $menus;
    $view->Module = RouteRegistry::GetInstance()->GetModule();

    return $view;
  }

  protected function getAdminSubMenuHtml()
  {
    $view = new View();
    $view->SetTemplate('submenu', 'core', 'mainmenu', '');
    $subMenu = StructureManager::Instance()->GetSubMenu(RouteRegistry::GetInstance()->GetModule(),
                                                        RouteRegistry::SectionDirAdmin);
    $items = array();
    foreach ($subMenu as $item)
    {
      $title = !empty($item->Title) ? $item->Title : $item->Name;
      $items[] = array('title' => $title, 'fullname' => $item->Module.$item->Section.$item->Command,
                     'href' => RouteRegistry::GetAdminUrl($item->Module, $item->Section, $item->Command));
    }
    $view->Items = $items;
    $view->Active = RouteRegistry::GetInstance()->GetModule() .
      RouteRegistry::GetInstance()->GetSection() . RouteRegistry::GetInstance()->GetCommand();
    return $view;
  }
}