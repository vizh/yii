<?php

class Export2Controller extends \application\components\controllers\PublicMainController
{
    public function actionIndex()
    {
        ini_set("memory_limit", "512M");
        $fp = fopen(Yii::getPathOfAlias('competence.data').'/result2.csv', "w");

        $test = \competence\models\Test::model()->findByPk(2);

        $questionNames = $this->getQuestionNames();

        $row = [];
        foreach ($questionNames as $class) {
            $question = new $class($test);
            $name = substr(strrchr($class, "\\"), 1);
            $name = $name !== 'First' ? $name : 'A1';
            foreach ($question->getAttributes() as $attr => $value) {
                if ($attr == '_t') {
                    continue;
                }
                $row[] = $name.'-'.$attr;
            }
            $row[] = $name.' - time';
        }
        fputcsv($fp, $row, ';');

        /** @var \competence\models\Result[] $results */
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."UserId"', [
            12572,
            48729,
            58175,
            6708,
            31789,
            1684,
            34838,
            14934,
            70977,
            12592,
            69739,
            14288,
            12849,
            14244,
            17451,
            12277,
            14876,
            2795,
            6419,
            123719,
            64011,
            48597,
            10563,
            39328,
            33423,
            126553,
            13747,
            3460,
            17147,
            12858,
            146625,
            100221,
            16045,
            15505,
            30653
        ]);

        $results = \competence\models\Result::model()->byTestId(2)->findAll($criteria);
        foreach ($results as $result) {
            $data = unserialize(base64_decode($result->Data));
            $row = [];
            foreach ($questionNames as $class) {
                $question = new $class($test);
                if (isset($data[$class])) {
                    $qData = $data[$class];
                    foreach ($question->getAttributes() as $attr => $value) {
                        if ($attr == '_t') {
                            continue;
                        } elseif ($attr == 'value' && empty($qData[$attr])) {
                            $value = '';
                        } else {
                            $value = $qData[$attr];
                        }

                        $row[] = json_encode($value, JSON_UNESCAPED_UNICODE);
                    }
                    $row[] = $qData['DeltaTime'];
                } else {
                    foreach ($question->getAttributes() as $attr => $value) {
                        if ($attr == '_t') {
                            continue;
                        }
                        $row[] = '';
                    }
                    $row[] = '';
                }
            }
            fputcsv($fp, $row, ';');
        }

        fclose($fp);

        echo 'Done';
    }

    /**
     * @param \competence\models\Test $test
     *
     * @return string[]
     */
    public function getQuestionNames()
    {
        return [
            'competence\models\tests\runet2013\First',
            'competence\models\tests\runet2013\A2',
            'competence\models\tests\runet2013\A3',
            'competence\models\tests\runet2013\A4',
            'competence\models\tests\runet2013\A5',
            'competence\models\tests\runet2013\A6',
            'competence\models\tests\runet2013\A7',
            'competence\models\tests\runet2013\B1',
            'competence\models\tests\runet2013\B2',
            'competence\models\tests\runet2013\B3_1',
            'competence\models\tests\runet2013\B3_2',
            'competence\models\tests\runet2013\B3_3',
            'competence\models\tests\runet2013\B3_4',
            'competence\models\tests\runet2013\B3_5',
            'competence\models\tests\runet2013\B3_6',
            'competence\models\tests\runet2013\B3_7',
            'competence\models\tests\runet2013\B3_8',
            'competence\models\tests\runet2013\B3_9',
            'competence\models\tests\runet2013\B3_10',
            'competence\models\tests\runet2013\B3_11',
            'competence\models\tests\runet2013\B3_12',
            'competence\models\tests\runet2013\B3_13',
            'competence\models\tests\runet2013\B3_14',
            'competence\models\tests\runet2013\B3_15',
            'competence\models\tests\runet2013\B3_16',
            'competence\models\tests\runet2013\B4_1',
            'competence\models\tests\runet2013\B4_2',
            'competence\models\tests\runet2013\B4_3',
            'competence\models\tests\runet2013\B4_4',
            'competence\models\tests\runet2013\B4_5',
            'competence\models\tests\runet2013\B4_6',
            'competence\models\tests\runet2013\B4_7',
            'competence\models\tests\runet2013\B4_8',
            'competence\models\tests\runet2013\B4_9',
            'competence\models\tests\runet2013\B4_10',
            'competence\models\tests\runet2013\B4_11',
            'competence\models\tests\runet2013\B4_12',
            'competence\models\tests\runet2013\B4_13',
            'competence\models\tests\runet2013\B4_14',
            'competence\models\tests\runet2013\B4_15',
            'competence\models\tests\runet2013\B4_16',
            'competence\models\tests\runet2013\C1_1',
            'competence\models\tests\runet2013\C1_2',
            'competence\models\tests\runet2013\C1_3',
            'competence\models\tests\runet2013\C1_4',
            'competence\models\tests\runet2013\C1_5',
            'competence\models\tests\runet2013\C1_6',
            'competence\models\tests\runet2013\C1_7',
            'competence\models\tests\runet2013\C1_8',
            'competence\models\tests\runet2013\C1_9',
            'competence\models\tests\runet2013\C1_10',
            'competence\models\tests\runet2013\C1_11',
            'competence\models\tests\runet2013\C1_12',
            'competence\models\tests\runet2013\C1_13',
            'competence\models\tests\runet2013\C1_14',
            'competence\models\tests\runet2013\C1_15',
            'competence\models\tests\runet2013\C1_16',
            'competence\models\tests\runet2013\C2_1',
            'competence\models\tests\runet2013\C2_2',
            'competence\models\tests\runet2013\C2_3',
            'competence\models\tests\runet2013\C2_4',
            'competence\models\tests\runet2013\C2_5',
            'competence\models\tests\runet2013\C2_6',
            'competence\models\tests\runet2013\C2_7',
            'competence\models\tests\runet2013\C2_8',
            'competence\models\tests\runet2013\C2_9',
            'competence\models\tests\runet2013\C2_10',
            'competence\models\tests\runet2013\C2_11',
            'competence\models\tests\runet2013\C2_12',
            'competence\models\tests\runet2013\C2_13',
            'competence\models\tests\runet2013\C2_14',
            'competence\models\tests\runet2013\C2_15',
            'competence\models\tests\runet2013\C2_16',
            'competence\models\tests\runet2013\C3_1',
            'competence\models\tests\runet2013\C3_2',
            'competence\models\tests\runet2013\C3_3',
            'competence\models\tests\runet2013\C3_4',
            'competence\models\tests\runet2013\C3_5',
            'competence\models\tests\runet2013\C3_6',
            'competence\models\tests\runet2013\C3_7',
            'competence\models\tests\runet2013\C3_8',
            'competence\models\tests\runet2013\C3_9',
            'competence\models\tests\runet2013\C3_10',
            'competence\models\tests\runet2013\C3_11',
            'competence\models\tests\runet2013\C3_12',
            'competence\models\tests\runet2013\C3_13',
            'competence\models\tests\runet2013\C3_14',
            'competence\models\tests\runet2013\C3_15',
            'competence\models\tests\runet2013\C3_16',
            'competence\models\tests\runet2013\C4_1',
            'competence\models\tests\runet2013\C4_2',
            'competence\models\tests\runet2013\C4_3',
            'competence\models\tests\runet2013\C4_4',
            'competence\models\tests\runet2013\C4_5',
            'competence\models\tests\runet2013\C4_6',
            'competence\models\tests\runet2013\C4_7',
            'competence\models\tests\runet2013\C4_8',
            'competence\models\tests\runet2013\C4_9',
            'competence\models\tests\runet2013\C4_10',
            'competence\models\tests\runet2013\C4_11',
            'competence\models\tests\runet2013\C4_12',
            'competence\models\tests\runet2013\C4_13',
            'competence\models\tests\runet2013\C4_14',
            'competence\models\tests\runet2013\C4_15',
            'competence\models\tests\runet2013\C4_16',
            'competence\models\tests\runet2013\C5_1',
            'competence\models\tests\runet2013\C5_2',
            'competence\models\tests\runet2013\C5_3',
            'competence\models\tests\runet2013\C5_4',
            'competence\models\tests\runet2013\C5_5',
            'competence\models\tests\runet2013\C5_6',
            'competence\models\tests\runet2013\C5_7',
            'competence\models\tests\runet2013\C5_8',
            'competence\models\tests\runet2013\C5_9',
            'competence\models\tests\runet2013\C5_10',
            'competence\models\tests\runet2013\C5_11',
            'competence\models\tests\runet2013\C5_12',
            'competence\models\tests\runet2013\C5_13',
            'competence\models\tests\runet2013\C5_14',
            'competence\models\tests\runet2013\C5_15',
            'competence\models\tests\runet2013\C5_16',
            'competence\models\tests\runet2013\C5A_1',
            'competence\models\tests\runet2013\C5A_2',
            'competence\models\tests\runet2013\C5A_3',
            'competence\models\tests\runet2013\C5A_4',
            'competence\models\tests\runet2013\C5A_5',
            'competence\models\tests\runet2013\C5A_6',
            'competence\models\tests\runet2013\C5A_7',
            'competence\models\tests\runet2013\C5A_8',
            'competence\models\tests\runet2013\C5A_9',
            'competence\models\tests\runet2013\C5A_10',
            'competence\models\tests\runet2013\C5A_11',
            'competence\models\tests\runet2013\C5A_12',
            'competence\models\tests\runet2013\C5A_13',
            'competence\models\tests\runet2013\C5A_14',
            'competence\models\tests\runet2013\C5A_15',
            'competence\models\tests\runet2013\C5A_16',
            'competence\models\tests\runet2013\C8_1',
            'competence\models\tests\runet2013\C8_2',
            'competence\models\tests\runet2013\C8_3',
            'competence\models\tests\runet2013\C8_4',
            'competence\models\tests\runet2013\C8_5',
            'competence\models\tests\runet2013\C8_6',
            'competence\models\tests\runet2013\C8_7',
            'competence\models\tests\runet2013\C8_8',
            'competence\models\tests\runet2013\C8_9',
            'competence\models\tests\runet2013\C8_10',
            'competence\models\tests\runet2013\C8_11',
            'competence\models\tests\runet2013\C8_12',
            'competence\models\tests\runet2013\C8_13',
            'competence\models\tests\runet2013\C8_14',
            'competence\models\tests\runet2013\C8_15',
            'competence\models\tests\runet2013\C8_16',
            'competence\models\tests\runet2013\C9_1',
            'competence\models\tests\runet2013\C9_2',
            'competence\models\tests\runet2013\C9_3',
            'competence\models\tests\runet2013\C9_4',
            'competence\models\tests\runet2013\C9_5',
            'competence\models\tests\runet2013\C9_6',
            'competence\models\tests\runet2013\C9_7',
            'competence\models\tests\runet2013\C9_8',
            'competence\models\tests\runet2013\C9_9',
            'competence\models\tests\runet2013\C9_10',
            'competence\models\tests\runet2013\C9_11',
            'competence\models\tests\runet2013\C9_12',
            'competence\models\tests\runet2013\C9_13',
            'competence\models\tests\runet2013\C9_14',
            'competence\models\tests\runet2013\C9_15',
            'competence\models\tests\runet2013\C9_16',
            'competence\models\tests\runet2013\D1',
            'competence\models\tests\runet2013\D2',
            'competence\models\tests\runet2013\D3',
            'competence\models\tests\runet2013\D4',
            'competence\models\tests\runet2013\D5',
            'competence\models\tests\runet2013\D6',
            'competence\models\tests\runet2013\D7',
        ];
    }
}