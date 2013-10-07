<?php

use \competence\models\tests\mailru2013;

class ExportController extends \application\components\controllers\AdminMainController
{
  public function actionIndex()
  {
    ini_set("memory_limit", "512M");
    $fp = fopen(Yii::getPathOfAlias('competence.data') . '/result.csv',"w");

    $test = \competence\models\Test::model()->findByPk(1);

    $questionNames = $this->getQuestionNames($test);

    $row = array();
    foreach ($questionNames as $name)
    {
      $name = substr(strrchr($name, "\\"), 1);
      $name = $name !== 'First' ? $name : 'S1';
      $row[] = $name;
      $row[] = $name . ' - other';
      $row[] = $name . ' - time';
    }

    fputcsv($fp, $row);

    /** @var \competence\models\Result[] $results */
    $results = \competence\models\Result::model()->byTestId(1)->findAll();

    foreach ($results as $result)
    {
      $data = unserialize(base64_decode($result->Data));
      $row = [];
      foreach ($questionNames as $name)
      {
        if (isset($data[$name]))
        {
          $qData = $data[$name];

          $row[] = json_encode($qData['value'], JSON_UNESCAPED_UNICODE);
          $row[] = !empty($qData['other']) ? (is_array($qData['other']) ? json_encode($qData['other'], JSON_UNESCAPED_UNICODE) : $qData['other']) : '';
          $row[] = $qData['DeltaTime'];
        }
        else
        {
          $row[] = '';
          $row[] = '';
          $row[] = '';
        }
      }
      fputcsv($fp, $row);
    }

    fclose($fp);

    echo 'Done';
  }

  /**
   * @param \competence\models\Test $test
   *
   * @return string[]
   */
  public function getQuestionNames($test)
  {
    return [
      get_class(new mailru2013\First($test)),
      get_class(new mailru2013\S2($test)),
      get_class(new mailru2013\E1_1($test)),
      get_class(new mailru2013\E2($test)),
      get_class(new mailru2013\E3($test)),
      get_class(new mailru2013\E4($test)),
      get_class(new mailru2013\E5($test)),
      get_class(new mailru2013\A1($test)),
      get_class(new mailru2013\A2($test)),
      get_class(new mailru2013\A4($test)),
      get_class(new mailru2013\A5($test)),
      get_class(new mailru2013\A6($test)),
      get_class(new mailru2013\A6_1($test)),
      get_class(new mailru2013\A7($test)),
      get_class(new mailru2013\A8($test)),
      get_class(new mailru2013\A9($test)),
      get_class(new mailru2013\A10($test)),
      get_class(new mailru2013\A10_1($test)),
      get_class(new mailru2013\S5($test)),
      get_class(new mailru2013\S6($test)),
      get_class(new mailru2013\S7($test)),
      get_class(new mailru2013\S3($test)),
      get_class(new mailru2013\S3_1($test)),
      get_class(new mailru2013\C1($test)),
      get_class(new mailru2013\C2($test)),
      get_class(new mailru2013\C3($test)),
      get_class(new mailru2013\C4($test)),
      get_class(new mailru2013\C5($test)),
      get_class(new mailru2013\C6($test)),
    ];
  }
}