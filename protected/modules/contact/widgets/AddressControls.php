<?php
namespace contact\widgets;
class AddressControls extends \CWidget
{
  public $form;
  public function init()
  {
    \Yii::app()->clientScript->registerScriptFile(
      \Yii::app()->getAssetManager()->publish(\Yii::getPathOfAlias('contact.widgets.assets.js').'/addresscontrols.js'), \CClientScript::POS_HEAD
    );
  }

  public function run()
  {
    $this->render('addresscontrols', array('form' => $this->form));
  }
}
