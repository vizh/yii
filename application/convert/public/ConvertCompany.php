<?php
//3
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertCompany extends AbstractCommand
{  
  protected function doExecute()
  {
    //echo 'Already doing';
    //exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelect = 'SELECT company_id, parent_company_id, name, full_name,
      opf, org_name, creation_time, update_time
      FROM company ORDER BY company_id ASC LIMIT ';
      
    $sqlInsert = 'INSERT INTO Company (CompanyId , ParentCompanyId , Name , FullName, 
      Opf , OrgName , CreationTime , UpdateTime ) 
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