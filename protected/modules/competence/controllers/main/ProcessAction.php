<?php
namespace competence\controllers\main;

use pay\models\Coupon;
use pay\models\CouponActivation;

/**
 * Class ProcessAction
 * @package competence\controllers\main
 *
 * @method \MainController getController()
 */
class ProcessAction extends \CAction
{
    public function run($id)
    {
        $this->getController()->setPageTitle(strip_tags($this->getController()->getTest()->Title));
        $this->getController()->layout = "interview";

        $request = \Yii::app()->getRequest();
        $question = null;
        $currentQuestion = $this->getQuestion();
        $currentQuestion->Test = $this->getController()->getTest();
        $form = $currentQuestion->getForm();
        $form->setAttributes($request->getParam(get_class($form)), false);
        if ($request->getIsPostRequest() && $form->process()) {
            $prev = $request->getParam('prev');
            if (empty($prev)) {
                $question = $form->getNext();
            } else {
                $prevQuestion = $form->getPrev();
                $question = !empty($prevQuestion) ? $prevQuestion : $currentQuestion;
            }

            if ($question == null) {
                $this->finalizeInterview();
            }
            $question->Test = $this->getController()->getTest();

            $result = $question->getResult();
            if (!empty($result)) {
                $question->getForm()->setAttributes($result, false);
            }
        }

        $this->getController()->question = $question == null ? $currentQuestion : $question;

        $form = $this->getController()->question->getForm();
        $this->getController()->render($form->getViewPath(), ['form' => $form]);
    }

    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    private function getQuestion()
    {
        $request = \Yii::app()->getRequest();
        $id = $request->getParam('question');
        $question = \competence\models\Question::model()->findByPk($id);
        $test = $this->getController()->getTest();
        if ($question == null)
        {
            return $test->getFirstQuestion();
        }
        elseif ($question->TestId == $test->Id)
        {
            return $question;
        }
        else
            throw new \application\components\Exception('Вопрос с id: ' . $id . ' не найден в тесте ' . $test->Id);
    }

    private function finalizeInterview()
    {
        $test = $this->getController()->getTest();
        $test->saveResult();


        if ($test->Id == 12) {
            $user = \Yii::app()->user->getCurrentUser();
            $couponActivation = CouponActivation::model()->byUserId($user->Id)->byEventId(889)->find();
            if ($couponActivation === null || $couponActivation->Coupon->Discount < 0.25) {
                $coupon = new Coupon();
                $coupon->EventId = 889;
                $coupon->Discount = 0.25;
                $coupon->Code = $coupon->generateCode();
                $coupon->save();

                $coupon->activate($user, $user);
            }
        }

        $this->getController()->redirect(\Yii::app()->createUrl('/competence/main/end', ['id' => $test->Id]));
    }
}