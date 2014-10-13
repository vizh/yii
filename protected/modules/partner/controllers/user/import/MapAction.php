<?php
namespace partner\controllers\user\import;
\Yii::import('ext.PHPExcel.PHPExcel', true);

class MapAction extends \partner\components\Action
{
  public function run($id)
  {
    $this->getController()->setPageTitle('Импорт участников мероприятия');
    $this->getController()->initActiveBottomMenu('import');

    $import = \partner\models\Import::model()->findByPk($id);
    if ($import == null || $import->EventId != $this->getEvent()->Id)
      throw new \CHttpException(404);

    $phpExcel = \PHPExcel_IOFactory::load($import->getFileName());
    $worksheet = $phpExcel->getSheet(0);
    $columns = $this->getSignificantColumns($worksheet);

    $request = \Yii::app()->getRequest();

    $form = new \partner\models\forms\user\ImportPrepare($columns, $this->getEvent());
    $form->attributes = $request->getParam(get_class($form));


    if ($request->getIsPostRequest() && $form->validate())
    {
      $fields = $form->getAttributes($form->getColumns());
      $import->Notify = $form->Notify;
      $import->NotifyEvent = $form->NotifyEvent;
      $import->Visible = $form->Visible;
      $import->Fields = base64_encode(serialize($fields));
      $import->save();

        for ($i = 2; $i <= $worksheet->getHighestRow(); $i++) {
            $importUser = new \partner\models\ImportUser();
            $importUser->ImportId = $import->Id;
            $data = [];
            foreach ($columns as $column) {
                $field = $form->$column;
                $value = trim($worksheet->getCell($column.$i)->getValue());
                if (!empty($field) && !empty($value)) {
                    if ($importUser->hasAttribute($field)) {
                        $importUser->$field = $value;
                    } else {
                        $data[$field] = $value;
                    }
                }
            }
            if (!empty($data)) {
                $importUser->UserData = json_encode($data, JSON_UNESCAPED_UNICODE);
            }
            $importUser->save();
        }

      $this->getController()->redirect(\Yii::app()->createUrl('/partner/user/importroles', ['id' => $import->Id]));
    }

    $this->getController()->render('import/map', ['form' => $form, 'worksheet' => $worksheet]);
  }

  /**
   * @param \PHPExcel_Worksheet $worksheet
   * @return string[]
   */
  private function getSignificantColumns($worksheet)
  {
    $result = [];
    foreach ($worksheet->getRowIterator(2) as $row)
    {
      /** @var $row \PHPExcel_Worksheet_Row */
      $cellIterator = $row->getCellIterator();
      //$cellIterator->setIterateOnlyExistingCells(false);
      foreach ($cellIterator as $cell)
      {
        /** @var $cell \PHPExcel_Cell */
        $value = trim($cell->getValue());
        if (!empty($value))
        {
          $result[] = $cell->getColumn();
        }
      }
    }
    $result = array_unique($result);
    sort($result, SORT_STRING);

    return $result;
  }
}