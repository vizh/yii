<?php
namespace contact\widgets;
use contact\models\forms\Address;

class AddressControls extends \CWidget
{
    /** @var  Address */
    public $form;
    public $address = true;
    public $place = true;
    public $apartment = false;
    public $inputClass = '';
    public $inputPlaceholder = null;
    public $disabled = false;
    public $geoCoordinates = false;


    public function init()
    {
        \Yii::app()->clientScript->registerScriptFile(
            \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('contact.widgets.assets.js').'/google-map-util.js'), \CClientScript::POS_HEAD
        );

        \Yii::app()->clientScript->registerScriptFile(
            \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('contact.widgets.assets.js').'/addresscontrols.js'), \CClientScript::POS_HEAD
        );
    }

    public function run()
    {
        if ($this->inputPlaceholder === null) {
            $this->inputPlaceholder = $this->form->getAttributeLabel('CityLabel');
        }
        $this->render('addresscontrols', array(
            'form' => $this->form,
            'address' => $this->address,
            'place' => $this->place,
            'apartment' => $this->apartment,
            'geoPointCoordinates' => $this->geoCoordinates
        ));
    }
}
