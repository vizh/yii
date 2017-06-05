<?php
namespace partner\controllers\internal;

use CText;

class Safor13importAction extends \partner\components\Action
{
    const Path = '/files/safor13/';
    const EventId = 411;
    const RoleId = 1;
    const Limit = 50;

    private $newRocId = [];
    private $oldRocId = [];
    private $newParticipants = [];

    public function run()
    {
        $fieldMap = [
            'N' => 0,
            'LastName' => 1,
            'FirstName' => 2,
            'Company' => 3,
            'Phone' => 4,
            'Email' => 5
        ];

        $fileName = 'saforfull.csv';

        $parser = new \application\components\parsing\CsvParser($_SERVER['DOCUMENT_ROOT'].self::Path.$fileName);
        $parser->SetInEncoding('utf-8');
        $results = $parser->Parse($fieldMap, true);
        $page = \Yii::app()->request->getParam('page', 0);
        $results = array_slice($results, ($page * self::Limit), self::Limit);
        foreach ($results as $row) {
            $user = $this->getUser($row);
            if (empty($user)) {
                ob_start();
                echo '------------- error row (page: '.$page.')--------- <br><pre>';
                print_r($row);
                echo '</pre><br>';
                $_SESSION['ImportResult'] .= ob_get_contents();
                ob_end_clean();
                continue;
            }

            $this->processUser($user, $row);
        }

        ob_start();
        echo '------------- new RocId (page: '.$page.')--------- <br><pre>';
        echo implode(', ', $this->newRocId);
        print_r($this->newRocId);
        echo '</pre><br>';

        echo '------------- old RocId (page: '.$page.')--------- <br><pre>';
        echo implode(', ', $this->oldRocId);
        print_r($this->oldRocId);
        echo '</pre><br>';

        echo '------------- new Participants (page: '.$page.')--------- <br><pre>';
        echo implode(', ', $this->newParticipants);
        print_r($this->newParticipants);
        echo '</pre><br>';
        $_SESSION['ImportResult'] .= ob_get_contents();
        ob_end_clean();

        if (!empty($results)) {
            echo '<meta http-equiv="Refresh" content="2;url=/internal/safor13import/?page='.($page + 1).'">';
        } else {
            echo $_SESSION['ImportResult'];
        }
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
            $user = \user\models\User::GetByEmail($row->Email, ['Employments']);
        } else {
            $row->Email = CText::generateFakeEmail('', 'rocid.ru');
        }

        if (empty($user)) {
            $user = new \user\models\User();

            $firstName = explode(' ', $row->FirstName);
            if (sizeof($firstName) > 2) {
                $firstName[1] = $firstName[1].' '.$firstName[2];
                unset($firstName[2]);
            }

            $user->FirstName = $firstName[0];
            $user->FatherName = isset($firstName[1]) ? $firstName[1] : '';
            $user->LastName = $row->LastName;
            $user->Password = substr(md5($row->Email.$row->LastName), 5, 10);
            $user->Email = $row->Email;
            if (!$user->validate()) {
                ob_start();
                echo '<pre>';
                echo '------------- error row --------- <br><pre>';
                echo \CHtml::errorSummary($user);
                print_r($row);
                echo '</pre>';
                $_SESSION['ImportResult'] .= ob_get_contents();
                ob_end_clean();
                return null;
            }
            $user->Register();
            $user->Settings->Agreement = 1;
            $user->Settings->save();
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
                $employment->save();
            }
        }

        if (!empty($row->Phone)) {
            $flag = true;
            if (!$isNewUser && !empty($user->Phones)) {
                foreach ($user->Phones as $phone) {
                    if ($phone->Phone == $row->Phone) {
                        $flag = false;
                        break;
                    }
                }
            }

            if ($flag) {
                $phone = new \contact\models\Phone();
                $phone->Phone = $row->Phone;
                $phone->save();
                $user->AddPhone($phone);
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
        $role = \event\models\Role::GetById(self::RoleId);
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
