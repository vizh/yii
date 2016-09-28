<div class="container">
  <h2><?=\Yii::t('demo2013', 'Ссылки для экпонентов')?></h2>
  <div class="row">
    <div class="span9">
    <?foreach($products as $product):?>
      <div class="m-bottom_30" <?if($product->Id !== 738):?>style="-moz-opacity: 0.2; -khtml-opacity: 0.2; opacity: 0.2;"<?endif?>>
        <h4><?=\Yii::t('demo2013', $product->Title)?>, <?=$product->GetPrice()?> <?=\Yii::t('app', 'руб.')?></h4>
        <?php
          $timestamp = time();
          $urlparams = array(
            'T' => $timestamp,
            'Hash' => $this->getProductHash($product, $timestamp),
            'productId' => $product->Id,
            'eventIdName' => $event->IdName
          );
          $url = $this->createAbsoluteUrl('/event/exclusive/demo2013/alley/', $urlparams);
       ?>
        RU: <a href="<?=$url?>"><?=$url?></a><br/>
        <?php
          $urlparams['lang'] = 'en';
          $url = $this->createAbsoluteUrl('/event/exclusive/demo2013/alley/', $urlparams);
       ?>
        EN: <a href="<?=$url?>"><?=$url?></a>
     </div>
    <?endforeach?>
    </div>
  </div>
</div>
