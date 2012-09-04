<?php


class UtilitySpeakers extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $eventId= 258;

    $criteria = new CDbCriteria();
    $criteria->addCondition('t.EventId = :EventId AND t.RoleId = :RoleId');
    $criteria->params[':EventId'] = $eventId;
    $criteria->params[':RoleId'] = 2;

    $model = EventUser::model()->with(
      array(
        'User',
        //'User.EventProgramUserLink.EventProgram' => array('on' => 'EventProgramUserLink.EventId = :EventId', 'params' => array(':EventId' => $eventId)),
        'User.Employments.Company' => array('on' => 'Employments.Primary = :Primary', 'params' => array(':Primary' => 1)),
        'User.Emails',
        'User.Phones'
      )
    );


    //    $model = User::model()->with(
    //      array(
    //        'EventUsers',
    //        'EventProgramUserLink',
    //        'Employments.Company' => array('on' => 'Employments.Primary = :Primary', 'params' => array(':Primary' => 1)),
    //        'Emails',
    //        'Phones'
    //      )
    //    )->together();

    /** @var $eUsers EventUser[] */
    $eUsers = $model->findAll($criteria);


    echo '<table>';
    foreach ($eUsers as $eUser)
    {
      /** @var $user User */
      $user = $eUser->User;


      /** @var $links EventProgramUserLink[] */
      $links = $user->EventProgramUserLink(array('condition' => 'EventProgramUserLink.EventId = :EventId', 'params' => array(':EventId' => $eventId)));

      if (! empty($links))
      {
        foreach ($links as $link)
        {
          echo '<tr>';
          /*$this->printCell(date('d.m.Y', strtotime($link->EventProgram->DatetimeStart)));
          $this->printCell($link->EventProgram->Abbr);
          $this->printCell($link->Role->Name);*/
          $this->printUser($user);
          echo '</tr>';
        }
      }
      else
      {
        echo '<tr>';
        /*$this->printCell('???');
        $this->printCell('???');
        $this->printCell('???');*/
        $this->printUser($user);
        echo '</tr>';
      }

    }
    echo '</table>';
  }

  /**
   * @param User $user
   */
  private function printUser($user)
  {
    $this->printCell($user->LastName);
    $this->printCell($user->FirstName);
    $this->printCell($user->FatherName);

    if (isset($user->Employments[0]))
    {
      $this->printCell($user->Employments[0]->Company->Name);
    }
    else
    {
      $this->printCell('');
    }

    if (isset($user->Emails[0]))
    {
      $this->printCell($user->Emails[0]->Email);
    }
    else
    {
      $this->printCell('');
    }

    $phoneCell = '';
    foreach ($user->Phones as $phone)
    {
      $phoneCell .= urldecode($phone->Phone) . ';';
    }
    $this->printCell($phoneCell);
  }

  private function printCell($value)
  {
    echo '<td>'. $value .'</td>';
  }
}
