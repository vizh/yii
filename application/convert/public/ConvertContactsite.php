<?php
//7
AutoLoader::Import('convert.source.DevutilsDb');

class ConvertContactsite extends AbstractCommand
{  
  protected function doExecute()
  {
//    echo 'Already doing';
//    exit;
    set_time_limit(1000);
    
    $oldConn = DevutilsDb::GetOldDbConnection();
    $newConn = DevutilsDb::GetNewDbConnection();    
    
    $sqlSelect = 'SELECT `site_id`, `site_category_id`, `user_id`, `company_id`,
      `name`, `url`, `info`, `screenshot`, `creation_time`, `activity`
      FROM site ORDER BY site_id ASC LIMIT ';
      
    $sqlInsertMain = 'INSERT INTO ContactSite (`SiteId`, `SiteCategoryId`, `Name`, `Url`, 
      `Info`, `Screenshot`, `CreationTime`, `Activity`) 
      VALUES ';
      
    $sqlInsertUserLink = 'INSERT INTO Link_User_ContactSite 
      (UserId, SiteId)
      VALUES ';
      
    $sqlInsertCompanyLink = 'INSERT INTO Link_Company_ContactSite
      (CompanyId, SiteId) 
      VALUES ';
          
    $offset = 0;
    $limit = 1000;    
    $selectLim = $offset . ', ' . $limit;
    $rows = $oldConn->createCommand($sqlSelect . $selectLim)->queryAll();
    try
      {
    while (! empty($rows))
    {      
      $insertValues = '';
      $insertUserLink =  '';
      $insertCompanyLink = '';
      foreach ($rows as $row)
      {
        foreach ($row as $key => $val)
        {
          $row[$key] = addcslashes($val, '\'"\\');
        }        
        if (isset($row['user_id']) && intval($row['user_id']) !== 0)
        {
          $insertUserLink .= ', (\'' . $row['user_id'] . '\', \'' . $row['site_id'] . '\')';
        }
        if (isset($row['company_id']) && intval($row['company_id']) !== 0)
        {          
          $insertCompanyLink .= ', (\'' . $row['company_id'] . '\', \'' . $row['site_id'] . '\')';
        }        
        unset($row['user_id']);
        unset($row['company_id']);
        $insertValues .= ', (\'' . implode('\',\'', $row) . '\')';        
      }      
      $insertValues = substr($insertValues, 1);      
      $newConn->createCommand($sqlInsertMain . $insertValues)->execute();
      if (! empty($insertUserLink))
      {
        $insertUserLink = substr($insertUserLink, 1);      
        $newConn->createCommand($sqlInsertUserLink . $insertUserLink)->execute();
      }
      if (! empty($insertCompanyLink))
      {
        $insertCompanyLink = substr($insertCompanyLink, 1);      
        $newConn->createCommand($sqlInsertCompanyLink . $insertCompanyLink)->execute();
      }
      $offset += $limit;
      $selectLim = $offset . ', ' . $limit;
      $rows = $oldConn->createCommand($sqlSelect . $selectLim)->queryAll();
    }
    echo 'OK';    
    
      }
    catch (Exception $e)
    {
      echo $insertValues;
      echo $sqlInsertUserLink . $insertUserLink;
      echo $sqlInsertCompanyLink . $insertCompanyLink;
      throw $e;
    }
  }
}