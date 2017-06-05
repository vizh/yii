<?php
namespace widget\controllers\pay;

use pay\components\collection\Finder;
use pay\models\forms\Juridical;

class JuridicalAction extends \widget\components\pay\Action
{
    public function run()
    {
        if ($this->getAccount()->OrderLastTime !== null && $this->getAccount()->OrderLastTime < date('Y-m-d H:i:s')) {
            throw new \CHttpException(404);
        }

        $finder = Finder::create($this->getEvent()->Id, $this->getUser()->Id);
        $collection = $finder->getUnpaidFreeCollection();
        if ($collection->count() == 0) {
            $this->getController()->redirect(['/widget/pay/cabinet']);
        }

        $form = new Juridical($this->getEvent(), $this->getUser());
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->createActiveRecord() !== null) {
                echo '
                    <script>
                        top.location.href=\''.$form->getOrder()->getUrl().'\';
                    </script>
                ';
                \Yii::app()->end();
            }
        }
        $this->getController()->render('juridical', [
            'form' => $form
        ]);
    }
}
