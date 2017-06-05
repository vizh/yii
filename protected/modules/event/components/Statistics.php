<?php
namespace event\components;

class Statistics
{
    private $eventId;

    /**
     * @param int $eventId
     */
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    private $startDate = null;

    /**
     * @return string|false
     */
    public function getStartDate()
    {
        if ($this->startDate === null) {
            $this->startDate = \Yii::app()->db->createCommand()
                ->select('DATE("t"."CreationTime")')->from('EventParticipantLog t')
                ->where('"t"."EventId" = :eventId', ['eventId' => $this->eventId])
                ->order('CreationTime')->limit(1)
                ->queryScalar();
        }
        return $this->startDate;
    }

    private $endDate = null;

    /**
     * @return string|false
     */
    public function getEndDate()
    {
        if ($this->endDate === null) {
            $this->endDate = \Yii::app()->db->createCommand()
                ->select('DATE("t"."CreationTime")')->from('EventParticipantLog t')
                ->where('"t"."EventId" = :eventId', ['eventId' => $this->eventId])
                ->order('CreationTime DESC')->limit(1)
                ->queryScalar();
        }
        return $this->endDate;
    }

    private $dates = null;

    /**
     * @return array
     */
    public function getDates()
    {
        if ($this->dates === null) {
            $dateFormatter = new \CDateFormatter(\Yii::app()->locale);
            $this->dates = [];
            if ($this->getStartDate() !== false) {
                $startDate = new \DateTime($this->getStartDate());
                $endDate = new \DateTime($this->getEndDate());
                do {
                    $this->dates[] = $dateFormatter->format('d MMM', $startDate->getTimestamp());
                    $startDate->add(new \DateInterval('P1D'));
                } while ($startDate->format('Y-m-d') <= $endDate->format('Y-m-d'));
            }
        }

        return $this->dates;
    }

    private $roles = null;

    /**
     * @return \event\models\Role[]
     */
    public function getRoles()
    {
        if ($this->roles === null) {
            $roles = \event\models\Role::model()->findAll([
                'condition' => '"EventId" = :eventId',
                'params' => [':eventId' => $this->eventId],
                'join' => 'INNER JOIN "EventParticipant" "p" ON "t"."Id" = "p"."RoleId"',
                'group' => '"t"."Id"',
                'order' => 'COUNT("t"."Id")'
            ]);
            $this->roles = [];
            foreach ($roles as $role) {
                $this->roles[$role->Id] = $role;
            }
        }
        return $this->roles;
    }

    /**
     * @return string[]
     */
    public function getRolesTitle()
    {
        $result = [];
        foreach ($this->getRoles() as $role) {
            $result[] = $role->Title;
        }
        return $result;
    }

    private $dummy = null;

    public function getDummy()
    {
        if ($this->dummy === null) {
            $this->dummy = [];
            foreach ($this->getDates() as $date) {
                $this->dummy[$date] = [];
                foreach ($this->getRoles() as $role) {
                    $this->dummy[$date][$role->Id] = 0;
                }
            }
        }
        return $this->dummy;
    }

    public function getRegistrationsAll()
    {
        if ($this->getStartDate() === false) {
            return [];
        }

        $stats = \Yii::app()->db->createCommand()
            ->select('"RoleId", CAST("CreationTime" AS DATE) as "Date", count("UserId") AS "Count"')
            ->from('(SELECT DISTINCT ON ("UserId") "UserId", "RoleId", "CreationTime" FROM "EventParticipantLog"
      WHERE "EventId" = :eventId ORDER BY "UserId", "CreationTime" DESC) p')
            ->group('"RoleId", CAST("CreationTime" AS DATE)')
            ->order('CAST("CreationTime" AS DATE)')
            ->query(['eventId' => $this->eventId]);

        $dateFormatter = new \CDateFormatter(\Yii::app()->locale);
        $dummy = $this->getDummy();
        foreach ($stats as $row) {
            $roleId = $row['RoleId'];
            $date = $dateFormatter->format('d MMM', strtotime($row['Date']));
            $dummy[$date][$roleId] = $row['Count'];
        }

        $result = [];
        $all = [];

        foreach ($dummy as $date => $roles) {
            $row = [$date];

            foreach ($roles as $roleId => $count) {
                if (!isset($this->getRoles()[$roleId])) {
                    continue;
                }
                if (!isset($all[$roleId])) {
                    $all[$roleId] = 0;
                }
                $all[$roleId] += $count;
                $row[] = $all[$roleId];
            }
            $result[] = $row;
        }
        return $result;
    }

