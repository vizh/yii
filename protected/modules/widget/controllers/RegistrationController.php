<?php
use widget\components\Controller;

use \widget\models\forms\ProductCount as ProductCountForm;
use pay\components\collection\Finder;
use event\models\Participant;
use pay\components\OrderItemCollectable;
use pay\models\Account as PayAccount;
use pay\models\forms\Juridical as JuridicalForm;

class RegistrationController extends Controller
{
    protected $useBootstrap3 = true;

    protected function initResources()
    {
        parent::initResources();
        \Yii::app()->getClientScript()->registerPackage('angular');
    }

    /**
     *  Выбор кол-ва заказываемых продуктов
     */
    public function actionIndex()
    {
        $form = new ProductCountForm($this->getEvent());
        $form->clear();
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->validate()) {
                $form->pack();
                $this->redirect(['participants']);
            }
        }
        $this->render('index', ['form' => $form]);
    }

    /**
     * Регистрация пользовтелей
     */
    public function actionParticipants()
    {
        $form = new ProductCountForm($this->getEvent());
        $this->render('participants', [
            'form' => $form,
            'finder' => $this->getFinder()
        ]);
    }

    /**
     * Страница оплаты выставленных заказов
     */
    public function actionPay()
    {
        $collection = $this->getFinder()->getUnpaidFreeCollection();
        if (sizeof($collection) === 0) {
            $this->redirect(['participants']);
        }

        $account = PayAccount::model()->byEventId($this->getEvent()->Id)->find();
        $form = new ProductCountForm($this->getEvent());
        $form->clear();
        $this->render('pay', ['form' => $form, 'account' => $account]);
    }

    /**
     * Выставление юр. счета
     */
    public function actionJuridical()
    {
        $form = new JuridicalForm();
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            $form->user  = $this->getUser();
            $form->event = $this->getEvent();
            if ($form->createActiveRecord() !== null) {
                echo '
                    <script>
                        top.location.href=\''. $form->getActiveRecord()->Order->getUrl() .'\';
                    </script>
                ';
                \Yii::app()->end();
            }
        }
        $this->render('juridical', ['form' => $form]);
    }

    /**
     * Финальная страница с электронными билетами
     */
    public function actionComplete()
    {
        $participants = [];
        $finder = $this->getFinder();
        $collections = array_merge($finder->getPaidOrderCollections(), $finder->getPaidFreeCollections());
        foreach ($collections as $collection) {
            /** @var OrderItemCollectable $item */
            foreach ($collection as $item) {
                $owner = $item->getOrderItem()->getCurrentOwner();
                if (array_key_exists($owner->Id, $participants)) {
                    continue;
                }
                $participants[$owner->Id] = Participant::model()->byEventId($this->getEvent()->Id)->byUserId($owner->Id)->with('User.Settings')->find();
            }
        }
        $this->render('complete', ['participants' => $participants]);
    }

    /**
     * @return Finder
     */
    private function getFinder()
    {
        return Finder::create($this->getEvent()->Id, $this->getUser()->Id);
    }
}