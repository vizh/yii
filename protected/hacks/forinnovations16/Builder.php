<?php
namespace application\hacks\forinnovations16;

use application\models\translation\ActiveRecord;
use event\models\UserData;
use pay\models\OrderItem;
use Yii;

class Builder extends \api\components\builders\Builder
{
    protected function createBaseUser($user)
    {
        $this->applyLocale($user);

        $this->user = new \stdClass();

        $this->user->RunetId = $user->RunetId;
        $this->user->LastName = $user->LastName;
        $this->user->FirstName = $user->FirstName;
        $this->user->FatherName = $user->FatherName;
        $this->user->Gender = $user->Gender;
        $this->user->FullName = $user->getFullName();

        $this->user->Photo = new \stdClass();
        $this->user->Photo->Small = 'http://'.RUNETID_HOST.$user->getPhoto()->get50px();;
        $this->user->Photo->Medium = 'http://'.RUNETID_HOST.$user->getPhoto()->get90px();
        $this->user->Photo->Large = 'http://'.RUNETID_HOST.$user->getPhoto()->get200px();
        $this->user->Photo->Original = 'http://'.RUNETID_HOST.$user->getPhoto()->getOriginal();

        $this->user->Locales = $this->getActiveRecordLocales($user);

        return $this->user;
    }

    protected function buildUserAttributes($user)
    {
        parent::buildUserAttributes($user);

        UserData::setEnableRawValues();
        $this->user->AttributesRaw = (object) UserData::getDefinedAttributeValues($this->account->Event, $user);
        UserData::setDisableRawValues();

        return $this->user;
    }

    protected function buildUserEmployment($user)
    {
        $employment = $user->getEmploymentPrimary();
        if ($employment !== null) {
            $this->user->Work = new \stdClass();
            $this->user->Work->Position = $employment->Position;
            $this->user->Work->Company = $this->createEmploymentCompany($employment->Company);
            $this->user->Work->StartYear = $employment->StartYear;
            $this->user->Work->StartMonth = $employment->StartMonth;
            $this->user->Work->EndYear = $employment->EndYear;
            $this->user->Work->EndMonth = $employment->EndMonth;

            $this->user->Locales = array_merge_recursive(
                $this->user->Locales,
                $this->getActiveRecordLocales($employment->Company, 'WorkCompany')
            );

            $position = $this->user->AttributesRaw->position;
            if (!empty($position) && is_array($position)) {
                foreach ($position as $lang => $value) {
                    if (isset($this->user->Locales[$lang])) {
                        $this->user->Locales[$lang]['WorkPositionName'] = $value;
                    }
                }
            }
        }

        return $this->user;
    }

    protected function getActiveRecordLocales(ActiveRecord $model, $prefix = '')
    {
        $locales = [];

        foreach (Yii::app()->params['Languages'] as $lang) {
            $model->setLocale($lang);
            $localeStd = [];
            foreach ($model->getTranslationFields() as $key) {
                $localeStd[$prefix.$key] = $model->{$key};
            }
            $locales[$lang] = $localeStd;
        }
        $model->resetLocale();

        return $locales;
    }

    private function getOrderItems($idList)
    {
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."OwnerId"', $idList);
        $criteria->addCondition('"t"."ChangedOwnerId" IS NULL');
        $criteria->addInCondition('"t"."ChangedOwnerId"', $idList, 'OR');

        $orderItems = OrderItem::model()
            ->byEventId($this->event->EventId)
            ->byPaid(true)
            ->findAll($criteria);

        $result = [];
        foreach ($orderItems as $item) {
            $ownerId = $item->ChangedOwnerId === null
                ? $item->OwnerId
                : $item->ChangedOwnerId;

            $result[$ownerId][] = $item;
        }

        return $result;
    }
}
