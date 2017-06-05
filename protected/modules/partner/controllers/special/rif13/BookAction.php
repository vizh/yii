<?php
namespace partner\controllers\special\rif13;

class BookAction extends \partner\components\Action
{
    public function run()
    {
        $datesIn = ['2013-04-16' => '2013-04-16', '2013-04-17' => '2013-04-17', '2013-04-18' => '2013-04-18'];
        $datesOut = ['2013-04-17' => '2013-04-17', '2013-04-18' => '2013-04-18', '2013-04-19' => '2013-04-19'];

        $result = false;
        $request = \Yii::app()->getRequest();
        $form = new \partner\models\forms\special\rif13\Book();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate()) {
            try {
                $result = $form->bookRoom();
                $form = new \partner\models\forms\special\rif13\Book();
            } catch (\Exception $e) {
                $form->addError('RunetId', $e->getMessage());
            }
        }

        $this->getController()->render('rif13/book', [
            'datesIn' => $datesIn,
            'datesOut' => $datesOut,
            'form' => $form,
            'result' => $result
        ]);
    }
}
