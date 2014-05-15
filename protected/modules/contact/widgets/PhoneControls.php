<?php
namespace contact\widgets;

class PhoneControls extends \CWidget
{
    /** @var \CFormModel */
    public $form = null;
    public $inputClass = null;


    public function init()
    {
        \Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');
        \Yii::app()->getClientScript()->registerScriptFile(
            \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('contact.widgets.assets.js').'/phonecontrols.js'), \CClientScript::POS_HEAD
        );
    }

    public function run()
    {
        $this->render('phonecontrols');
    }

} 