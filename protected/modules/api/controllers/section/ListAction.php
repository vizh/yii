<?php
namespace api\controllers\section;

class ListAction extends \api\components\Action
{
    public function run()
    {
        $sections = $this->getEvent()->Sections($this->getCriteria());

        $result = [];
        foreach ($sections as $section) {
            $result[] = $this->getAccount()->getDataBuilder()->createSection($section);
        }
        $this->setResult($result);
    }

    /**
     * @return \CDbCriteria
     */
    private function getCriteria()
    {
        $fitler = \Yii::app()->getRequest()->getParam('Filter', []);

        $criteria = new \CDbCriteria();
        $criteria->with = ['LinkHalls.Hall', 'Attributes'];
        $criteria->order = '"Sections"."StartTime", "Sections"."EndTime", "Hall"."Order"';

        if (!empty($fitler['Date'])) {
            $criteria->addCondition('"Sections"."StartTime" >= :StartTime AND "Sections"."EndTime" <= :EndTime');
            $date = \Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $fitler['Date']);
            $criteria->params['StartTime'] = $date.' 00:00:00';
            $criteria->params['EndTime'] = $date.' 23:59:59';
        }

        if (!empty($fitler['Hall'])) {
            $criteria->addCondition('"Hall"."Id" = :HallId');
            $criteria->params['HallId'] = $fitler['Hall'];
        }

        if (!empty($fitler['Attributes'])) {
            $command = \Yii::app()->getDb()->createCommand();
            $command->select('t.SectionId')
                ->from('EventSectionAttribute as t')
                ->leftJoin('EventSection t1', '"t"."SectionId" = "t1"."Id"')
                ->where('"t1"."EventId" = :EventId', ['EventId' => $this->getEvent()->Id]);

            $parts  = [];
            $params = [];
            $i = 0;
            foreach ($fitler['Attributes'] as $name => $value) {
                $paramName = 'AttrName_'.$i;
                $paramValue = 'AttrValue_'.$i;
                $parts[] = '("t"."Name" = :'.$paramName.' AND "t"."Value" = :'.$paramValue.')';
                $params[$paramName] = $name;
                $params[$paramValue] = $value;
                $i++;
            }
            $command->andWhere(implode(' OR ', $parts), $params);
            $command->group('t.SectionId');
            $command->having('count("t"."SectionId") = :CountParams', ['CountParams' => $i]);
            $criteria->addInCondition('"Sections"."Id"', $command->queryColumn());
        }

        $fromUpdateTime = \Yii::app()->getRequest()->getParam('FromUpdateTime', null);
        if ($fromUpdateTime !== null) {
            $criteria->addCondition('"Sections"."UpdateTime" > :UpdateTime');
            $criteria->params['UpdateTime'] = $fromUpdateTime;
        }

        return $criteria;
    }
}
