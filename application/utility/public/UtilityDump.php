<?php

class UtilityDump extends AbstractCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $timestamp = Registry::GetRequestVar('timestamp', 0);
    if ($timestamp != 0)
    {
      $timestamp -= 4*3600 + 15*60;
    }

    $command = Registry::GetDb()->createCommand();
    $result = $command->select('u.RocId, u.LastName, u.FirstName, c.Name CompanyName, er.Name RoleName')->from('EventUser eu')->join('User u', 'eu.UserId = u.UserId')
      ->join('EventRoles er', 'er.RoleId = eu.RoleId')
      ->leftJoin('UserEmployment uEmp', 'uEmp.UserId = u.UserId AND uEmp.Primary = 1')
      ->leftJoin('Company c', 'uEmp.CompanyId = c.CompanyId')
      ->where('eu.EventId = :EventId AND eu.UpdateTime >= :UpdateTime', array(':EventId' => 258, ':UpdateTime' => $timestamp))
      ->group('eu.UserId')->queryAll();

    $output = '';
    $newline = "\r\n";
    foreach ($result as $item)
    {
      $output .= implode(';', $item) . $newline;
    }

    echo $output;
  }
}