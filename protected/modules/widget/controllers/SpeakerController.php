<?php
use \user\models\User;
use \application\components\utility\Paginator;

class SpeakerController extends \widget\components\Controller
{
    const USERS_PER_PAGE = 21;

    protected function getWidgetParamNames()
    {
        return ['styles'];
    }

    public function actionIndex()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';
        $criteria->addCondition('"t"."Id" IN ('. $this->getBaseCondition() .')');
        $criteria->params['EventId'] = $this->getEvent()->Id;
        $criteria->with = ['Settings', 'Employments.Company'];

        $char = \Yii::app()->getRequest()->getParam('char');
        if ($char !== null) {
            $criteria->addCondition('"t"."LastName" ILIKE :Char');
            $criteria->params['Char'] = $char.'%';
        }

        $paginator = new Paginator(User::model()->count($criteria));
        $paginator->perPage = self::USERS_PER_PAGE;
        $criteria->mergeWith($paginator->getCriteria());

        $users = User::model()->findAll($criteria);

        if ($this->getWidgetParamValue('styles') !== null) {
            \Yii::app()->getClientScript()->registerCss($this->getId(), $this->getWidgetParamValue('styles'));
        }

        $this->render('index', ['users' => $users, 'alphabet' => $this->getAlphabet(), 'paginator' => $paginator, 'char' => $char]);

    }

    private function getAlphabet()
    {
        $command = \Yii::app()->getDb()->createCommand();
        $command->select('upper(substring("LastName", 1, 1)) as "FirshChar"')
            ->from('User')->where('"User"."Id" IN ('. $this->getBaseCondition() .')', ['EventId' => $this->getEvent()->Id])
            ->group('FirshChar')->order('FirshChar ASC');

        $result = new \stdClass();
        $result->ru = [];
        $result->en = [];
        foreach ($command->queryColumn() as $char) {
            $result->{preg_match('/[^A-Za-z]/i', $char) === 0 ? 'en' : 'ru'}[] = $char;
        }
        return $result;
    }

    private $baseCondition = null;

    /**
     * @return CDbCriteria
     */
    private function getBaseCondition()
    {
        if ($this->baseCondition == null) {
            $criteria = new \CDbCriteria();
            $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';
            $command = \Yii::app()->getDb()->createCommand();
            $command->from('EventSectionLinkUser')->select('UserId')
                ->join('EventSection', '"EventSectionLinkUser"."SectionId" = "EventSection"."Id"')
                ->where('"EventSection"."EventId" = :EventId')
                ->group('UserId');
            $this->baseCondition = $command->getText();
        }
        return $this->baseCondition;
    }
} 