<?php
namespace event\widgets;

use event\components\Widget;
use event\components\WidgetPosition;
use event\models\Participant;
use pay\models\Account;
use pay\models\Product;
use pay\models\ProductPrice;
use Yii;

/**
 * Class Registration
 *
 * @package event\widgets
 *
 * @property string $RegistrationAfterInfo
 * @property string $RegistrationBeforeInfo
 * @property string $RegistrationTitle
 * @property string $RegistrationBuyLabel
 * @property string $RegistrationNote
 */
class Registration extends Widget
{

    /**
     * @return array
     */
    public function getAttributeNames()
    {
        return ['RegistrationAfterInfo', 'RegistrationBeforeInfo', 'RegistrationTitle', 'RegistrationBuyLabel', 'RegistrationNote'];
    }

    /**
     * @return bool
     */
    public function getIsHasDefaultResources()
    {
        return true;
    }

    public function process()
    {
        $request = Yii::app()->getRequest();
        $product = $request->getParam('product', []);
        if (!empty($product) && $request->getIsPostRequest()) {
            $this->getController()->redirect(Yii::app()->createUrl('/pay/cabinet/register', ['eventIdName' => $this->event->IdName]));
        }
    }

    /**
     * @throws \CException
     */
    public function run()
    {
        if (!$this->event->isRegistrationClosed()) {
            $account = Account::model()
                ->byEventId($this->event->Id)
                ->find();

            if ($account === null) {
                return;
            }

            /** @var Participant $participant */
            $participant = null;
            if (!Yii::app()->user->getIsGuest()) {
                if (count($this->event->Parts) == 0) {
                    $participant = Participant::model()
                        ->byUserId(Yii::app()->user->getCurrentUser()->Id)
                        ->byEventId($this->event->Id)
                        ->find();
                } else {
                    $participants = Participant::model()
                        ->byUserId(Yii::app()->user->getCurrentUser()->Id)
                        ->byEventId($this->event->Id)
                        ->findAll();
                    foreach ($participants as $p) {
                        if ($participant === null || $participant->Role->Priority < $p->Role->Priority) {
                            $participant = $p;
                        }
                    }
                }
            }

            if ($account->ReturnUrl === null) {
                Yii::app()->getClientScript()->registerPackage('runetid.event-calculate-price');
                $criteria = new \CDbCriteria();
                $criteria->order = '"t"."Priority" DESC, "t"."Id" ASC';
                $criteria->addCondition('"t"."ManagerName" != \'Ticket\'');
                $model = Product::model()->byPublic(true)->byDeleted(false);
                if (!Yii::app()->user->isGuest) {
                    $model->byUserAccess(Yii::app()->user->getCurrentUser()->Id, 'OR');
                }

                $products = $model
                    ->byEventId($this->event->Id)
                    ->findAll($criteria);

                $productsByGroup = [];
                foreach ($products as $product) {
                    if (!empty($product->GroupName)) {
                        $productsByGroup[$product->GroupName][] = $product;
                    } else {
                        $productsByGroup[] = $product;
                    }
                }

                $viewName = !$this->event->FullWidth
                    ? 'registration/index'
                    : 'fullwidth/registration';

                $criteria = new \CDbCriteria();
                $criteria->condition = 't."Price" > 0 AND "Product"."EventId" = :EventId';
                $criteria->params = ['EventId' => $this->getEvent()->Id];
                $criteria->with = ['Product' => ['together' => true, 'select' => false]];
                $paidEvent = ProductPrice::model()->byDeleted(false)->exists($criteria);

                $this->render($viewName, [
                    'products' => $products,
                    'account' => $account,
                    'participant' => $participant,
                    'productsByGroup' => $productsByGroup,
                    'paidEvent' => $paidEvent
                ]);
            } else {
                $this->render('registration-external', [
                    'account' => $account,
                    'participant' => $participant
                ]);
            }
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return Yii::t('app', 'Регистрация на мероприятии');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return WidgetPosition::Content;
    }
}