    public function getRegistrationsDelta()
    {
        if ($this->getStartDate() === false) {
            return [];
        }

        $stats = \Yii::app()->db->createCommand()
            ->select('"RoleId", CAST("p"."CreationTime" AS DATE) AS "Date", COUNT("UserId") AS "Count"')
            ->from('EventParticipantLog p')->where('"p"."EventId" = :eventId')
            ->group('CAST("p"."CreationTime" AS DATE), p."RoleId"')
            ->order('CAST("p"."CreationTime" AS DATE)')
            ->query(['eventId' => $this->eventId]);

        $dateFormatter = new \CDateFormatter(\Yii::app()->locale);
        $dummy = $this->getDummy();
        foreach ($stats as $row) {
            $roleId = $row['RoleId'];
            $date = $dateFormatter->format('d MMM', strtotime($row['Date']));
            $dummy[$date][$roleId] = intval($row['Count']);
        }

        $result = [];

        foreach ($dummy as $date => $roles) {
            $row = [$date];
            foreach ($roles as $roleId => $count) {
                if (!isset($this->getRoles()[$roleId])) {
                    continue;
                }
                $row[] = $count;
            }
            $result[] = $row;
        }
        return $result;
    }

    /**
     * @param int[] $products
     * @return string
     */
    private function getOrderItemsQuery($products = [])
    {
        $query = 'SELECT
CASE
	WHEN poi."ChangedOwnerId" IS NULL THEN poi."OwnerId"
	ELSE poi."ChangedOwnerId"
END "ItemOwner"

FROM "PayOrderItem" poi

LEFT JOIN "PayCouponActivationLinkOrderItem" pcaoi
ON pcaoi."OrderItemId" = poi."Id"

LEFT JOIN "PayCouponActivation" pca
ON pca."Id" = pcaoi."CouponActivationId"

LEFT JOIN "PayCoupon" pc
ON pc."Id" = pca."CouponId"

WHERE poi."Paid"';
        if (count($products) > 0) {
            $query .= sprintf(' AND poi."ProductId" IN (%s)', implode(',', $products));
        } else {
            $query .= ' AND FALSE';
        }

        return $query;
    }

    public function getPayments()
    {
        if ($this->getStartDate() === false) {
            return [];
        }

        $result = [];

        $products = \pay\models\Product::model()->byEventId($this->eventId)
            ->findAll('t."ManagerName" ILIKE :ManagerName', ['ManagerName' => 'Event%']);
        $productsId = [];
        foreach ($products as $product) {
            $productsId[] = $product->Id;
        }

        // FIRST COLUMN
        $stats = \Yii::app()->db->createCommand()
            ->select('p."RoleId", count(p."RoleId") "Count"')
            ->from('EventParticipant p')
            ->where('p."EventId" = :EventId AND p."UserId" IN ('.$this->getOrderItemsQuery($productsId).' AND (pc."IsTicket" OR (pc."Discount" != 100 OR pc."ManagerName" != \'Percent\') OR pc."Id" IS NULL)'.')')
            ->group('p.RoleId')->query(['EventId' => $this->eventId]);

        $dummy = [];
        foreach ($stats as $row) {
            $dummy[$row['RoleId']] = $row['Count'];
        }
        $column = ['Оплатили участие'];
        foreach ($this->getRoles() as $role) {
            $column[] = isset($dummy[$role->Id]) ? intval($dummy[$role->Id]) : 0;
        }
        $result[] = $column;

        //SECOND COLUMN
        $stats = \Yii::app()->db->createCommand()
            ->select('p."RoleId", count(p."RoleId") "Count"')
            ->from('EventParticipant p')
            ->where('p."EventId" = :EventId AND p."UserId" IN ('.$this->getOrderItemsQuery($productsId).' AND NOT pc."IsTicket" AND pc."Discount" = 1'.')')
            ->group('p.RoleId')->query(['EventId' => $this->eventId]);

        $dummy = [];
        foreach ($stats as $row) {
            $dummy[$row['RoleId']] = $row['Count'];
        }
        $column = ['Активировали 100% промо-коды'];
        foreach ($this->getRoles() as $role) {
            $column[] = isset($dummy[$role->Id]) ? intval($dummy[$role->Id]) : 0;
        }
        $result[] = $column;

        //THIRD COLUMN
        $stats = \Yii::app()->db->createCommand()
            ->select('p."RoleId", count(p."RoleId") "Count"')
            ->from('EventParticipant p')
            ->where('p."EventId" = :EventId AND p."UserId" NOT IN ('.$this->getOrderItemsQuery($productsId).')')
            ->group('p.RoleId')->query(['EventId' => $this->eventId]);

        $dummy = [];
        foreach ($stats as $row) {
            $dummy[$row['RoleId']] = $row['Count'];
        }
        $column = ['Прямое проставление статуса'];
        foreach ($this->getRoles() as $role) {
            $column[] = isset($dummy[$role->Id]) ? intval($dummy[$role->Id]) : 0;
        }
        $result[] = $column;

        return $result;
    }

    public function getCount()
    {
        if ($this->getStartDate() === false) {
            return [];
        }

        $stats = \Yii::app()->db->createCommand()
            ->select('p."RoleId", count(p."RoleId") "Count"')
            ->from('EventParticipant p')
            ->where('p."EventId" = :EventId')
            ->group('p.RoleId')->query(['EventId' => $this->eventId]);
        $dummy = [];
        foreach ($stats as $row) {
            $dummy[$row['RoleId']] = $row['Count'];
        }
        $result = [];
        foreach ($this->getRoles() as $role) {
            $result[] = [$role->Title, isset($dummy[$role->Id]) ? intval($dummy[$role->Id]) : 0];
        }
        return $result;
    }

}