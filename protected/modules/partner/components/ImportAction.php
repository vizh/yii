<?php
namespace partner\components;

use CText;

abstract class ImportAction extends Action
{
    const ByStep = 200;

    /**
     * @return int
     */
    abstract public function getEventId();

    /**
     * @return array
     */
    abstract public function getFieldMap();

    /**
     * @return bool
     */
    abstract public function getIsUserVisible();

    /**
     * @return bool
     */
    abstract public function getIsNotify();

    /**
     * @return string
     */
    abstract public function getFileName();

    /**
     * @return bool
     */
    abstract public function getIsEnable();

    /**
     * @return bool
     */
    abstract public function getIsDebug();

    protected $newRunetId = [];
    protected $oldRunetId = [];

    /** @var string */
    private $path;

    /**
     * @return string
     */
    public function getPath()
    {
        if ($this->path === null) {
            $path = \Yii::getPathOfAlias('partner.data');
            $this->path = $path.DIRECTORY_SEPARATOR.$this->getEventId().DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR;
            if (!file_exists($this->path)) {
                mkdir($this->path, 0755, true);
            }
        }
        return $this->path;
    }

    public function run()
    {
        if (!$this->getIsEnable()) {
            echo 'Импорт отключен';
            return;
        }

        if ($this->getEvent()->Id !== $this->getEventId()) {
            echo 'Не верный импортер для мероприятия';
            return;
        }

        $parser = new \application\components\parsing\CsvParser($this->getPath().$this->getFileName());
        $parser->SetInEncoding('utf-8');

        $step = (int)\Yii::app()->getRequest()->getParam('step');
        $results = $parser->Parse($this->getFieldMap(), true);
        if ($this->getIsDebug()) {
            $this->showMessage('---- debug info ----', $results);

            foreach ($results as $row) {
                $roleId = $this->getRoleId($row);
                if (empty($roleId)) {
                    $this->showMessage('------------- error role ----------', $row);
                }
            }

            $row = new \stdClass();
            $row->FirstName = 'Виталий';
            $row->LastName = 'Никитин';
            $row->FatherName = '';
            $row->Email = 'al.aris.nik@gmail.com';
            $row->Phone = '';
            $row->Company = '';
            $row->Position = '';
            $row->Status = 'участник';

            $results = [];
            $results[] = $row;
        }

        $results = array_slice($results, $step * self::ByStep, self::ByStep);
        foreach ($results as $row) {
            $user = $this->getUser($row);
            if ($user === null) {
                $this->showMessage('------------- error user -----------', $row);
                continue;
            }
            $this->processUser($user, $row);
        }

        $this->showMessage('--- old users ---', $this->oldRunetId);
        $this->showMessage('--- new users ---', $this->newRunetId);

        echo sizeof($results);
    }

    protected function showMessage($message, $row)
    {
        echo $message.'<br>';
        echo '<pre>';
        print_r($row);
        echo '</pre>';
    }

    /**
     * @param \stdClass $row
     *
     * @return \user\models\User
     */
    private function getUser($row)
    {
        $user = null;

        if (empty($row->Email)) {
            $row->Email = CText::generateFakeEmail($this->getEventId());
        }

        $user = \user\models\User::model()->byEmail($row->Email)->find();
        if ($user !== null) {
            $this->oldRunetId[] = $user->RunetId;
        }

        if ($user === null) {
            $user = new \user\models\User();
            $user->FirstName = !empty($row->FirstName) ? $row->FirstName : '-';
            $user->LastName = !empty($row->LastName) ? $row->LastName : '-';
            $user->FatherName = $row->FatherName;
            $user->Email = strtolower($row->Email);
            $user->register($this->getIsNotify());

            $user->Visible = $this->getIsUserVisible();
            $user->save();

            $this->newRunetId[] = $user->RunetId;
        }

        if (!empty($row->Company)) {
            try {
                $user->setEmployment($row->Company, !empty($row->Position) ? $row->Position : '');
            } catch (\application\components\Exception $e) {
                $this->showMessage('--- bad company ---', $row);
            }
        }

        if (!empty($row->Phone)) {
            $user->setContactPhone($row->Phone);
        }

        return $user;
    }

    /**
     * @param \stdClass $row
     *
     * @return int
     */
    protected function getRoleId($row)
    {
        $row->Status = trim($row->Status);
        switch ($row->Status) {
            case 'Виртуальный посетитель':
                $roleId = 37;
                break;
            case 'Участник':
                $roleId = 1;
                break;
            case 'СМИ':
                $roleId = 2;
                break;
            case 'Платная программа посещение мастер-классов':
                $roleId = 39;
                break;
            case 'Организатор':
                $roleId = 6;
                break;
            case 'Посетитель':
                $roleId = 38;
                break;
            case 'посетитель':
                $roleId = 38;
                break;
            default:
                $roleId = 0;
        }

        return $roleId;
    }

    /**
     * @param \user\models\User $user
     * @param \stdClass $row
     */
    private function processUser($user, $row)
    {
        $event = $this->getEvent();

        $roleId = $this->getRoleId($row);

        /** @var $role \event\models\Role */
        $role = \event\models\Role::model()->findByPk($roleId);
        if (empty($role)) {
            $this->showMessage('------------- error role ----------', $row);
            return;
        }

        $event->skipOnRegister = true;
        if (sizeof($event->Parts) == 0) {
            $event->RegisterUser($user, $role);
        } else {
            $event->registerUserOnAllParts($user, $role);
        }
    }
}