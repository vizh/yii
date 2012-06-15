<?php
//1
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertUser extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelect = 'SELECT `user_id`, `rocid`, `lastname`, `firstname`, `fathername`, `sex`, 
      `birthday`, `password`, `creation_time`, `update_time`, `last_visit`, `referral` 
      FROM user ORDER BY user_id ASC LIMIT ';
      
    $sqlInsert = 'INSERT INTO User (`UserId`, `RocId`, `LastName`, 
      `FirstName`, `FatherName`, `Sex`, `Birthday`, `Password`, `CreationTime`, 
      `UpdateTime`, `LastVisit`, `Referral`) 
      VALUES ';            
    
    $offset = 0;
    $limit = 1000;    
    $selectLim = $offset . ', ' . $limit;
    $rows = $oldConn->createCommand($sqlSelect . $selectLim)->queryAll();
    while (! empty($rows))
    {
      $insertValues = '';
      foreach ($rows as $row)
      {
        foreach ($row as $key => $val)
        {
          $row[$key] = addcslashes($val, '\'"\\');
        }
        $insertValues .= ', (\'' . implode('\',\'', $row) . '\')';        
      }
      $insertValues = substr($insertValues, 1);
      $newConn->createCommand($sqlInsert . $insertValues)->execute();
      $offset += $limit;
      $selectLim = $offset . ', ' . $limit;
      $rows = $oldConn->createCommand($sqlSelect . $selectLim)->queryAll();
    }
    echo 'OK';
  }
}