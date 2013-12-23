<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 20.12.13
 * Time: 13:43
 */

namespace event\widgets\panels;


class Base extends \event\components\WidgetAdminPanel
{
  private $form;
  private $showForm = true;

  public function __construct($widget)
  {
    parent::__construct($widget);
    $attributes = $this->getWidget()->getAttributeNames();
    $this->form = new \event\models\forms\widgets\Base();
    if (!empty($attributes))
    {
      foreach ($attributes as $attr)
      {
        $this->form->Attributes[$attr] = isset($this->getWidget()->$attr) ? $this->getWidget()->$attr : '';
      }
    }
    else
    {
      $this->showForm = false;
      $this->addError(\Yii::t('app', 'У виджета нет настроек.'));
    }
  }


  public function process()
  {
    $request = \Yii::app()->getRequest();
    $this->form->attributes = $request->getParam(get_class($this->form));
    if ($this->showForm && $this->form->validate())
    {
      foreach($this->getWidget()->getAttributeNames() as $attr)
      {
        $this->getWidget()->$attr = isset($this->form->Attributes[$attr]) ? $this->form->Attributes[$attr] : '';
      }
      $this->setSuccess(\Yii::t('app', 'Настройки виджета успешно сохранены'));
      return true;
    }
    $this->addError($this->form->getErrors());
    return false;
  }

  function render()
  {
    return $this->renderView(['form' => $this->form, 'showForm' => $this->showForm]);
  }
}