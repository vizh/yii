<?php
class SectionController extends convert\components\controllers\Controller
{
  public function actionIndex()
  {
    $sections = $this->queryAll('SELECT * FROM `EventProgram` ORDER BY `EventProgram`.`EventProgramId` ASC');
    foreach ($sections as $section)
    {
      $newSection = new \event\models\section\Section();
      $newSection->Id = $section['EventProgramId'];
      $newSection->EventId = $section['EventId'];
      $newSection->Title = $section['Title'];
      $newSection->Info = $section['Info'];
      $newSection->StartTime = $section['DatetimeStart'];
      $newSection->EndTime = $section['DatetimeFinish'];
      switch ($section['Type'])
      {
        case 'short':
          $newSection->TypeId = 4;
          break;
        
        case 'full':
          $newSection->TypeId = 1;
          break;
      }
      $newSection->save();
    }
  }
  
  public function actionHall()
  {
    $sections = $this->queryAll('SELECT * FROM `EventProgram` ORDER BY `EventProgram`.`EventProgramId` ASC');
    foreach ($sections as $section)
    {
      $criteria = new \CDbCriteria();
      $criteria->condition = '"t"."EventId" = :EventId AND "t"."Title" = :Title';
      $criteria->params['EventId'] = $section['EventId'];
      $criteria->params['Title'] = $section['Place'];
      $hall = \event\models\section\Hall::model()->find($criteria);
      if ($hall == null)
      {
        $hall = new \event\models\section\Hall();
        $hall->EventId = $section['EventId'];
        $hall->Title = $section['Place'];
        $hall->save();
      }
      
      $linkHall = new \event\models\section\LinkHall();
      $linkHall->HallId = $hall->Id;
      $linkHall->SectionId = $section['EventProgramId'];
      $linkHall->save();
    }
  }
  
  public function actionReport()
  {
    $reports = $this->queryAll('SELECT * FROM `EventReports` ORDER BY `EventReports`.`ReportId` ASC');
    foreach ($reports as $report)
    {
      $newReport = new \event\models\section\Report();
      $newReport->Id = $report['ReportId'];
      $newReport->Title = $report['Header'];
      if (!empty($report['Thesis']))
      {
        $newReport->Thesis = $report['Thesis'];
      }
      
      if (!empty($report['LinkPresentation']))
      {
        $newReport->Url = $report['LinkPresentation']; 
      }
      $newReport->save();
    }
  }
  
  public function actionRole()
  {
    $roles = $this->queryAll('SELECT * FROM `EventProgramRoles` ORDER BY `EventProgramRoles`.`RoleId` ASC');
    foreach ($roles as $role)
    {
      $newRole = new \event\models\section\Role();
      $newRole->Id = $role['RoleId'];
      $newRole->Title = $role['Name'];
      if ($role['RoleId'] == 1)
      {
        $newRole->Type = 'master';
      }
      $newRole->save();
    }
  }
  
  public function actionLinkuser()
  {
    $links = $this->queryAll('SELECT * FROM `EventProgramUserLink` ORDER BY `EventProgramUserLink`.`LinkId` ASC');
    foreach ($links as $link)
    {
      $newLink = new \event\models\section\LinkUser();
      $newLink->Id = $link['LinkId'];
      $newLink->SectionId = $link['EventProgramId'];
      $newLink->UserId = $link['UserId'];
      $newLink->RoleId = $link['RoleId'];
      if ($link['ReportId'] != 0)
      {
        $newLink->ReportId = $link['ReportId'];
      }
      $newLink->Order = $link['Order'];
      $newLink->save();
    }
  }
}
