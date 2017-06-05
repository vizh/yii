<?php
use pay\components\collection\Finder;
use pay\models\Account;
use pay\models\forms\Juridical as JuridicalForm;
use pay\models\Order;
use widget\components\Controller;

class PayButtonsController extends Controller
{
    protected $useBootstrap3 = true;

    /**
     * ����� ������� ������
     * @throws \pay\components\MessageException
     */
    public function actionIndex()
    {
        $account = Account::model()->byEventId($this->getEvent()->Id)->find();

        $total = 0;

        $finder = Finder::create($this->getEvent()->Id, $this->getUser()->Id);
        foreach ($finder->getUnpaidFreeCollection() as $item) {
            $total += $item->getPriceDiscount();
        }

        $this->render('index', ['account' => $account, 'total' => $total]);
    }

    /**
     * ����������� ��. �����
     */
    public function actionJuridical()
    {

        $form = new JuridicalForm();
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();

            $form->user = $this->getUser();
            $form->event = $this->getEvent();
            if ($form->createActiveRecord() !== null) {
                $this->redirect(['success', 'id' => $form->getActiveRecord()->OrderId, 'system' => 'juridical']);
            }
        }
        $this->render('juridical', ['form' => $form]);
    }

    /**
     * ��������� �� �������� ������ �����
     * @param int $id Id �����
     * @param string $system
     * @throws CHttpException
     */
    public function actionSuccess($id, $system)
    {
        $order = Order::model()->byEventId($this->getEvent()->Id)->findByPk($id);
        if ($order === null) {
            throw new \CHttpException(404);
        }
        $this->render('success', ['system' => $system, 'order' => $order]);
    }
}