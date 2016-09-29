<section id="section" role="main">
  <div class="container m-top_40">
    <div class="row">
      <div class="offset2 span8">


        <div class="alert alert-error">
          <p><?=Yii::t('app', 'У вас нет не оплаченных товаров, для создания квитанции на оплату.')?></p>
        </div>

        <div class="control-group">
          <div class="controls">
            <div class="row">
              <div class="span2">
                <a class="btn" href="<?=$this->createUrl('/pay/cabinet/index')?>">
                  <i class="icon-circle-arrow-left"></i>
                  <?=\Yii::t('app', 'Назад')?>
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


</section>
