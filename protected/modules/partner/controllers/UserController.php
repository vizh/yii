<?php


class UserController extends \partner\components\Controller
{
  const UsersOnPage = 20;

  public function actions()
  {
    return array(
      'index' => '\partner\controllers\user\IndexAction',
      'edit' => '\partner\controllers\user\EditAction',
      'ajaxget' => '\partner\controllers\user\AjaxGetAction',
    );
  }

  public function initBottomMenu($active)
  {
    $this->bottomMenu = array(
      'index' => array(
        'Title' => 'Участники',
        'Url' => \Yii::app()->createUrl('/partner/user/index'),
        'Access' => $this->getAccessFilter()->checkAccess('user', 'index')
      ),
      'edit' => array(
        'Title' => 'Редактирование',
        'Url' => \Yii::app()->createUrl('/partner/user/edit'),
        'Access' => $this->getAccessFilter()->checkAccess('user', 'edit')
      ),
    );

    foreach ($this->bottomMenu as $key => $value)
    {
      $this->bottomMenu[$key]['Active'] = ($key == $active);
    }
  }
}
