<?php
namespace partner\controllers\user;
use application\components\utility\Paginator;
use partner\models\forms\user\ParticipantSearch;
use user\models\User;


class IndexAction extends \partner\components\Action
{
    public function run()
    {
        $this->getController()->setPageTitle('Поиск участников мероприятия');
        $this->getController()->initActiveBottomMenu('index');

        $request = \Yii::app()->getRequest();

        $form = new ParticipantSearch($this->getEvent());
        $reset = $request->getParam('reset');
        if ($reset !== 'reset') {
            $form->attributes = $request->getParam(get_class($form));
        }

        $result = $form->getResult();

        $this->getController()->render('index', [
            'event' => $this->getEvent(),
            'users' => $result->users,
            'paginator' => $result->paginator,
            'form' => $form,
            'showRuventsInfo' => ($form->Ruvents == 1)
        ]);
    }
}