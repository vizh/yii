<?php
namespace pay\models;

use application\components\db\MongoLogDocument;
use application\components\helpers\ArrayHelper;

/**
 * @property int $OrderItemId
 * @property int $AttemptsQuantity
 * @property string $LastAttemptTime
 * @property bool $NotificationSent
 */
class Failure extends MongoLogDocument
{
    /**
     * @inheritdoc
     */
    public function collectionName()
    {
        return 'PayFailure';
    }

    /**
     * @param string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    /**
     * @param OrderItem $orderItem
     * @return \EMongoDocument|null|Failure
     */
    public static function setAttempt(OrderItem $orderItem)
    {
        $model = Failure::model()->findOne(['OrderItemId' => $orderItem->Id]);
        if (is_null($model)) {
            $model = new Failure;
            $model->OrderItemId = $orderItem->Id;
            $model->AttemptsQuantity = 1;
            $model->NotificationSent = false;
        } else {
            $model->AttemptsQuantity += 1;
        }
        $model->LastAttemptTime = date('Y-m-d H:i:s');
        $model->save();

        return $model;
    }

    /**
     * формирует отчет по ошибкам оплаты
     *
     * @param array $criteria
     * @return array
     */
    public static function getReport($criteria = [])
    {
        $notSent = ArrayHelper::getValue($criteria, 'notSent', false);
        //вытащим ошибки, связанные с платежными системами
        $query = \Yii::app()->getDb()->createCommand()
            ->select('
                pl."OrderId",
                NULL as "OrderItemId",
                pl."CreationTime",
                ev."Id" as "EventId",
                ev."Title" as "EventName",
                pl."Total",
                pl."Message",
                CONCAT(us."LastName", \' \', us."FirstName", \' \', us."FatherName") as "FIO",
                us."Email",
                us."PrimaryPhone" as "Phone"
            ')
            ->from('PayLog as pl')
            ->join('PayOrder as po', 'pl."OrderId" = po."Id"')
            ->join('User as us', 'po."PayerId" = us."Id"')
            ->join('Event as ev', 'po."EventId" = ev."Id"')
            ->where('pl."Error" = TRUE')
            ->andWhere('pl."Message" NOT LIKE \'%уже оплачен\'')
            //выбираем только актуальные события
            //суть выражения - если год, месяц и день не пустые - строим по ним дату и сверяем с текущей датой
            //иначе ставим текущую дату в сравнение и считаем, что это событие актуальное (так как не указано
            //его окончание)
            /*->andWhere('
                (CASE WHEN ev."EndYear" > 0 AND ev."EndMonth" > 0 AND ev."EndDay" > 0
                    THEN format(
                        \'%s-%s-%s\',
                        ev."EndYear",
                        TO_CHAR(ev."EndMonth", \'fm00\'),
                        TO_CHAR(ev."EndDay", \'fm00\')
                    )::date
                ELSE CURRENT_DATE END) >= CURRENT_DATE
            ')*/
            ->order('pl.CreationTime DESC');

        if ($notSent) {
            $query->andWhere('pl."NotificationSent" = FALSE');
        }

        $report = $query->queryAll();

        $criteria = new \EMongoCriteria();
        $criteria->compare('AttemptsQuantity', '>=2');
        if ($notSent) {
            $criteria->compare('NotificationSent', false);
        }
        $criteria->sort = ['LastAttemptTime' => -1];
        $mongoData = self::model()->findAll($criteria);
        $ids = [];
        /** @var self $doc */
        while ($doc = $mongoData->getNext()) {
            $ids[] = $doc->OrderItemId;
        }

        if (!empty($ids)) {
            //теперь вытащим инфу, когда юзверь пытался 2 и более раз оплатить
            $report2 = \Yii::app()->getDb()->createCommand()
                ->select('
                    NULL as "OrderId",
                    oi."Id" as "OrderItemId",
                    oi."CreationTime",
                    ev."Id" as "EventId",
                    ev."Title" as "EventName",
                    SUM(pp."Price") AS "Total",
                    \'Клиент пытался оплатить 2 и более раз\' AS "Message",
                    CONCAT(us."LastName", \' \', us."FirstName", \' \', us."FatherName") as "FIO",
                    us."Email",
                    us."PrimaryPhone" as "Phone"
                ')
                ->from('PayOrderItem as oi')
                ->join('PayProduct as ppr', 'ppr."Id" = oi."ProductId"')
                ->join('PayProductPrice as pp', 'pp."ProductId" = oi."ProductId"')
                ->join('Event as ev', 'ppr."EventId" = ev."Id"')
                ->join('User as us', 'oi."PayerId" = us."Id"')
                ->where('oi."Paid" = FALSE AND oi."Id" IN ('.implode(',', $ids).')', [
                    ':forHours' => date('Y-m-d H:i:s', strtotime('-4 hours'))
                ])
                //выбираем только актуальные события
                //суть выражения - если год, месяц и день не пустые - строим по ним дату и сверяем с текущей датой
                //иначе ставим текущую дату в сравнение и считаем, что это событие актуальное (так как не указано
                //его окончание)
                ->andWhere('
                    (CASE WHEN ev."EndYear" > 0 AND ev."EndMonth" > 0 AND ev."EndDay" > 0
                        THEN format(
                            \'%s-%s-%s\',
                            ev."EndYear",
                            TO_CHAR(ev."EndMonth", \'fm00\'),
                            TO_CHAR(ev."EndDay", \'fm00\')
                        )::date
                    ELSE CURRENT_DATE END) >= CURRENT_DATE
                ')
                ->order('oi.CreationTime DESC')
                ->group('
                    ev.Id,
                    oi.Id,
                    oi.CreationTime,
                    us.LastName,
                    us.FirstName,
                    us.FatherName,
                    us.Email,
                    us.PrimaryPhone
                ')
                ->queryAll();
            $report = array_merge($report, $report2);
            usort($report, function ($a, $b) {
                $at = strtotime($a['CreationTime']);
                $bt = strtotime($b['CreationTime']);
                if ($at == $bt) {
                    return 0;
                }

                return $at > $bt ? -1 : 1;
            });
        }

        return $report;
    }
}