<?php

 
class TestGetusers extends GeneralCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $selectRocId = array(102735, 102649 ,102233 , 102253 , 53839 , 101760 , 101548 , 42414 , 84139 , 32802 , 100700 );

    $userModel = User::model()->with('Employments.Company', 'Emails');
    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.RocId', $selectRocId);
    $users = $userModel->findAll($criteria);
    echo '<table>';
    foreach ($users as $user)
    {
      echo '<tr>';
      echo '<td>' . $user->LastName . '</td><td>' . $user->FirstName . '</td><td>' . $user->FatherName . '</td><td>' . $user->Email . '</td>';
      if (! empty($user->Emails))
      {
        echo '<td>' . $user->Emails[0]->Email . '</td>';
      }
      foreach ($user->Employments as $employment)
      {
        if ($employment->Primary == 1 && ! empty($employment->Company))
        {
          echo '<td>' . $employment->Company->Name . '</td><td>' . $employment->Position . '</td>';
        }
      }
      echo '</tr>';
    }
    echo '</table>';
  }
}
