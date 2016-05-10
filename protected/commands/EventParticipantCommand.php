<?php

use application\components\console\BaseConsoleCommand;

/**
 * Class EventParticipantCommand
 */
class EventParticipantCommand extends BaseConsoleCommand
{
    public function getHelp()
    {
        return parent::getHelp()."\n\n"
        ."Копирует пользователей из одного мероприятия в другое\n\n"
        ."--event=int|string Id или IdName мероприятия, из которого будут копироваться участники\n"
        ."--toEvent=int|string Id или IdName мероприятия, в которое будут копироваться участники (обязательный параметр)\n"
        ."--role=null|int Id роли участников, которые будут скопированы (если не указано, будут скопированы все)\n"
        ."--newRole=null|int Id роли, которая будет присвоена скопированным участникам (если не указано, будут сохранены текущие роли)\n\n";
    }

    /**
     * @param int|string $event
     * @param int|string $toEvent
     * @param null|int   $role
     * @param null|int   $newRole
     * @return int
     */
    public function actionCopy($event, $toEvent, $role = null, $newRole = null)
    {
        if (!$eventRow = $this->getEventRow($event)) {
            $this->usageError(sprintf('Event "%s" was not found.', $event));
        }

        if ($eventRow['PartsCount']) {
            $this->usageError(sprintf('Event "%s" has parts. This is not supported yet.', $event));
        }

        if (!$toEventRow = $this->getEventRow($toEvent)) {
            $this->usageError(sprintf('Event "%s" was not found.', $toEvent));
        }

        if ($toEventRow['PartsCount']) {
            $this->usageError(sprintf('Event "%s" has parts. This is not supported yet.', $toEvent));
        }

        if ($role) {
            $this->checkRole($role);
        }

        if ($newRole) {
            $this->checkRole($newRole);
        }

        $count = 0;

        $participants = $this->getParticipants($eventRow['Id'], $role);

        foreach ($participants as $participant) {
            $count = $count + Yii::app()->db->createCommand()
                    ->insert('EventParticipant', [
                        'UserId' => (int)$participant['UserId'],
                        'EventId' => (int)$toEventRow['Id'],
                        'RoleId' => (int)($newRole ?: $participant['RoleId']),
                    ]);
        }

        printf("Done. %s row(s) inserted.\n", $count);

        return 0;
    }

    /**
     * @param string|int $id
     * @return mixed
     */
    protected function getEventRow($id)
    {
        $command = Yii::app()->db->createCommand()
            ->select(['e.Id', 'COUNT(ep."Id") "PartsCount"'])
            ->from('Event e')
            ->leftJoin('EventPart ep', 'ep."EventId" = e."Id"')
            ->group('e.Id');

        if (is_numeric($id)) {
            $command->where('e."Id" = :id', ['id' => $id]);
        } else {
            $command->where('e."IdName" = :idName', ['idName' => $id]);
        }

        return $command->queryRow();
    }

    /**
     * @param int      $eventId
     * @param null|int $roleId
     * @return array
     */
    protected function getParticipants($eventId, $roleId = null)
    {
        $command = Yii::app()->db->createCommand()
            ->select(['UserId', 'RoleId'])
            ->from('EventParticipant')
            ->andWhere('"EventId" = :eventId', ['eventId' => $eventId]);

        if ($roleId) {
            $command->andWhere('"RoleId" = :roleId', ['roleId' => $roleId]);
        }

        return $command->queryAll();
    }

    /**
     * @param int $id
     * @return bool
     */
    protected function checkRole($id)
    {
        $role = Yii::app()->db->createCommand()
            ->select(['Id'])
            ->from('EventRole')
            ->where('"Id" = :id', ['id' => $id])
            ->queryRow();

        if (!$role) {
            $this->usageError(sprintf('Role "%s" does not exist!', $id));
        }
    }
}
