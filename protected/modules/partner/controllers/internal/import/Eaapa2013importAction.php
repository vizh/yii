<?php
namespace partner\controllers\internal;

use CText;

class Eaapa2013importAction extends \partner\components\Action
{
    const Path = '/files/eaapa2013/';
    const EventId = 461;

    private $newRocId = [];
    private $oldRocId = [];
    private $newParticipants = [];

    public function run()
    {
        echo 'now not use';
        return;

        $fieldMap = [
            'Status' => 0,
            'FirstName' => 1,
            'LastName' => 2,
            'FatherName' => 3,
            'Email' => 4,
            'Company' => 5,
            'Position' => 6,
        ];
        $fileName = 'eaapa2.csv';

        $parser = new \application\components\parsing\CsvParser($_SERVER['DOCUMENT_ROOT'].self::Path.$fileName);
        $parser->SetInEncoding('utf-8');
        $results = $parser->Parse($fieldMap, true);

//    $page = 'additional';
//    $results = array_slice($results, 0, 200);
//    foreach ($results as $row)
//    {
//      $user = $this->getUser($row);
//      if (empty($user))
//      {
//        echo '------------- error user --------- <br><pre>';
//        print_r($row);
//        echo '</pre><br>';
//        continue;
//      }
//
//      $this->processUser($user, $row);
//    }

        echo 'page '.$page.' import done!!!!';

        echo '------------- new RocId --------- <br><pre>';
        echo implode(', ', $this->newRocId);
        print_r($this->newRocId);
        echo '</pre><br>';

        echo '------------- old RocId --------- <br><pre>';
        echo implode(', ', $this->oldRocId);
        print_r($this->oldRocId);
        echo '</pre><br>';

        echo '------------- new Participants --------- <br><pre>';
        echo implode(', ', $this->newParticipants);
        print_r($this->newParticipants);
        echo '</pre><br>';
    }

    /**
     * @param $row
     * @return \user\models\User
     */
    private function getUser($row)
    {
        $user = null;
        $isNewUser = true;

        if (!empty($row->Email)) {
            $user = \user\models\User::GetByEmail($row->Email);
            if (!empty($user) && $user->CreationTime > 1360622589 - 24 * 3600) {
                $user = null;
            }
        } else {
            $row->Email = CText::generateFakeEmail('eaapa', 'rocid.ru');
        }

        if (empty($user)) {
            $user = new \user\models\User();
            $user->FirstName = $row->FirstName;
            $user->LastName = $row->LastName;
            $user->FatherName = $row->FatherName;
            $user->Password = substr(md5($row->Email.$row->LastName), 5, 10);
            $user->Email = $row->Email;

            if (!$user->validate() && $user->hasErrors('Email')) {
                $user->Email = CText::generateFakeEmail('eaapa', 'rocid.ru');
            }

            if (!$user->validate()) {
                echo '--------- user errors ---------<br><pre>';
                print_r($user->getErrors());
                echo '</pre><br><br>';
                return null;
            }

            $user->Register();

            $this->newRocId[] = $user->RocId;
        } else {
            $this->oldRocId[] = $user->RocId;
            $isNewUser = false;
        }

        if (!empty($row->Company)) {
            $flag = true;
            if (!$isNewUser) {
                $employment = $user->GetPrimaryEmployment();
                if (!empty($employment) && $employment->Company->Name == $row->Company) {
                    $flag = false;
                }
            }

            if ($flag) {
                $companyInfo = \company\models\Company::ParseName($row->Company);
                $company = \company\models\Company::GetCompanyByName($companyInfo['name']);
                if (empty($company)) {
                    $company = new \company\models\Company();
                    $company->Name = $companyInfo['name'];
                    $company->Opf = $companyInfo['opf'];
                    $company->save();
                }

                $employment = new \user\models\Employment();
                $employment->UserId = $user->UserId;
                $employment->CompanyId = $company->CompanyId;
                $employment->StartWorking = '9999-00-00';
                $employment->FinishWorking = '9999-00-00';
                $employment->Primary = 1;
                if (!empty($row->Position)) {
                    $employment->Position = $row->Position;
                }
                $employment->save();
            }
        }

        return $user;
    }

    /**
     * @param \user\models\User $user
     * @param \stdClass $row
     */
    private function processUser($user, $row)
    {
        $event = \event\models\Event::GetById(self::EventId);

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
                $roleId = null;
        }
        $role = \event\models\Role::GetById($roleId);
        if (empty($role)) {
            echo '------------- error role --------- <br><pre>';
            print_r($row);
            echo '</pre><br>';
            return;
        }

        $participant = $event->RegisterUser($user, $role);
        if (empty($participant)) {
            /** @var $participant \event\models\Participant */
            $participant = \event\models\Participant::model()
                ->byEventId($event->EventId)
                ->byUserId($user->UserId)->find();
            $participant->UpdateRole($role);
        } else {
            $this->newParticipants[] = $user->RocId;
        }
    }
}
