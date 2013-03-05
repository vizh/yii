<?php
class TranslationController extends convert\components\controllers\Controller
{
  public function actionIndex()
  {
    $translations = $this->queryAll('SELECT * FROM `Translation` ORDER BY `Translation`.`Id` ASC');
    foreach ($translations as $translation)
    {
      $newTranslation = new \application\models\translation\Translation();
      $newTranslation->Id = $translation['Id'];
      $newTranslation->ResourceName = $translation['ResourceName'];
      $newTranslation->ResourceId = $translation['ResourceId'];
      $newTranslation->Locale = $translation['Locale'];
      $newTranslation->Field = $translation['Field'];
      $newTranslation->Value = $translation['Value'];
      $newTranslation->save();
    }
  }
}
