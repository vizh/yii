<?php
//4
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertUseremployment extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelect = 'SELECT `employment_id`, `user_id`, `company_id`, `start_working`,
      `finish_working`, `position`, `info`, `primary`
      FROM user_employment ORDER BY employment_id ASC LIMIT ';
      
    $sqlInsert = 'INSERT INTO UserEmployment (`EmploymentId`, `UserId`, `CompanyId`, 
      `StartWorking`, `FinishWorking`, `Position`, `Info`, `Primary`) 
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
          if ($key == 'start_working' || $key == 'finish_working')
          {
            $row[$key] = $val . '-00-00';
          }
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