<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 17.05.2015
 * Time: 4:07
 */

namespace partner\controllers\user;

use event\models\UserData;
use partner\components\Action;

class ViewDataFileAction extends Action
{
    public function run($id, $attribute)
    {
        $data = UserData::model()
            ->byEventId($this->getEvent()->Id)
            ->findByPk($id);

        if ($data === null) {
            throw new \CHttpException(404);
        }

        $manager = $data->getManager();
        if (!isset($manager->$attribute) || !file_exists($manager->$attribute)) {
            throw new \CHttpException(404);
        }

        $file = $manager->$attribute;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$this->getFileName($data, $attribute).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize($file));
        echo file_get_contents($manager->$attribute);
    }

    private function getFileName(UserData $data, $attribute)
    {
        $info = pathinfo($data->getManager()->$attribute);
        $name = '';
        foreach ($data->getManager()->getDefinitions() as $definition) {
            if ($definition->name == $attribute) {
                $name = $definition->title;
                break;
            }
        }
        $name .= ' '.$data->User->getFullName().'.'.$info['extension'];
        return $name;
    }
}