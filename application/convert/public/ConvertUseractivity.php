<?php
//2
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertUseractivity extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelect = 'SELECT `activity_id`, `user_id`, `title`, `url`, `info`, `type`,
      `order`
      FROM user_activity ORDER BY activity_id ASC LIMIT ';
      
    $sqlInsert = 'INSERT INTO UserActivity (`ActivityId`, `UserId`, `Title`, `Url`, 
      `Info`, `Type`, `Order`)
      VALUES ';            
    
    $offset = 0;
    $limit = 5;    
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
