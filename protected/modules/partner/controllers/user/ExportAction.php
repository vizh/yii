<?php
namespace partner\controllers\user;
class ExportAction extends \partner\components\Action 
{
  private $csvDelimiter = ';';
  private $csvCharset = 'utf8';

  private function rowHandler($row)
  {
    foreach ($row as &$item)
    {
      if ($this->csvCharset == 'Windows-1251')
      {
        $item = iconv('utf-8', 'Windows-1251', $item);
      }
      $item = str_replace($this->csvDelimiter, '', $item);
    }
    unset($item);
    return $row;
  }
  
  public function run()
  {
    if (\Yii::app()->request->getIsPostRequest())
    {
      ini_set("memory_limit", "512M");

      if (\Yii::app()->partner->getAccount()->EventId == 391)
      {
        \Yii::app()->language = 'en';
      }

      $this->csvCharset = \Yii::app()->request->getParam('charset', $this->csvCharset);
      header('Content-type: text/csv; charset='.$this->csvCharset);
      header('Content-Disposition: attachment; filename=participans.csv');
      $row = array(
        'ROCID',
        'Фамилия',
        'Имя',
        'Отчество',
        'Компания',
        'Должность',
        'Email',
        'Телефон',
        'Статус на мероприятии',
        'Cумма оплаты',
        'Дата регистрации на мероприятие',
        'Дата оплаты участия'
      );
      //todo: Переделать используя $fp = fopen('php://output', 'w'); и fputcsv
      echo implode($this->csvDelimiter, $this->rowHandler($row))."\r\n";


      $criteria = new \CDbCriteria();
      $criteria->with = array(
        'User',
        'User.Employments',
        'User.Settings',
        'User.Employments.Company',
        'Role',
        'User.Emails',
        'User.Phones'
      );
      $criteria->order = 't.CreationTime DESC';
      $participants = \event\models\Participant::model()->byEventId(\Yii::app()->partner->getAccount()->EventId)->findAll($criteria);
      foreach ($participants as $participant)
      {
        $row = array(
          'RocId' => $participant->User->RocId,
          'LastName' => $participant->User->LastName,
          'FirstName' => $participant->User->FirstName,
          'FatherName' => $participant->User->FatherName,
          'Company' => '',
          'Position' => '',
          'Email' => $participant->User->GetEmail() !== null ? $participant->User->GetEmail()->Email : '',
          'Phone' => !empty($participant->User->Phones) ? $participant->User->Phones[0]->Phone : '',
          'Role' => $participant->Role->Name,
          'Price' => '',
          'DateRegister' => \Yii::app()->dateFormatter->format('dd MMMM yyyy H:m', $participant->CreationTime),
          'DatePay' => '',
        );

        if ($participant->User->GetPrimaryEmployment() !== null)
        {
          $row['Company'] = $participant->User->GetPrimaryEmployment()->Company->Name;
          $row['Position'] = $participant->User->GetPrimaryEmployment()->Position;
        }

        $criteria = new \CDbCriteria();
        $criteria->with = array(
          'Product', 
          'Product.Attributes' => array('select' => false, 'alias' => 'ProductAttributes')
        );
        $criteria->condition = 't.OwnerId = :OwnerId AND Product.EventId = :EventId AND t.Paid = 1 AND ProductAttributes.Name = \'RoleId\'';
        $criteria->params['EventId'] = \Yii::app()->partner->getAccount()->EventId;
        $criteria->params['OwnerId'] = $participant->UserId;
        $orderItem = \pay\models\OrderItem::model()->find($criteria);
        if ($orderItem !== null)
        {
          $row['Price'] = $orderItem->PriceDiscount() !== null ? $orderItem->PriceDiscount() : 0;
          $row['DatePay'] = \Yii::app()->dateFormatter->format('dd MMMM yyyy H:m', strtotime($orderItem->PaidTime));
        }
        
        //todo: Переделать используя $fp = fopen('php://output', 'w'); и fputcsv
        echo implode($this->csvDelimiter, $this->rowHandler($row))."\r\n";
      }
      exit();
    }
    
    $this->getController()->setPageTitle('Экспорт участников в CSV');
    $this->getController()->initActiveBottomMenu('export');
    $this->getController()->render('export');
  }
}

?>
