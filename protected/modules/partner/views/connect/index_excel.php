<?php
\Yii::import('ext.PHPExcel.PHPExcel', true);

use application\modules\partner\models\search\Meeting;
use event\models\Event;
use partner\components\Controller;

/**
 * @var Meeting $search
 * @var Event $event
 * @var Controller $this
 */

$excel = new \PHPExcel();
$excel->setActiveSheetIndex(0);
$sheet = $excel->getActiveSheet();
$sheet->setTitle('Встречи');

$sheet->setCellValueByColumnAndRow(0, 1, 'Место');

$sheet->setCellValueByColumnAndRow(1, 1, 'Пригласивший');
$sheet->mergeCellsByColumnAndRow(1,1,5,1);
$sheet->setCellValueByColumnAndRow(1, 2, 'ФИО');
$sheet->setCellValueByColumnAndRow(2, 2, 'Компания');
$sheet->setCellValueByColumnAndRow(3, 2, 'Должность');
$sheet->setCellValueByColumnAndRow(4, 2, 'Телефон');
$sheet->setCellValueByColumnAndRow(5, 2, 'Email');

$sheet->setCellValueByColumnAndRow(6, 1, 'Приглашенный');
$sheet->mergeCellsByColumnAndRow(6,1,10,1);
$sheet->setCellValueByColumnAndRow(6, 2, 'ФИО');
$sheet->setCellValueByColumnAndRow(7, 2, 'Компания');
$sheet->setCellValueByColumnAndRow(8, 2, 'Должность');
$sheet->setCellValueByColumnAndRow(9, 2, 'Телефон');
$sheet->setCellValueByColumnAndRow(10, 2, 'Email');

$sheet->setCellValueByColumnAndRow(11, 1, 'Время');
$sheet->setCellValueByColumnAndRow(12, 1, 'Статус');
$sheet->setCellValueByColumnAndRow(13, 1, 'Дата создания');

$dataProvider = $search->getDataProvider();
$dataProvider->sort->defaultOrder = '"Place"."Id" asc, "t"."Date" asc';
$dataProvider->pagination = false;

$row = 3;
foreach ($dataProvider->getData() as $item) {
    /* @var \connect\models\Meeting $item */
    if ($item->Type == \connect\models\Meeting::TYPE_PUBLIC){
        continue;
    }
    $sheet->setCellValueByColumnAndRow(0, $row, $item->Place->Name);

    $sheet->setCellValueByColumnAndRow(1, $row, $item->Creator->getFullName());
    $sheet->setCellValueByColumnAndRow(2, $row, $item->Creator->getEmploymentPrimary()->Company->Name);
    $sheet->setCellValueByColumnAndRow(3, $row, $item->Creator->getEmploymentPrimary()->Position);
    $sheet->setCellValueByColumnAndRow(4, $row, $item->Creator->PrimaryPhone);
    $sheet->setCellValueByColumnAndRow(5, $row, $item->Creator->Email);

    $sheet->setCellValueByColumnAndRow(6, $row, $item->UserLinks[0]->User->getFullName());
    $sheet->setCellValueByColumnAndRow(7, $row, $item->UserLinks[0]->User->getEmploymentPrimary()->Company->Name);
    $sheet->setCellValueByColumnAndRow(8, $row, $item->UserLinks[0]->User->getEmploymentPrimary()->Position);
    $sheet->setCellValueByColumnAndRow(9, $row, $item->UserLinks[0]->User->PrimaryPhone);
    $sheet->setCellValueByColumnAndRow(10, $row, $item->UserLinks[0]->User->Email);

    $sheet->setCellValueByColumnAndRow(11, $row, $item->Date);
    $sheet->setCellValueByColumnAndRow(12, $row, $item->getStatusText());
    $sheet->setCellValueByColumnAndRow(13, $row, $item->CreateTime);
    $row++;
}

$writer = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="report.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
unset($writer);
unset($excel);
exit;