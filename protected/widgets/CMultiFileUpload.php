<?php

namespace application\widgets;

class CMultiFileUpload extends \CMultiFileUpload
{

    /**
     * @throws \CException
     */
    public function registerClientScript()
    {
        $cs = \Yii::app()->getClientScript();
        $cs->registerScriptFile(
            \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('application.widgets.assets.js').'/jquery.multifile.js'),
            \CClientScript::POS_HEAD
        );
    }
}
