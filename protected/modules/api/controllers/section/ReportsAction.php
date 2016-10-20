<?php
namespace api\controllers\section;

use event\models\section\LinkUser;
use event\models\section\Section;

class ReportsAction extends \api\components\Action
{
    public function run()
    {
        $section = Section::model()
            ->byEventId($this->getEvent()->Id)
            ->byDeleted(false)
            ->findByPk($this->getRequestParam('SectionId'));

        if ($section === null) {
            throw new \api\components\Exception(310, [$this->getRequestParam('SectionId')]);
        }

        $model = LinkUser::model()
            ->bySectionId($section->Id);

        if ($this->hasRequestParam('FromUpdateTime')) {
            $model->byUpdateTime($this->getRequestParam('FromUpdateTime'));
        }

        if ($this->getRequestParamBool('WithDeleted', false) !== true) {
            $model->byDeleted(false);
        }

        $linkedUsers = $model
            ->with([
                'User',
                'User.Employments.Company' => ['on' => '"Employments"."Primary"'],
                'Role',
                'Report'
            ])
            ->orderBy(['"t"."Order"' => SORT_ASC])
            ->findAll();

        $result = [];
        $builder = $this->getDataBuilder();
        foreach ($linkedUsers as $link) {
            $result[] = $builder->createReport($link);
        }

        $this->setResult($result);
    }
}
