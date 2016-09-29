<?php
/**
 * @var application\components\controllers\MainController $this
 */

$clientScript = \Yii::app()->getClientScript();
$clientScript->registerCssFile('//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
$clientScript->registerScriptFile(
    \Yii::app()->getAssetManager()->publish(
        \Yii::getPathOfAlias('oauth.assets.js').DIRECTORY_SEPARATOR.'module.js'
    )
);
$clientScript->registerScript('oauth', '
  function fillOAuthUrls(oauth) {
    oauth.vkUrl  = "' . $this->createUrl('') . '"
  }
', CClientScript::POS_HEAD);


$this->setPageTitle('Индекс цифровой грамотности 2015');
?>

<div class="container interview m-top_30 m-bottom_40">
  <div class="span8 offset2 text-center">
    <h3>Дорогие друзья!</h3>
    <p>В настоящее время мы активно работаем над измерением индекса цифровой грамотности жителей России.</p>
    <p>Мы хотим услышать ваше мнение о том, какие сервисы и услуги вы потребляете в Интернете, что для вас важно и каких проектов не хватает. Цифровая грамотность — это набор знаний, умений и навыков, которые необходимы для жизни в современном мире, для безопасного и эффективного использования технологий и ресурсов интернета.</p>
    <p>Ответьте, пожалуйста, на вопросы анкеты. Это займет у вас не более 3 минут.</p>
    <p class="text-center">
      <?=\CHtml::link('Войти через <i class="fa fa-vk"></i>', ['', 'connect' => true], ['class' => 'btn btn-large btn-primary', 'id' => 'vk_login'])?>
    </p>
    <p>Заранее благодарим, нам важно знать ваше мнение!</p>
  </div>
</div>
