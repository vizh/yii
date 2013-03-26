<div class="container">
  <h2><?=\Yii::t('demo2013', 'Ссылки для экпонентов');?></h2>
  <div class="row">
    <div class="span9">
    <?foreach ($products as $product):?>
      <div style="margin-bottom: 30px;">
        <h4><?=\Yii::t('demo2013', $product->Title);?>, <?=$product->GetPrice();?> <?=\Yii::t('app', 'руб');?>.</h4>
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
        <a href="<?=$url;?>"><?=$url;?></a>
     </div>
    <?endforeach;?>
    </div>
  </div>
</div>
