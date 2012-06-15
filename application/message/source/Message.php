<?php
class Message extends CActiveRecord
{
  public static $TableName = 'Mod_Message';
  
 /**
  * @param string $className
  * @return News
  */
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return self::$TableName;
  }
  
  public function primaryKey()
  {
    return 'MessageId';
  }
  
  public function relations()
  {
    return array(   
      'FromUser' => array(self::BELONGS_TO, 'User', 'UserId'),
      'ToUser' => array(self::BELONGS_TO, 'User', 'UserId')
    );
  }
  
  /**
  * Создает сообщение в БД
  * 
  * @param int $from
  * @param int $to
  * @param string $subject
  * @param string $messageText
  * @return Message
  */
  public static function SendMessage($from, $to, $subject, $messageText)
  {
    $message = new Message();
    $message->SetFrom($from);
    $message->SetTo($to);
    $message->SetSubject($subject);
    $message->SetMessage($messageText);
    $message->save();
    return $message;
  }
  
  /**
  * Помечает список сообщение $messageIds как прочитанные
  * 
  * @param array $messageIds
  * @param int $userId
  */
  public static function SetMessagesAsRead($messageIds, $userId)
  {
    $criteria = new CDbCriteria();
    $data = Lib::TransformDataArray($messageIds, ':msg');
    $data[1][':UserId'] = $userId;
    $criteria->condition = 'MessageId IN (' . implode(',', $data[0]) . ') AND To = :UserId';
    $criteria->params = $data[1];
    Message::model()->updateAll(array('Status' => 1), $criteria);
  }
  
  /**
  * Удаляет сообщения $messageIds
  * 
  * @param array $messageIds
  * @param int $userId
  */
  public static function DeleteMessages($messageIds, $userId)
  {
    $criteria = new CDbCriteria();
    $data = Lib::TransformDataArray($messageIds, ':msg');
    $data[1][':UserId'] = $userId;
    $criteria->condition = 'MessageId IN (' . implode(',', $data[0]) . ') AND To = :UserId';
    $criteria->params = $data[1];
    Message::model()->deleteAll($criteria);
  }
  
  /**
  * Геттеры и сеттеры для полей
  */
  public function GetMessageId()
  {
    return $this->MessageId;
  }
  
  //From
  public function GetFrom()
  {
    return $this->From;
  }
  
  public function SetFrom($value)
  {
    $this->From = $value;
  }
  
  //To
  public function GetTo()
  {
    return $this->To;
  }
  
  public function SetTo($value)
  {
    $this->To = $value;
  }
  
  //Subject
  public function GetSubject()
  {
    return $this->Subject;
  }
  
  public function SetSubject($value)
  {
    $this->Subject = $value;
  }
  
  //Message
  public function GetMessage()
  {
    return $this->Message;
  }
  
  public function SetMessage($value)
  {
    $this->Message = $value;
  }
  
  //Status
  public function GetStatus()
  {
    return $this->Status;
  }
  
  public function SetStatus($value)
  {
    $this->Status = $value;
  }
  
  //VisibleIncoming
  public function GetVisibleIncoming()
  {
    return $this->VisibleIncoming;
  }
  
  public function SetVisibleIncoming($value)
  {
    $this->VisibleIncoming = $value;
  }
  
  //VisibleOutcoming
  public function GetVisibleOutcoming()
  {
    return $this->VisibleOutcoming;
  }
  
  public function SetVisibleOutcoming($value)
  {
    $this->VisibleOutcoming = $value;
  }
  
  //CreationTime
  public function GetCreationTime()
  {
    return $this->CreationTime;
  }
  
  public function SetCreationTime($value)
  {
    $this->CreationTime = $value;
  }
}