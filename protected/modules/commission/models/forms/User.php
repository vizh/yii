<?php
namespace commission\models\forms;

class User extends \CFormModel
{
  const DATE_FORMAT = 'dd.MM.yyyy';

  public $RunetId;
  public $RoleId;
  public $JoinDate;
  public $ExitDate;
}
