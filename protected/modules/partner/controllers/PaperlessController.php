<?php

class PaperlessController extends \partner\components\Controller
{
    public function actions()
    {
        return [
            // Устройства
            'deviceIndex' => 'partner\controllers\paperless\device\IndexAction',
            'deviceCreate' => 'partner\controllers\paperless\device\CreateAction',
            'deviceEdit' => 'partner\controllers\paperless\device\EditAction',
            'deviceDelete' => 'partner\controllers\paperless\device\DeleteAction',
            // Материалы
            'materialIndex' => 'partner\controllers\paperless\material\IndexAction',
            'materialCreate' => 'partner\controllers\paperless\material\CreateAction',
            'materialEdit' => 'partner\controllers\paperless\material\EditAction',
            'materialDelete' => 'partner\controllers\paperless\material\DeleteAction',
            // Правила обработки
            'eventIndex' => 'partner\controllers\paperless\event\IndexAction',
            'eventCreate' => 'partner\controllers\paperless\event\CreateAction',
            'eventEdit' => 'partner\controllers\paperless\event\EditAction',
            'eventDelete' => 'partner\controllers\paperless\event\DeleteAction',
            'eventExport' => 'partner\controllers\paperless\event\ExportAction',
        ];
    }
}