<?php
namespace api\controllers\section;

use event\models\section\Section;
use Yii;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;

class ListAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Event",
     *     title="Секции",
     *     description="Список секций.",
     *     request=@Request(
     *          method="GET",
     *          url="/event/section/list",
     *          body="",
     *          params={
     *              @Param(title="FromUpdateTime", description="(Y-m-d H:i:s) - время последнего обновления секций, начиная с которого формировать список."),
     *              @Param(title="WithDeleted", description="Если параметр задан, не пустой и не приводится к false, возвращаются в том числе удаленные секции, иначе только не удаленные.")
     *          },
     *          response="[{
    'Id': 'идентификатор',
    'Title': 'название',
    'Info': 'краткое описание',
    'Start': 'время начала',
    'End': 'время окончания',
    'TypeCode': 'код типа секции',
    'Places': ['массив с названиями залов, в которых проходит секция (deprecated)'],
    'Halls': ['массив объектов Hall'],
    'Attributes': ['дополнительные аттрибуты (произвольный массив ключ =>
 значение, набор ключей и значений зависит от мероприятия)'],
    'UpdateTime': 'дата/время последнего обновления',
    'Deleted': 'true - если секция удалена, false - иначе'
}]"
     *     )
     * )
     */
    public function run()
    {
        $request = Yii::app()->getRequest();
        $withDeleted = $request->getParam('WithDeleted', false);

        $model = Section::model()
            ->byEventId($this->getEvent()->Id);

        if ($this->hasRequestParam('FromUpdateTime'))
            $model->byUpdateTime($this->getRequestedDate());

        if (!$withDeleted) {
            $model->byDeleted(false);
        }

        $this->applyFilterCriteria($model);

        $sections = $model->findAll();

        $result = [];
        foreach ($sections as $section) {
            $result[] = $this
                ->getAccount()
                ->getDataBuilder()
                ->createSection($section);
        }

        $this->setResult($result);
    }

    /**
     * @param Section $model
     * @return \CDbCriteria
     */
    private function applyFilterCriteria($model)
    {
        $fitler = Yii::app()->getRequest()->getParam('Filter', []);

        $criteria = new \CDbCriteria();
        $criteria->with = ['LinkHalls.Hall', 'Attributes'];
        $criteria->order = 't."StartTime", t."EndTime", "Hall"."Order"';

        if (!empty($fitler['Date'])) {
            $date = Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $fitler['Date']);
            $model->byDate($date);
        }

        if (!empty($fitler['Hall'])) {
            $criteria->addCondition('"Hall"."Id" = :HallId');
            $criteria->params['HallId'] = $fitler['Hall'];
        }

        if (!empty($fitler['Attributes'])) {
            $command = Yii::app()->getDb()->createCommand();
            $command->select('t.SectionId')
                ->from('EventSectionAttribute as t')
                ->leftJoin('EventSection t1', '"t"."SectionId" = "t1"."Id"')
                ->where('"t1"."EventId" = :EventId', ['EventId' => $this->getEvent()->Id]);

            $parts = [];
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

        $model->getDbCriteria()->mergeWith($criteria);
    }
}
