<?php
namespace partner\controllers\ruvents;

class CsvinfoAction extends \partner\components\Action
{

  //const Step = 1000;


  public function run()
  {
    $this->getController()->setPageTitle('Генерация итоговых данных мероприятия');
    $this->getController()->initActiveBottomMenu('csvinfo');

    if (!empty($this->getEvent()->Days))
    {
      throw new \Exception('Не реализован для мероприятий с несколькими логическими днями!');
    }

    $request = \Yii::app()->getRequest();
    $generate = $request->getParam('generate');
    if (!empty($generate))
    {
      $this->generateFile(1);
      $this->getController()->redirect(\Yii::app()->createUrl('/partner/ruvents/csvinfo'));
    }

    $file = $request->getParam('file');
    if (!empty($file))
    {
      $file = $this->getDataPath() . $file;
      header('Content-Description: File Transfer');
      header("Content-type: csv/plain");
      header('Content-Disposition: attachment; filename='.urlencode(basename($file)));
      header("Expires: 0");
      header('Content-Length: ' . filesize($file));
      header("Content-Transfer-Encoding: binary");

      readfile($file);
      exit;
    }

    $fileList = $this->getFileList();

    $this->getController()->render('csvinfo', array('fileList' => $fileList));
  }

  private function generateFile($page)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = [
      'Role',
      'User',
      'User.Participants' => [
        'on' => '"Participants"."EventId" = :EventId',
        'params' => ['EventId' => $this->getEvent()->Id]
      ]
    ];
    $criteria->order = '"t"."CreationTime" ASC';

    /** @var $badges \ruvents\models\Badge[] */
    $badges = \ruvents\models\Badge::model()->byEventId($this->getEvent()->Id)->findAll($criteria);

    foreach ($badges as $badge)
    {
      $this->addLine($badge);
    }

    $badges[0]->User

    $result = array();
    foreach ($badges as $badge)
    {
      if (!isset($result[$badge->UserId]))
      {
        $info = new \stdClass();
        $info->Badge = $badge;
        $info->Count = 1;
        $result[$badge->UserId] = $info;
        continue;
      }

      if (strtotime($badge->CreationTime) - strtotime($result[$badge->UserId]->Badge->CreationTime) > 300)
      {
        $result[$badge->UserId]->Count++;
      }
    }

    foreach ($result as $info)
    {
      $this->addLine($info);
    }

    fclose($this->getFile());
  }

  private function addLine(\ruvents\models\Badge $badge)
  {
    $row = [];
    $row[] = $badge->User->RunetId;
    $row[] = $badge->User->getFullName();
    if ($badge->User->getEmploymentPrimary() != null)
    {
      $row[] = $badge->User->getEmploymentPrimary()->Position;
      $row[] = $badge->User->getEmploymentPrimary()->Company->Name;
    }
    else
    {
      $row[] = '';
      $row[] = '';
    }
    $row[] = $badge->Role->Title;


    $status = '';


    fputcsv($this->getFile(), array($badge->User->GetFullName(), $company, $position, $role, $status, $badge->CreationTime, $info->Count), ';');
  }

  private $filename = null;
  private $file = null;
  private function getFile()
  {
    if ($this->file == null)
    {
      if (empty($this->filename))
      {
        $this->filename = 'info_' . date('Y-m-d_H-i-s') . '.csv';
      }
      $this->file = fopen($this->getDataPath() . $this->filename, 'w');
    }
    return $this->file;
  }


  private $dataPath = null;
  private function getDataPath()
  {
    if (empty($this->dataPath))
    {
      $path = \Yii::getPathOfAlias('partner.data');
      $this->dataPath = $path . '/' . \Yii::app()->partner->getAccount()->EventId . '/csvinfo/';
      if (!file_exists($this->dataPath))
      {
        mkdir($this->dataPath, 0755, true);
      }
    }
    return $this->dataPath;
  }

  private function getFileList()
  {
    $results = array();

    // create a handler for the directory
    $handler = opendir($this->getDataPath());

    // open directory and walk through the filenames
    while ($file = readdir($handler)) {

      // if file isn't this directory or its parent, add it to the results
      if ($file != "." && $file != "..") {
        $results[] = $file;
      }

    }

    // tidy up: close the handler
    closedir($handler);

    sort($results, SORT_STRING);
    $results = array_reverse($results);

    // done!
    return $results;
  }
}
