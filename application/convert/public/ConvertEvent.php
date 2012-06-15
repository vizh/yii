<?php
//2
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertEvent extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelect = 'SELECT `proj_id`, `type`, `short_name`, `name`, `info`, `place`, `comment`, `url`,
      `date_start`, `date_end`, `visible`, `order`
      FROM proj_event ORDER BY date_start ASC LIMIT ';

    $sqlSelectDetails = "SELECT `value`
      FROM `proj_event_details` WHERE `field` = 'registration' AND `proj_id` = :ProjId";

    $cmdDetails = $oldConn->createCommand($sqlSelectDetails);
      
    $sqlInsert = 'INSERT INTO Event (`IdName`, `Type`, `ShortName`, `Name`, `Info`, `Place`, 
      `Comment`, `Url`, `DateStart`, `DateEnd`, `Visible`, `Order`, `UrlRegistration`)
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

        $cmdDetails->bindValue(':ProjId', $row['proj_id']);
        $rowReg = $cmdDetails->queryRow();
        if ($rowReg)
        {
          $row['urlreg'] = $rowReg['value'];
        }
        else
        {
          $row['urlreg'] = '';
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
