<?php

namespace api\controllers\user;

use api\components\Action;
use api\components\Exception;
use user\models\User;

class AddressAction extends Action
{
    public function run()
    {
        $id = \Yii::app()->getRequest()->getParam('RunetId', null);

        $user = User::model()->byRunetId($id)->find();
        if (!$user) {
            throw new Exception(202, [$id]);
        }

        $address = new \stdClass();

        $address->Country = $user->LinkAddress->Address->Country->Name;
        $address->Region = $user->LinkAddress->Address->Region->Name;
        $address->City = $user->LinkAddress->Address->City->Name;
        $address->PostCode = $user->LinkAddress->Address->PostCode;
        $address->Street = $user->LinkAddress->Address->Street;
        $address->House = $user->LinkAddress->Address->House;
        $address->Building = $user->LinkAddress->Address->Building;
        $address->Wing = $user->LinkAddress->Address->Wing;
        $address->Apartment = $user->LinkAddress->Address->Apartment;
        $address->Place = $user->LinkAddress->Address->Place;

        $this->setResult($address);
    }
} 
