<?php
//10
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertEventprogramuserlink extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelectEvents = 'SELECT `EventId`, `IdName`
      FROM Event ORDER BY EventId ASC';
    
    $events = array();  
    $rows = $newConn->createCommand($sqlSelectEvents)->queryAll();
    foreach ($rows as $row)
    {
      $events[$row['IdName']] = $row['EventId'];
    }    
    
    $sqlSelectProgram = 'SELECT `link_id`, `proj_id`, `event_id`, `user_id`, 
    `role_id`, `report_id`, `order`
      FROM mod_program_user_link WHERE `tmp_user_id`=0 ORDER BY proj_id ASC LIMIT ';
      
    $sqlInsertMain = 'INSERT INTO EventProgramUserLink (`LinkId`, `EventId`, `EventProgramId`, `UserId`, 
    `RoleId`, `ReportId`, `Order`) 
      VALUES ';           
    
    $offset = 0;
    $limit = 1000;    
    $selectLim = $offset . ', ' . $limit;
    $rows = $oldConn->createCommand($sqlSelectProgram . $selectLim)->queryAll();
    while (! empty($rows))
    {
      $insertValues = '';
      foreach ($rows as $row)
      {
        foreach ($row as $key => $val)
        {
          $row[$key] = addcslashes($val, '\'"\\');
        }
        if (isset($events[$row['proj_id']]))
        {
          $row['proj_id'] = $events[$row['proj_id']];
          $insertValues .= ', (\'' . implode('\',\'', $row) . '\')'; 
        }               
      }
      $insertValues = substr($insertValues, 1);      
      $newConn->createCommand($sqlInsertMain . $insertValues)->execute();
      $offset += $limit;
      $selectLim = $offset . ', ' . $limit;
      $rows = $oldConn->createCommand($sqlSelectProgram . $selectLim)->queryAll();
    }
    echo 'OK';  
  }

}