<?php
abstract class AbstractCommand
{
  const DefaultCommandView = 'default';
  
  protected $view = null;
  
  /**
  * Конструктор
  * Создает объект View для команды
  */
  final public function __construct()
  {
    $routeRegistry = RouteRegistry::GetInstance();
    
    $module = strtolower($routeRegistry->GetModule());
    $section = strtolower($routeRegistry->GetSection());
    $command = strtolower($routeRegistry->GetCommand());
    
//    $module = strtolower(Registry::GetRequestVar('module'));
//    $section = strtolower(Registry::GetRequestVar('section'));
//    $command = strtolower(Registry::GetRequestVar('command'));
    
    $this->view = new View();
    $this->view->SetTemplate($command, $module, $command, $section);
    $this->view->UseLayout(true);

    Registry::SetVariable('MainView', $this->view);
  }
  
  /**
  * Исполняет комманду
  * @return void
  */
  public function execute()
  {    
    $this->preExecute();
    $this->callExecute();
    $this->postExecute();      
  }

  protected final function callExecute()
  {
    $routeRegistry = RouteRegistry::GetInstance();
    $params = $routeRegistry->GetParams();
    call_user_func_array(array($this, 'doExecute'), $params);
  }
  
  /**
  * Выполняется перед основными действиями комманды
  * @return void
  */
  protected function preExecute()
  {
    
  }
  /**
  * Основные действия комманды
  * @return void
  */
  protected abstract function doExecute();
  /**
  * Выполняется после основных действий комманды
  * @return void  
  */
  protected function postExecute()
  {
    
  }
  
  protected function SetTitle($title)
  {
    $this->view->Title = $title;
  }

  /** @var ViewContainer */
  private $errorNotices = null;
  public function AddErrorNotice($message, $description = '', $color = 'red')
  {
    if ($this->errorNotices == null)
    {
      $this->errorNotices = new ViewContainer();
    }
    $view = $this->GetErrorNotice($message, $description, $color);

    $this->errorNotices->AddView($view);
    
    $this->view->ErrorNotices = $this->errorNotices;
  }

  public function GetErrorNotice($message, $description = '', $color = 'red')
  {
    $view = new View();
    $view->SetTemplate('notice', 'core', 'general', '', 'public');
    $view->Color = $color;
    $view->Message = $message;
    $view->Description = $description;

    return $view;
  }

  public function Send404AndExit()
  {
    header("Status: 404 Not Found");
    $this->view->SetLayout('error404');
    $this->view->SetTemplate('empty', 'core', 'error', '');
    echo $this->view;
    exit;
  }

  protected function getBanner()
  {
    $view = new View();
    $view->SetTemplate('swf', 'core', 'banner', '', 'public');
    $view->HideSocial = RouteRegistry::GetInstance()->GetModule() == 'job';
    $view->ShowSmi2 = RouteRegistry::GetInstance()->GetModule() == 'job' ||
      (RouteRegistry::GetInstance()->GetModule() == 'main' && RouteRegistry::GetInstance()->GetCommand() == 'index');
    return $view;
  }

  /**
   * @return View|null
   */
  public function View()
  {
    return $this->view;
  }
}
