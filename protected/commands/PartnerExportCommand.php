<?php
use partner\models\Export;
use partner\components\export\ExcelBuilder;
use application\components\console\BaseConsoleCommand;

\Yii::import('ext.PHPExcel.PHPExcel', true);

class PartnerExportCommand extends BaseConsoleCommand
{
    private $rowIterator = 1;

    public function run($args)
    {
        $export = Export::model()->bySuccess(false)->byTotalRow(null)->find();
        if (!empty($export)) {
            $builder = new ExcelBuilder($export);
            $builder->run();
        }
    }

}