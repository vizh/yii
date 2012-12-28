<?php
namespace event\widgets;
class Comments extends \event\components\Widget
{
  public $position = \event\components\WidgetPosition::Content;
  public function widgetName()
  {
    return \Yii::t('app', 'Комментарии');
  }
  
  public function run()
  {
    $this->render('comments', array());
  }
}

?>
