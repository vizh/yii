<?php
namespace application\components\controllers\filters;

use event\models\Event;
use user\models\Referral;
use user\models\User;

class UserReferralFilter extends \CFilter
{
    const REFERRER_PARAM_NAME = 'referrer';
    const REFERRAL_SESSION_NAME = 'referral';

    private static $EVENT_PARAM_NAMES = [
        'idName',
        'eventIdName'
    ];

    /**
     * @inheritdoc
     */
    protected function preFilter($filterChain)
    {
        if ($this->getReferrer() !== null && $this->getEvent() !== null) {
            $this->createReferral();
        }

        $user = \Yii::app()->getUser()->getCurrentUser();
        if ($user !== null && $this->findCurrentReferral()) {
            $this->referral->UserId = $user->Id;
            $this->referral->save();
            \Yii::app()->getSession()->remove(self::REFERRAL_SESSION_NAME);
        }
        return true;
    }

    /**
     * @var bool|null|User
     */
    private $referrer = false;

    /**
     * @return null|User
     */
    private function getReferrer()
    {
        if ($this->referrer === false) {
            $this->referrer = null;
            $id = \Yii::app()->getRequest()->getParam(self::REFERRER_PARAM_NAME);
            if (!empty($id)) {
                $this->referrer = User::model()->byRunetId($id)->find();
            }
        }
        return $this->referrer;
    }

    /**
     * @var Event|null|false
     */
    private $event = false;

    /**
     * @return Event|null
     */
    private function getEvent()
    {
        if ($this->event === false) {
            $this->event = null;
            $request = \Yii::app()->getRequest();
            foreach (self::$EVENT_PARAM_NAMES as $name) {
                $id = $request->getParam($name);
                if (!empty($id)) {
                    $this->event = Event::model()->byIdName($id)->find();
                    break;
                }
            }
        }
        return $this->event;
    }

    /**
     * @return bool
     */
    private function findCurrentReferral()
    {
        if ($this->referral !== null) {
            return true;
        }

        $criteria = new \CDbCriteria();
        if ($this->getReferrer() !== null && $this->getEvent() !== null) {
            $criteria->addCondition('"t"."EventId" = :EventId AND "t"."ReferrerUserId" = :ReferrerUserId');
            $criteria->params['EventId'] = $this->getEvent()->Id;
            $criteria->params['ReferrerUserId'] = $this->getReferrer()->Id;
        }

        $id = \Yii::app()->getSession()->get(self::REFERRAL_SESSION_NAME);
        if (!empty($id)) {
            $this->referral = Referral::model()->byId($id)->find($criteria);
        }

        if ($this->referral === null) {
            $user = \Yii::app()->getUser()->getCurrentUser();
            if ($user !== null) {
                $this->referral = Referral::model()->byUserId($user->Id)->find($criteria);
            }
        }

        return ($this->referral !== null);
    }

    /** @var Referral|null */
    private $referral;

    /**
     * @return Referral
     */
    private function createReferral()
    {
        if (!$this->findCurrentReferral()) {
            $this->referral = new Referral();
            $this->referral->ReferrerUserId = $this->getReferrer()->Id;
            $this->referral->EventId = $this->getEvent()->Id;
            $this->referral->save();
            \Yii::app()->getSession()->add(self::REFERRAL_SESSION_NAME, $this->referral->Id);
        }
        return $this->referral;
    }

}