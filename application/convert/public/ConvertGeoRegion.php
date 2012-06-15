<?php
//9
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertGeoRegion extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelect = 'SELECT `region_id`, `country_id`, `name`, `priority`
      FROM region ORDER BY region_id ASC LIMIT ';
      
    $sqlInsert = 'INSERT INTO GeoRegion (`RegionId`, `CountryId`, `Name`, `Priority`) 
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
