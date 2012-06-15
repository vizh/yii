<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.user.*');

class UtilityCheck extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $criteria = new CDbCriteria();
    $criteria->addCondition('t.Paid = :Paid');
    $criteria->addInCondition('t.ProductId', array(688, 689));
    $criteria->params[':Paid'] = 1;

    /** @var $items OrderItem[] */
    $items = OrderItem::model()->findAll($criteria);

    echo 'All Count: ' . sizeof($items) . '<br><br>';
    echo '<table>';
    foreach ($items as $item)
    {
      echo '<tr>';
      $eventUser = $item->Owner->EventUsers(array('on' => 'EventUsers.EventId = :EventId', 'params' => array(':EventId' => 258)));

      $this->printTd($item->Owner->RocId);
      $this->printTd($item->Owner->GetFullName());

      $primary = $item->Owner->EmploymentPrimary();
      if (!empty($primary))
      {
        $this->printTd('<strong>' . $primary->Company->Name . '</strong>, ' . $primary->Position);
      }
      else
      {
        $this->printTd('не указана');
      }

      if (!empty($eventUser))
      {
        if ($item->ProductId == 688)
        {
          $this->printTd('Бизнес-участие 1');
        }
        else
        {
          $this->printTd('Бизнес-участие 2');
        }
      }
      else
      {
        $this->printTd('error');
      }
      echo '</tr>';
    }
    echo '</table>';
  }

  private function printTd($text)
  {
    echo '<td>' . $text . '</td>';
  }
}
