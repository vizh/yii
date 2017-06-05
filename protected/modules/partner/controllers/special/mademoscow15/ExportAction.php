<?php
namespace partner\controllers\special\mademoscow15;

use event\models\Participant;
use partner\components\Action;

class ExportAction extends Action
{
    public function run($passport = false)
    {
        $zip = new \ZipArchive();
        $path = $this->getPath();
        if (file_exists($path)) {
            unlink($path);
        }
        $zip->open($path, \ZIPARCHIVE::CREATE);
        $participants = Participant::model()->byEventId($this->getEvent()->Id)->findAll();
        foreach ($participants as $participant) {
            $user = $participant->User;
            if ($passport) {
                $data = $this->getEvent()->getUserData($user);
                $dataRow = array_pop($data);
                if (empty($dataRow)) {
                    continue;
                }
                $filepath = $dataRow->getManager()->PassportScan;
            } else {
                $filepath = $user->getPhoto()->getOriginal(true);
            }
            $extension = substr($filepath, strrpos($filepath, '.'));
            //$localname = iconv('utf-8', 'CP866//TRANSLIT//IGNORE',  $user->getFullName().' (' . $user->RunetId . ')'.$extension);
            $localname = $user->getFullName().' ('.$user->RunetId.')'.$extension;
            $zip->addFile($filepath, $localname);
        }
        $zip->close();
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="export.zip"');
        header('Content-Length: '.filesize($path));
        readfile($path);
    }

    private function getPath()
    {
        $path = \Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;
        $path .= 'data'.DIRECTORY_SEPARATOR.'event'.DIRECTORY_SEPARATOR.'mademoscow15'.DIRECTORY_SEPARATOR.'export.zip';
        return $path;
    }
}