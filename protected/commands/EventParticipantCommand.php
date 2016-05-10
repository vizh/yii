<?php

use application\components\console\BaseConsoleCommand;

/**
 * Class EventParticipantCommand
 */
class EventParticipantCommand extends BaseConsoleCommand
{
    /**
     * ./protected/yiic eventparticipant copy
     * Копирует пользователей из одного мероприятия в другое
     *
     * @param string   $eventIdName буквенный идентификатор мероприятия,
     *                              из котрого будут копироваться участники
     *                              (обязательный параметр)
     * @param string   $toEventIdName буквенный идентификатор мероприятия,
     *                                в которое будут копироваться участники
     *                                (обязательный параметр)
     * @param null|int $roleId id роли участников, которые будут скопированы
     *                         (если не указано, будут скопированы все)
     * @param null|int $newRoleId id роли, которая будет присвоена скопированным участникам
     *                            (если не указано, будут сохранены текущие роли)
     * @return int
     */
    public function actionCopy($eventIdName, $toEventIdName, $roleId = null, $newRoleId = null)
    {
        if (!$eventRow = $this->getEventRowByIdName($eventIdName)) {
            $this->printLine(sprintf('Event with IdName="%s" was not found.', $eventIdName));

            return 1;
        }

        if ($eventRow['PartsCount']) {
            $this->printLine(sprintf('Event "%s" has parts. This is not supported yet.', $eventIdName));

            return 1;
        }

        if (!$toEventRow = $this->getEventRowByIdName($toEventIdName)) {
            $this->printLine(sprintf('Event with IdName="%s" was not found.', $toEventIdName));

            return 1;
        }

        if ($toEventRow['PartsCount']) {
            $this->printLine(sprintf('Event "%s" has parts. This is not supported yet.', $toEventIdName));

            return 1;
        }

        if ($roleId && !$this->checkRole($roleId)) {
            $this->printLine(sprintf('Role "%s" does not exist!', $roleId));

            return 1;
        }

        if ($newRoleId && !$this->checkRole($newRoleId)) {
            $this->printLine(sprintf('Role "%s" does not exist!', $newRoleId));

            return 1;
        }

        $count = 0;

        $participants = $this->getParticipants($eventRow['Id'], $roleId);

        foreach ($participants as $participant) {
            $count = $count + Yii::app()->db->createCommand()
                    ->insert('EventParticipant', [
                        'UserId' => (int)$participant['UserId'],
                        'EventId' => (int)$toEventRow['Id'],
                        'RoleId' => (int)($newRoleId ?: $participant['RoleId']),
                    ]);
        }

        $this->printLine(sprintf('Done. %s rows inserted.', $count));

        return 0;
    }

    /**
     * @param $idName
     * @return mixed
     */
    protected function getEventRowByIdName($idName)
    {
        return Yii::app()->db->createCommand()
            ->select(['e.Id', 'COUNT(ep."Id") "PartsCount"'])
            ->from('Event e')
            ->leftJoin('EventPart ep', 'ep."EventId" = e."Id"')
            ->group('e.Id')
            ->where('e."IdName" = :idName', ['idName' => $idName])
            ->queryRow();
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
        return (bool)Yii::app()->db->createCommand()
            ->select(['Id'])
            ->from('EventRole')
            ->where('"Id" = :id', ['id' => $id])
            ->queryRow();
    }

    /**
     * @param mixed $line
     */
    protected function printLine($line)
    {
        print_r($line);
        echo PHP_EOL;
    }
}
