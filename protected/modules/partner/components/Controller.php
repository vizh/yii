<?php
namespace partner\components;


class Controller extends \application\components\controllers\BaseController
{
  public $layout = '/layouts/public';

    public $showMenu = true;

  public function filters()
  {
    $filters = parent::filters();
    return array_merge(
      $filters,
      array(
        'accessControl'
      )
    );
  }

  /** @var AccessControlFilter */
  private $accessFilter;
  public function getAccessFilter()
  {
    if (empty($this->accessFilter))
    {
      $this->accessFilter = new AccessControlFilter();
      $this->accessFilter->setRules($this->accessRules());
    }
    return $this->accessFilter;
  }

  public function filterAccessControl($filterChain)
  {
    $this->getAccessFilter()->filter($filterChain);
  }

  public function accessRules()
  {
    $rules = \Yii::getPathOfAlias('partner.rules').'.php';
    return require($rules);
  }

  public function initResources()
  {
    \Yii::app()->getClientScript()->registerPackage('runetid.partner');
    parent::initResources();
  }

  protected function beforeAction($action)
  {
    if (\Yii::app()->partner->getAccount() !==null && $this->getId() !== 'auth')
    {
      if (\Yii::app()->user->getIsGuest())
      {
        \Yii::app()->getClientScript()->registerPackage('runetid.auth');
        $this->render('partner.views.system.need-user-auth');
        return false;
      }
      elseif (\Yii::app()->partner->getEvent() === null)
      {
        $success = $this->parseExtendedAccountRequest();
        if ($success)
        {
          $this->refresh();
        }
        else
        {
          $this->render('partner.views.system.select-event', array(
            'dataEvents' => $this->getExtendedAccountEventData()
          ));
          return false;
        }
      }
    }

    return parent::beforeAction($action);
  }

  private function parseExtendedAccountRequest()
  {
    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      $eventId = $request->getParam('eventId');
      if ($eventId !== null)
      {
        /** @var \event\models\Event $event */
        $event = \event\models\Event::model()->findByPk($eventId);
        if ($event !== null)
        {
          \Yii::app()->getSession()->add('PartnerAccountEventId', $event->Id);
          return true;
        }
      }
    }
    return false;
  }

  private function getExtendedAccountEventData()
  {
    /** @var \event\models\Event[] $events */
    $events = \event\models\Event::model()->byDeleted(false)->findAll();
    $dataEvents = array();
    foreach ($events as $event)
    {
      $item = new \stdClass();
      $item->value = $event->Id . ', ' . $event->IdName . ', ' . \application\components\utility\Texts::cropText($event->Title, 200);
      $item->id = $event->Id;
      $dataEvents[] = $item;
    }
    return $dataEvents;
  }

  protected $bottomMenu = array();
  protected function initBottomMenu() {}

  public function initActiveBottomMenu($active)
  {
    $this->initBottomMenu();
    foreach ($this->bottomMenu as $key => $value)
    {
      $this->bottomMenu[$key]['Active'] = ($key == $active);
    }
  }

  public function getBottomMenu()
  {
    return $this->bottomMenu;
  }
}