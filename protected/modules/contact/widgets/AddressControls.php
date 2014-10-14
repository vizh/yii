<?php
namespace contact\widgets;
class AddressControls extends \CWidget
{
    public $form;
    public $address = true;
    public $place = true;
    public $inputClass = '';
    public $disabled = false;


    public function init()
    {
        \Yii::app()->clientScript->registerScriptFile(
            \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('contact.widgets.assets.js').'/addresscontrols.js'), \CClientScript::POS_HEAD
        );
    }

    public function run()
    {
        $this->render('addresscontrols', array(
            'form' => $this->form,
            'address' => $this->address,
            'place' => $this->place
        ));
    }
}
