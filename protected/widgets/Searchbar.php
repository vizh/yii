<?php
namespace application\widgets;

class Searchbar extends \CWidget
{
  public function run()
  {
    $value = \Yii::app()->getRequest()->getQuery('term');
    $this->render('searchbar',
      array(
        'value' => $value
      )
    );
  }
}
