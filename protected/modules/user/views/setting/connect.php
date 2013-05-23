<?=$this->renderPartial('parts/title');?>
<div class="user-account-settings">
  <div class="clearfix">
    <div class="container">
      <div class="row">
        <div class="span3">
          <?=$this->renderPartial('parts/nav', array('current' => $this->getAction()->getId()));?>
        </div>
        <div class="span9">
          <?=\CHtml::beginForm('', 'POST', array('class' => 'b-form'));?>
            <?foreach ($connects as $socialId => $isConnect):?>
              <div class="row m-bottom_20">
                <?if ($socialId == \oauth\components\social\ISocial::Facebook):?>
                  <div class="span3">
                    <a href="http://facebook.com" class="btn btn-link" target="_blank"><i class="ico16 ico16_social ico16_social__facebook"></i>&nbsp;Facebook</a>
                  </div>
                  <div class="span2">
                    <?if (!$isConnect):?>
                      <a href="#" id="fb_login" class="btn btn-success"><?=\Yii::t('app', 'Привязать');?></a>
                    <?else:?>
                      
                    <?endif;?>
                  </div>
                <?elseif ($socialId == \oauth\components\social\ISocial::Vkontakte):?>
                  <div class="span3">
                    <a href="http://vk.com" class="btn btn-link" target="_blank"><i class="ico16 ico16_social ico16_social__vkontakte"></i>&nbsp;Вконтакте</a>
                  </div>
                  <div class="span2">
                    <?if (!$isConnect):?>
                      <a href="<?=$this->createUrl('/oauth/social/connect', array('social' => \oauth\components\social\ISocial::Vkontakte));?>" id="vk_login" class="btn btn-success"><?=\Yii::t('app', 'Привязать');?></a>
                    <?else:?>
                      
                    <?endif;?>
                  </div>
                <?elseif ($socialId == \oauth\components\social\ISocial::Twitter):?>
                  <div class="span3">
                    <a href="http://twitter.com" class="btn btn-link" target="_blank"><i class="ico16 ico16_social ico16_social__twitter"></i>&nbsp;Twitter</a>
                  </div>
                  <div class="span2">
                    <?if (!$isConnect):?>
                      <a href="<?=$this->createUrl('/oauth/social/connect', array('social' => \oauth\components\social\ISocial::Twitter));?>" id="twi_login" class="btn btn-success"><?=\Yii::t('app', 'Привязать');?></a>
                    <?else:?>
                      
                    <?endif;?>
                  </div>
                <?endif;?>
              </div>
            <?endforeach;?>
          <?=\CHtml::endForm();?>
        </div>
      </div>
    </div>
  </div>
</div>
