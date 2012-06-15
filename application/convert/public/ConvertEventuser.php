<?php
//10
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertEventuser extends AbstractCommand
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
    
    $sqlSelectUser = 'SELECT `proj_id`, `user_id`, `role_id`, `approve`, `creation_time`
      FROM proj_user ORDER BY proj_id ASC LIMIT ';
      
    $sqlInsertMain = 'INSERT INTO EventUser (`EventId`, `UserId`, `RoleId`, `Approve`,
      `CreationTime`) 
      VALUES ';           
    
    $offset = 0;
    $limit = 1000;    
    $selectLim = $offset . ', ' . $limit;
    $rows = $oldConn->createCommand($sqlSelectUser . $selectLim)->queryAll();
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
      $rows = $oldConn->createCommand($sqlSelectUser . $selectLim)->queryAll();
    }
    echo 'OK';
  }
}