<?php
namespace api\controllers\section;

use event\models\section\LinkUser;
use event\models\section\Section;

class ReportsAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $sectionId = $request->getParam('SectionId');
        $fromUpdateTime = $request->getParam('FromUpdateTime');
        $withDeleted = $request->getParam('WithDeleted', false);

        $section = Section::model()->byDeleted(false)->findByPk($sectionId);
        if ($section === null)
            throw new \api\components\Exception(310, [$sectionId]);
        if ($section->EventId != $this->getEvent()->Id)
            throw new \api\components\Exception(311);

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'User',
            'User.Employments.Company' => ['on' => '"Employments"."Primary"'],
            'Role',
            'Report'
        ];

        $model = LinkUser::model()->bySectionId($section->Id);
        if ($fromUpdateTime !== null) {
            $model->byUpdateTime($fromUpdateTime);
        }
        if (!$withDeleted) {
            $model->byDeleted(false);
        }
        $linkUsers = $model->findAll();

        $result = [];
        foreach ($linkUsers as $link) {
            $result[] = $this->getAccount()->getDataBuilder()->createReport($link);
        }

        $this->setResult($result);
    }
}
