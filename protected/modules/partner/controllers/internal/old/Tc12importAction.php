<?php
namespace partner\controllers\internal;

use CText;

class Tc12importAction extends \partner\components\Action
{
    const Path = '/files/tc12/';
    const EventId = 391;

    private $newRocId = [];
    private $oldRocId = [];
    private $newParticipants = [];

    public function run()
    {
        return;

//    $fieldMap = array(
//      'FirstName' => 0,
//      'LastName' => 1,
//      'Company' => 2,
//      'Email' => 3,
//      'Description' => 4,
//      'Status' => 5,
//      'Comment' => 6
//    );
//
//    $fileName = 'tcfull.csv';
//
//    $parser = new \application\components\parsing\CsvParser($_SERVER['DOCUMENT_ROOT'] . self::Path . $fileName);
//    $parser->SetInEncoding('utf-8');
//    $results = $parser->Parse($fieldMap, true);
        foreach ($results as $row) {
            $user = $this->getUser($row);
            if (empty($user)) {
                echo '------------- error row --------- <br><pre>';
                print_r($row);
                echo '</pre><br>';
                continue;
            }

            $this->processUser($user, $row);
        }

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
        $rocId = intval($row->Comment);
        if ($rocId !== 0) {
            $user = \user\models\User::GetByRocid($rocId);
            if (!empty($user)) {
                return $user;
            }
        }
        if (!empty($row->Email)) {
            $user = \user\models\User::GetByEmail($row->Email);
        } else {
            $row->Email = CText::generateFakeEmail('', 'rocid.ru');
        }

        if (empty($user)) {
            $user = new \user\models\User();
            $user->FirstName = $row->FirstName;
            $user->LastName = $row->LastName;
            $user->Email = $row->Email;
            $user->Register();

            $this->newRocId[] = $user->RocId;
        } else {
            $this->oldRocId[] = $user->RocId;
        }

        $employment = $user->GetPrimaryEmployment();
        if (empty($employment) || $employment->Company->Name != $row->Company) {
            $company = new \company\models\Company();
            $company->Name = $row->Company;
            $company->setLocale('en');
            $company->Name = $row->Company;
            $company->save();

            $employment = new \user\models\Employment();
            $employment->UserId = $user->UserId;
            $employment->CompanyId = $company->CompanyId;
            $employment->Primary = 1;
            $employment->save();
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

        switch ($row->Status) {
            case 'Press':
                $roleId = 2;
                break;
            case 'Startup Alley':
                $roleId = 35;
                break;
            case 'Participant':
                $roleId = 1;
                break;
            case 'Speaker':
                $roleId = 3;
                break;
            case 'Partner':
                $roleId = 5;
                break;
            case 'Organizer':
                $roleId = 6;
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

        switch ($row->Description) {
            case 'С пакетом':
                $productId = 729;
                break;
            case 'Пакет прессы':
                $productId = 730;
                break;
            default:
                $productId = null;
        }

        $option = \pay\models\Product::GetById($productId);
        if (!empty($option)) {
            /** @var $optionOrderItem \pay\models\OrderItem */
            $optionOrderItem = \pay\models\OrderItem::model()
                ->byPayerId($user->UserId)
                ->byOwnerId($user->UserId)
                ->byProductId($option->ProductId)->find();

            if (empty($optionOrderItem)) {
                $optionOrderItem = new \pay\models\OrderItem();
                $optionOrderItem->PayerId = $user->UserId;
                $optionOrderItem->OwnerId = $user->UserId;
                $optionOrderItem->ProductId = $option->ProductId;
                $optionOrderItem->CreationTime = date('Y-m-d H:i:s');
            }
            $optionOrderItem->Paid = 1;
            $optionOrderItem->PaidTime = date('Y-m-d H:i:s');
            $optionOrderItem->Deleted = 0;
            $optionOrderItem->save();
        }
    }
}
