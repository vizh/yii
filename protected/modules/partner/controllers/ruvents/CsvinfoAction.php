<?php
namespace partner\controllers\ruvents;

class CsvinfoAction extends \partner\components\Action
{

    //const Step = 1000;

    public function run()
    {
        if (!empty($this->getEvent()->Parts)) {
            throw new \Exception('Не реализован для мероприятий с несколькими логическими днями!');
        }

        $request = \Yii::app()->getRequest();
        $generate = $request->getParam('generate');
        if (!empty($generate)) {
            $this->generateFile(1);
            $this->getController()->redirect(\Yii::app()->createUrl('/partner/ruvents/csvinfo'));
        }

        $file = $request->getParam('file');
        if (!empty($file)) {
            $file = $this->getDataPath().$file;
            header('Content-Description: File Transfer');
            header("Content-type: csv/plain");
            header('Content-Disposition: attachment; filename='.urlencode(basename($file)));
            header("Expires: 0");
            header('Content-Length: '.filesize($file));
            header("Content-Transfer-Encoding: binary");

            readfile($file);
            exit;
        }

        $fileList = $this->getFileList();

        $this->getController()->render('csvinfo', ['fileList' => $fileList]);
    }

    private function generateFile($page)
    {
        $command = \Yii::app()->getDb()->createCommand();
        $result = $command->select('max("CreationTime") as "CreationTimeMax", min("CreationTime") "CreationTimeMin"')->from('RuventsBadge')->where('"EventId" = :EventId', ['EventId' => $this->getEvent()->Id])->queryRow();

        $dates = [];
        $current = date('Y-m-d', strtotime($result['CreationTimeMin']));
        $end = date('Y-m-d', strtotime($result['CreationTimeMax']));

        while ($current <= $end) {
            $this->buildByDate($current);
            $current = date('Y-m-d', strtotime($current) + 24 * 60 * 60);
        }
        fclose($this->getFile());
    }

    private function buildByDate($date)
    {
        $start = $date.' 00:00:00';
        $end = $date.' 23:59:59';
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Role',
            'User',
            'User.Participants' => [
                'on' => '"Participants"."EventId" = :EventId',
                'params' => ['EventId' => $this->getEvent()->Id]
            ]
        ];
        $criteria->addCondition('"t"."CreationTime" BETWEEN :StartTime AND :EndTime');
        $criteria->params = ['StartTime' => $start, 'EndTime' => $end];
        $criteria->order = '"t"."CreationTime" ASC';

        /** @var \ruvents\models\Badge[] $badges */
        $badges = \ruvents\models\Badge::model()->byEventId($this->getEvent()->Id)->findAll($criteria);

        /** @var BadgeInfo[] $badgesInfo */
        $badgesInfo = [];
        foreach ($badges as $badge) {
            if (!isset($badgesInfo[$badge->UserId])) {
                $badgesInfo[$badge->UserId] = new BadgeInfo($badge);
            }
            $badgesInfo[$badge->UserId]->count++;
        }

        foreach ($badgesInfo as $info) {
            $this->addLine($info->badge, $info->count);
        }
    }

    private function addLine(\ruvents\models\Badge $badge, $count)
    {
        $row = [];
        $row[] = $badge->User->RunetId;
        $row[] = $badge->User->getFullName();
        if ($badge->User->getEmploymentPrimary() != null) {
            $row[] = $badge->User->getEmploymentPrimary()->Position;
            $row[] = $badge->User->getEmploymentPrimary()->Company->Name;
        } else {
            $row[] = '';
            $row[] = '';
        }
        $row[] = $badge->User->Email;
        if (isset($badge->User->LinkPhones[0])) {
            $row[] = $badge->User->LinkPhones[0]->Phone->__toString();
        } else {
            $row[] = '';
        }
        $row[] = $badge->Role->Title;
        $participants = $badge->User->Participants;
        $row[] = isset($participants[0]) ? $participants[0]->CreationTime : '';
        $row[] = $badge->CreationTime;
        $row[] = $count;
        fputcsv($this->getFile(), $row, ';');
    }

    private $filename;
    private $file;

    private function getFile()
    {
        if ($this->file == null) {
            if (empty($this->filename)) {
                $this->filename = 'info_'.date('Y-m-d_H-i-s').'.csv';
            }
            $this->file = fopen($this->getDataPath().$this->filename, 'w');
        }
        return $this->file;
    }

    private $dataPath;

    private function getDataPath()
    {
        if (empty($this->dataPath)) {
            $path = \Yii::getPathOfAlias('partner.data');
            $this->dataPath = $path.'/'.\Yii::app()->partner->getAccount()->EventId.'/csvinfo/';
            if (!file_exists($this->dataPath)) {
                mkdir($this->dataPath, 0755, true);
            }
        }
        return $this->dataPath;
    }

    private function getFileList()
    {
        $results = [];

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

class BadgeInfo
{
    public $badge;
    public $count;

    public function __construct(\ruvents\models\Badge $badge)
    {
        $this->badge = $badge;
        $this->count = 0;
    }
}
