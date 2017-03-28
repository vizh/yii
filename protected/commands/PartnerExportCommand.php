<?php
use application\components\console\BaseConsoleCommand;
use partner\components\export\ExcelBuilder;
use partner\models\Export;

\Yii::import('ext.PHPExcel.PHPExcel', true);

class PartnerExportCommand extends BaseConsoleCommand
{
    public function run($args)
    {
        ini_set('memory_limit', '6G');

        $export = Export::model()
            ->bySuccess(false)
            ->byTotalRow(null)
            ->find();

        if ($export !== null) {
            $builder = new ExcelBuilder($export);
            $builder->run();
        }
    }

}