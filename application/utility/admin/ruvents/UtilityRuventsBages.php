<?php
class UtilityRuventsBages extends AdminCommand
{
  private $eventId = 246;
  private $roleId  = 2;
  private $date    = '2012-09-27';


  protected function doExecute()
  {
    $sql = 'SELECT * FROM Mod_RuventsBadge t WHERE t.EventId  = :EventId AND t.RoleId = :RoleId';
    $condition = 't.EventId  = :EventId AND t.RoleId = :RoleId ';
    $params = array(
      ':EventId' => $this->eventId,
      ':RoleId'  => $this->roleId
    );
    
    if ($this->date !== null)
    {
      $condition .= ' AND t.CreationTime > :DateStart AND t.CreationTime < :DateEnd';
      $params[':DateStart'] = $this->date.' 00:00:00';
      $params[':DateEnd'] = $this->date.' 23:59:59';
    }
    
    
    $badges = Yii::app()->db->createCommand()
        ->select('t.UserId')
        ->from('Mod_RuventsBadge t')
        ->where($condition, $params)
        ->group('t.UserId')
        ->queryAll();
      
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=badges.csv');
    if (!empty($badges))
    {
      foreach ($badges as $badge)
      {
        $user = User::GetById($badge['UserId'], array('Phones'));

        $fields = array(
          $user->RocId,
          $user->GetFullName(),
          $user->GetEmail()->Email,
          (!empty($user->Phones) ? $user->Phones[0]->Phone : ''),
          ($user->EmploymentPrimary() !== null ? str_replace(';', '', $user->EmploymentPrimary()->Company->Name) : '')
        );
        echo implode(';', $fields)."\r\n";
      }
    }
  }
}