<?php
namespace ruvents\controllers\stat;

use ruvents\models\Visit;

\Yii::import('ext.PHPExcel.PHPExcel', true);

/**
 * Class DownloadFoodUsersListAction prepares and returns list of users as excel file
 */
class DownloadFoodUsersListAction extends StatAction
{
    /**
     * @inheritdoc
     * @param int $eventId Identifier of the event
     * @throws \CHttpException
     */
    public function run($eventId, $group)
    {
        $this->controller->layout = '//layouts/clear';

        $fileName = strtr($group, ['/' => '_']);

        $phpExcel = new \PHPExcel();
        $phpExcel->setActiveSheetIndex(0);
        $activeSheet = $phpExcel->getActiveSheet();
        $activeSheet->setTitle($fileName);

        $this->addHeaderRow($activeSheet);

        $dataProvider = $this->constructUsersListDataProvider($eventId, $group);

        $phpExcelWriter = \PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');

        $line = 2;
        /** @var Visit $visit */
        foreach ($dataProvider->data as $visit) {
            $this->appendRow($activeSheet, $visit, $line++);
        }

        header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=$fileName.xls");  //File name extension was wrong
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $phpExcelWriter->save('php://output');
    }

    /**
     * Устанавливает заголовки для таблицы
     * @param \PHPExcel_Worksheet $sheet
     */
    private function addHeaderRow(\PHPExcel_Worksheet $sheet)
    {
        $header = [
            'RUNET-ID',
            'Ф.И.О.',
            'Дата / время',
            'Статус',
            'Подстатус',
            'Номер команды'
        ];

        foreach ($header as $i => $value) {
            $sheet->setCellValueByColumnAndRow($i, 1, $value);
        }
    }

    /**
     * Добавляет строку участника в таблицу
     * @param \PHPExcel_Worksheet $sheet
     * @param Visit $visit
     * @param int $rowNumber
     */
    private function appendRow(\PHPExcel_Worksheet $sheet, Visit $visit, $rowNumber)
    {
        $row = [
            $visit->User->RunetId,
            $visit->User->getFullName(),
            \Yii::app()->getDateFormatter()->format('dd.MM.yyyy HH:mm:ss', $visit->CreationTime),
            $visit->Participants[0]->Role,
            $visit->UserData->getManager()->last_status,
            $visit->UserData->getManager()->team_number
        ];

        $i = 0;
        foreach ($row as $value) {
            $sheet->setCellValueExplicitByColumnAndRow(
                $i++,
                $rowNumber,
                $value,
                \PHPExcel_Cell_DataType::TYPE_STRING
            );
        }
    }
}
