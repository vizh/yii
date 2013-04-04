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

      $fp = fopen('php://output', '');
      $row = array(
        'RUNET-ID',
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
      fputcsv($fp, $row, $this->csvDelimiter);

      $criteria = new \CDbCriteria();
      $criteria->with = array(
        'User',
        'User.Employments',
        'User.Settings',
        'User.Employments.Company',
        'Role',
        'User.LinkPhones.Phone'
      );
      $criteria->order = '"t"."CreationTime" DESC';
      /** @var $participants \event\models\Participant[] */
      $participants = \event\models\Participant::model()
          ->byEventId(\Yii::app()->partner->getAccount()->EventId)->findAll($criteria);
      foreach ($participants as $participant)
      {
        $row = array(
          'RUNET-ID' => $participant->User->RunetId,
          'LastName' => $participant->User->LastName,
          'FirstName' => $participant->User->FirstName,
          'FatherName' => $participant->User->FatherName,
          'Company' => '',
          'Position' => '',
          'Email' => $participant->User->Email,
          'Phone' => !empty($participant->User->LinkPhones) ? (string)$participant->User->LinkPhones[0]->Phone : '',
          'Role' => $participant->Role->Title,
          'Price' => '',
          'DateRegister' => \Yii::app()->dateFormatter->format('dd MMMM yyyy H:m', $participant->CreationTime),
          'DatePay' => '',
        );

        if ($participant->User->getEmploymentPrimary() !== null)
        {
          $row['Company'] = $participant->User->getEmploymentPrimary()->Company->Name;
          $row['Position'] = $participant->User->getEmploymentPrimary()->Position;
        }

        $criteria = new \CDbCriteria();
        $criteria->with = array(
          'Product', 
          'Product.Attributes' => array('select' => false, 'alias' => 'ProductAttributes')
        );
        $criteria->condition = '"t"."OwnerId" = :OwnerId AND "Product"."EventId" = :EventId AND "t"."Paid" AND "ProductAttributes"."Name" = :Name';
        $criteria->params['EventId'] = \Yii::app()->partner->getAccount()->EventId;
        $criteria->params['OwnerId'] = $participant->UserId;
        $criteria->params['Name'] = 'RoleId';
        /** @var $orderItem \pay\models\OrderItem */
        $orderItem = \pay\models\OrderItem::model()->find($criteria);
        if ($orderItem !== null)
        {
          $row['Price'] = $orderItem->getPriceDiscount() !== null ? $orderItem->getPriceDiscount() : 0;
          $row['DatePay'] = \Yii::app()->dateFormatter->format('dd MMMM yyyy H:m', strtotime($orderItem->PaidTime));
        }

        fputcsv($fp, $this->rowHandler($row), $this->csvDelimiter);
      }

      exit();
    }
    
    $this->getController()->setPageTitle('Экспорт участников в CSV');
    $this->getController()->initActiveBottomMenu('export');
    $this->getController()->render('export');
  }
}

?>
