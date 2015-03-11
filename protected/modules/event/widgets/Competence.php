<?php
namespace event\widgets;

/**
 * Class Competence
 * @package event\widgets
 *
 * @property int $WidgetCompetenceTestId
 * @property string $WidgetCompetenceErrorKeyMessage
 * @property string $WidgetCompetenceNotAuthMessage
 * @property string $WidgetCompetenceHasResultMessage
 */
class Competence extends \event\components\Widget
{
  private $hasResult = false;

  public function getAttributeNames()
  {
    return [
      'WidgetCompetenceTestId',
      'WidgetCompetenceErrorKeyMessage',
      'WidgetCompetenceNotAuthMessage',
      'WidgetCompetenceHasResultMessage',
    ];
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Опрос на странице мероприятия');
  }

  private $position = null;

  /**
   * @return string
   */
  public function getPosition()
  {
    if ($this->position == null)
    {
      $userKey = \Yii::app()->getRequest()->getParam('userKey');
      if ($this->getTest() == null || $userKey == null || $this->getTest()->getUserKey() == null || \Yii::app()->user->isGuest)
      {
        $this->position = \event\components\WidgetPosition::Content;
      }
      else
      {
        $model = \competence\models\Result::model()
            ->byTestId($this->getTest()->Id)->byUserKey($this->getTest()->getUserKey())->byFinished(true);
        if ($model->exists())
        {
          $this->position = \event\components\WidgetPosition::Content;
          $this->hasResult = true;
        }
        else
        {
          $this->position = \event\components\WidgetPosition::FullWidth;
        }
      }
    }
    return $this->position;
  }

  private $test = null;

  public function getTest()
  {
    if ($this->test == null)
    {
      $this->test = \competence\models\Test::model()->findByPk($this->WidgetCompetenceTestId);
      if (!\Yii::app()->user->isGuest && $this->test != null)
      {
        $this->test->setUser(\Yii::app()->user->getCurrentUser());
      }
    }
    return $this->test;
  }

  /** @var \competence\models\Question[] */
  public $questions = [];

  public function init()
  {
    parent::init();
    if ($this->getTest() == null)
      return;

    $question = $this->getTest()->getFirstQuestion();
    while(true)
    {
      $this->questions[] = $question;
      /** @var \competence\models\Question $question */
      $question = $question->getForm()->getNext();
      if ($question == null)
        break;
      $question->setTest($this->getTest());
    }
  }

  public function process()
  {
    $request = \Yii::app()->getRequest();
    $test = $request->getParam('CompetenceTest');
    if ($request->getIsPostRequest() && $test != null && count($this->questions) > 0)
    {
      $hasErrors = false;
      foreach ($this->questions as $question)
      {
        $form = $question->getForm();
        $form->setAttributes($request->getParam(get_class($form)), false);
        if (!$form->process())
          $hasErrors = true;
      }

      if (!$hasErrors)
      {
        $this->getTest()->saveResult();

        //todo: только для TC2013
        $productId = null;
        $userKey = $this->getTest()->getUserKey();
        if (strpos($userKey, 'wp') === 0)
        {
          $productId = 1440;
        }
        elseif (strpos($userKey, 'np') === 0)
        {
          $productId = 1441;
        }
        elseif (strpos($userKey, 'bs') === 0)
        {
          $productId = 1442;
        }
        $model = \pay\models\ProductUserAccess::model()->byUserId(\Yii::app()->user->getCurrentUser()->Id);
        if ($productId != null && !$model->byProductId([$productId])->exists())
        {
          $productAccess = new \pay\models\ProductUserAccess();
          $productAccess->ProductId = $productId;
          $productAccess->UserId = \Yii::app()->user->getCurrentUser()->Id;
          $productAccess->save();
        }
        //todo: конец блока

        $this->getController()->redirect(\Yii::app()->createUrl('/event/view/index', ['idName' => $this->event->IdName]));
      }
    }
  }


  public function run()
  {
    $userKey = \Yii::app()->getRequest()->getParam('userKey');
    if ($this->getTest() == null || $userKey == null)
    {
      return;
    }

    if ($this->getTest()->getUserKey() == null)
    {
      $this->render('competence-errorkey');
      return;
    }

    if (\Yii::app()->user->isGuest)
    {
      $this->render('competence-notauth');
      return;
    }

    if ($this->hasResult)
    {
      $this->render('competence-hasresult');
      return;
    }

    $cs = \Yii::app()->clientScript;
    $manager = \Yii::app()->getAssetManager();
    $path = \Yii::getPathOfAlias('competence.assets');
    $cs->registerCssFile($manager->publish($path . '/css/competence.css'));
    \Yii::app()->getClientScript()->registerScriptFile($manager->publish($path . '/js/module.js'), \CClientScript::POS_END);

    $this->render('competence', ['test' => $this->getTest()]);
  }


}