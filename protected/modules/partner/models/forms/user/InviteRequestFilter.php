<?php
namespace partner\models\forms\user;

class InviteRequestFilter extends \CFormModel
{
  public $User;
  public $Data;
  public $Approved;
  
  public function rules()
  {
    return array(
      array('User,Data,Approved', 'safe')  
    );
  }
  
  public function attributeLabels()
  {
    return array(
      'User'     => \Yii::t('app', 'ФИО или RUNET-ID пользователя'),
      'Data'     => \Yii::t('app', 'По указанным данным'),
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
    if (!empty($this->User))
    {
      $userIdList = [];
      $users = \user\models\User::model()->bySearch($this->User)->findAll();
      foreach ($users as $user)
      {
        $userIdList[] = $user->Id;
      }
      $criteria->addInCondition('"t"."UserId"', $userIdList);
    }
    
    if (!empty($this->Data))
    {
      $criteria->addCondition('"t"."Phone" ILIKE :Data OR "t"."Company" ILIKE :Data OR "t"."Position" ILIKE :Data OR "t"."Info" ILIKE :Data');
      $criteria->params[':Data'] = '%'.$this->Data.'%';
    }
    
    if ($this->Approved != '')
    {
      $criteria->addCondition('"t"."Approved" = :Approved');
      $criteria->params[':Approved'] = $this->Approved;
    }
    return $criteria;
  }
}
