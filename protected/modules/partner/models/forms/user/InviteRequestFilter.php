<?php
namespace partner\models\forms\user;

class InviteRequestFilter extends \CFormModel
{
  public $Sender;
  public $Owner;
  public $Approved;
  
  public function rules()
  {
    return array(
      array('Sender,Owner,Approved', 'safe')  
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'Sender'     => \Yii::t('app', 'ФИО или RUNET-ID отправителя'),
      'Owner'     => \Yii::t('app', 'ФИО или RUNET-ID получателя'),
      'Approved' => \Yii::t('app', 'Статус')
    );
  }
  
  /**
   * 
   * @return \CDbCriteria
   */
  public function getCriteria()
  {
    $criteria = new \CDbCriteria();
    
    if (!empty($this->Sender))
    {
      $userIdList = [];
      $users = \user\models\User::model()->bySearch($this->Sender)->findAll();
      foreach ($users as $user)
      {
        $userIdList[] = $user->Id;
      }
      $criteria->addInCondition('"t"."SenderUserId"', $userIdList);
    }
    
    if (!empty($this->Owner))
    {
      $userIdList = [];
      $users = \user\models\User::model()->bySearch($this->Owner)->findAll();
      foreach ($users as $user)
      {
        $userIdList[] = $user->Id;
      }
      $criteria->addInCondition('"t"."OwnerUserId"', $userIdList);
    }
    
    if ($this->Approved != '')
    {
      $criteria->addCondition('"t"."Approved" = :Approved');
      $criteria->params[':Approved'] = $this->Approved;
    }
    return $criteria;
  }
}
