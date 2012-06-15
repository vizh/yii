<?php
//10
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertEventprogram extends AbstractCommand
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
    
    $sqlSelectProgram = 'SELECT `event_id`, `proj_id`, `event_type`, `abbr`, `title`, `comment`, `audience`, `rubricator`, `link_photo`, `link_video`, `link_shorthand`, `link_audio`, `datetime_start`, `datetime_finish`, `place`, `description`, `partners`, `fill`, `access`
      FROM mod_program_events ORDER BY proj_id ASC LIMIT ';
      
    $sqlInsertMain = 'INSERT INTO EventProgram (`EventProgramId`, `EventId`, `Type`, `Abbr`, `Title`, `Comment`, `Audience`, `Rubricator`, `LinkPhoto`, `LinkVideo`, `LinkShorthand`, `LinkAudio`, `DatetimeStart`, `DatetimeFinish`, `Place`, `Description`, `Partners`, `Fill`, `Access`) 
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