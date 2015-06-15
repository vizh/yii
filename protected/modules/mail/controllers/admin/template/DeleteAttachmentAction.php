<?php
namespace mail\controllers\admin\template;

class DeleteAttachmentAction extends \CAction
{
    public function run($file = null, $templateId = null)
    {
        $path = \Yii::getpathOfAlias('webroot.files.upload.mails.'.$templateId).'/'.$file;
        unlink($path);
        $ajax = \Yii::app()->request->getParam('ajax');
        if(!$ajax)
            \Yii::app()->request->redirect(['edit', 'templateId' => $templateId]);
        die();
    }

}