<?
/**
 * @var $done bool
 * @var $test \competence\models\Test
 */

/** @var \competence\models\Result $result */
$result = \competence\models\Result::model()
    ->byTestId($test->Id)->byUserId(Yii::app()->user->getCurrentUser()->Id)->find();
$fullData = $result !== null ? $result->getResultByData() : null;

$name = get_class(new \competence\models\tests\mailru2013\C6($test));
?>

<div class="row">
  <div class="span8 offset2 m-top_30 text-center">
    <p class="lead">БОЛЬШОЕ СПАСИБО ЗА УЧАСТИЕ В НАШЕМ ИССЛЕДОВАНИИ!</p>
    <?if (isset($fullData[$name])):?>
    <p>Вы успели ответить на вопросы до 20 сентября. Не позднее чем 25 сентября мы пришлем Вам промо-код на 25% скидку на Профессиональное участие в  RIW-2013.</p>
    <?endif;?>
  </div>
</div>